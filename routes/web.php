<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\WaterLevelController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ChatbotController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));

/*
|--------------------------------------------------------------------------
| AUTH (BREEZE)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| OTP
|--------------------------------------------------------------------------
*/
// Route::middleware('auth')->group(function () {
//     Route::get('/otp', fn () => view('auth.otp'))->name('otp.form');
//     Route::post('/otp/verify', [OtpController::class, 'verify'])->name('otp.verify');
// });


// routes/web.php
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ConversationController::class, 'index'])->name('chat.index');
    Route::get('/chat/{user}', [ConversationController::class, 'show'])->name('chat.show');
    Route::post('/chat/{conversation}', [MessageController::class, 'store'])->name('chat.store');
    Route::post('/chatbot/ask', [ChatbotController::class, 'ask'])->name('chatbot.ask');

});


/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/dashboard', function () {
    return auth()->user()->role === 'pemerintah'
        ? redirect()->route('dashboard.pemerintah')
        : redirect()->route('dashboard.masyarakat');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| DASHBOARD MASYARAKAT
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:masyarakat'])->prefix('masyarakat')->group(function () {

    Route::get('/dashboard',
        [DashboardController::class, 'masyarakat']
    )->name('dashboard.masyarakat');

   Route::middleware(['auth','role:masyarakat'])->prefix('masyarakat')->group(function () {

    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

    Route::get('/reports/create', [ReportController::class, 'create'])
        ->name('reports.create');

    Route::post('/reports', [ReportController::class, 'store'])
        ->name('reports.store');
});

});

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD PEMERINTAH
        |--------------------------------------------------------------------------
        */
Route::middleware(['auth','role:pemerintah'])
            ->prefix('admin')
            ->group(function () {

    Route::get('/dashboard',
            [DashboardController::class, 'pemerintah']
        )->name('dashboard.pemerintah');

    Route::get('/reports',
            [AdminReportController::class   , 'index']
        )->name('admin.reports');

    Route::get('/reports/{report}',
            [AdminReportController::class, 'show']
        )->name('admin.reports.show');

    Route::post('/reports/{report}/status',
            [AdminReportController::class, 'updateStatus']
        )->name('admin.reports.updateStatus');
        
    Route::delete('/reports/{report}',
            [AdminReportController::class, 'destroy']
        )->name('admin.reports.destroy');

});

Route::middleware('auth')->group(function () {

    Route::get('/water-levels',
        [WaterLevelController::class, 'index']
    )->name('water-levels.index');

});


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/
Route::fallback(fn () => abort(404));


