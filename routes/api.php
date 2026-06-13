<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\AdminReportController;
use App\Http\Controllers\Api\WaterLevelController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes — Sistem Pemantauan Banjir
| Base URL  : /api
| Auth      : Laravel Sanctum (token-based)
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| PUBLIC — tidak butuh login
|--------------------------------------------------------------------------
*/
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


/*
|--------------------------------------------------------------------------
| PROTECTED — butuh token Sanctum
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    /*
    |----------------------------------------------------------------------
    | AUTH
    |----------------------------------------------------------------------
    | POST   /api/logout       → hapus token aktif
    | GET    /api/user          → data user yang sedang login
    */
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user',    [AuthController::class, 'me']);

    /*
    |----------------------------------------------------------------------
    | PROFILE
    |----------------------------------------------------------------------
    | GET    /api/profile       → tampilkan profil
    | PATCH  /api/profile       → update nama & email
    | DELETE /api/profile       → hapus akun
    */
    Route::get('/profile',    [ProfileController::class, 'show']);
    Route::patch('/profile',  [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);

    /*
    |----------------------------------------------------------------------
    | WATER LEVELS (semua role bisa akses)
    |----------------------------------------------------------------------
    | GET    /api/water-levels  → list semua data tinggi air
    */
    Route::get('/water-levels', [WaterLevelController::class, 'index']);

    /*
    |----------------------------------------------------------------------
    | CHAT / PESAN (semua role bisa akses)
    |----------------------------------------------------------------------
    | GET    /api/chat                      → list conversation milik user
    | GET    /api/chat/{userId}             → buka/buat conversation dengan user
    | GET    /api/chat/{convId}/messages    → list pesan dalam conversation
    | POST   /api/chat/{convId}             → kirim pesan baru
    */
    Route::get('/chat',                          [ConversationController::class, 'index']);
    Route::get('/chat/{user}',                   [ConversationController::class, 'show']);
    Route::get('/chat/{conversation}/messages',  [MessageController::class, 'index']);
    Route::post('/chat/{conversation}',          [MessageController::class, 'store']);

    /*
    |----------------------------------------------------------------------
    | REPORTS — MASYARAKAT
    |----------------------------------------------------------------------
    | GET    /api/reports        → laporan milik user sendiri
    | POST   /api/reports        → buat laporan baru (multipart/form-data)
    | GET    /api/reports/{id}   → detail laporan sendiri
    | DELETE /api/reports/{id}   → hapus laporan sendiri
    */
    Route::middleware('role:masyarakat')->group(function () {
        Route::get('/reports',          [ReportController::class, 'index']);
        Route::post('/reports',         [ReportController::class, 'store']);
        Route::get('/reports/{report}', [ReportController::class, 'show']);
        Route::delete('/reports/{report}', [ReportController::class, 'destroy']);
    });

    /*
    |----------------------------------------------------------------------
    | ADMIN REPORTS — PEMERINTAH
    |----------------------------------------------------------------------
    | GET    /api/admin/reports              → semua laporan (bisa filter ?status=)
    | GET    /api/admin/reports/{id}         → detail laporan manapun
    | POST   /api/admin/reports/{id}/status  → update status laporan
    | DELETE /api/admin/reports/{id}         → hapus laporan manapun
    */
    Route::middleware('role:pemerintah')->prefix('admin')->group(function () {
        Route::get('/reports',                        [AdminReportController::class, 'index']);
        Route::get('/reports/{report}',               [AdminReportController::class, 'show']);
        Route::post('/reports/{report}/status',       [AdminReportController::class, 'updateStatus']);
        Route::delete('/reports/{report}',            [AdminReportController::class, 'destroy']);
    });

});
