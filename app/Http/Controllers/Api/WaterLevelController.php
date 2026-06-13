<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;

class WaterLevelController extends Controller
{
    /*
    |------------------------------------------------------------------
    | Tabel water_levels kosong (hanya id + timestamps di migration).
    | Sesuai WaterLevelController web lama, data diambil dari
    | tabel reports — ini yang sudah jalan di web.
    |------------------------------------------------------------------
    */

    // GET /api/water-levels
    public function index()
    {
        $reports = Report::with('user')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest()
            ->get()
            ->map(fn ($r) => [
                'id'           => $r->id,
                'title'        => $r->title,
                'address'      => $r->address ?? '-',
                'latitude'     => $r->latitude,
                'longitude'    => $r->longitude,
                'water_height' => $r->water_height,
                'category'     => $r->category,
                'status'       => $r->status,
                'photo_url'    => $r->photo ? Storage::url($r->photo) : null,
                'created_at'   => $r->created_at,
                'user'         => $r->user ? [
                    'id'   => $r->user->id,
                    'name' => $r->user->name,
                ] : null,
            ]);

        return response()->json(['data' => $reports]);
    }
}
