<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /*
    |------------------------------------------------------------------
    | Kolom tabel reports (dari migration):
    | id, user_id, title, description, photo, latitude, longitude,
    | address, status (pending|selesai|batal),
    | category (genangan|banjir_sedang|banjir_parah), water_height
    |------------------------------------------------------------------
    */

    // GET /api/reports — laporan milik user sendiri
    public function index(Request $request)
    {
        $reports = Report::with('user')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get()
            ->map(fn ($r) => $this->format($r));

        return response()->json(['data' => $reports]);
    }

    // POST /api/reports — buat laporan baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'address'      => 'nullable|string|max:500',
            'latitude'     => 'required|numeric',
            'longitude'    => 'required|numeric',
            'category'     => 'required|in:genangan,banjir_sedang,banjir_parah',
            'water_height' => 'nullable|numeric|min:0|max:9999',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('reports', 'public');
        }

        $report = Report::create([
            'user_id'      => $request->user()->id,
            'title'        => $data['title'],
            'description'  => $data['description'],
            'address'      => $data['address'] ?? null,
            'latitude'     => $data['latitude'],
            'longitude'    => $data['longitude'],
            'category'     => $data['category'],
            'water_height' => $data['water_height'] ?? null,
            'photo'        => $photoPath,
            'status'       => 'pending',
        ]);

        return response()->json([
            'message' => 'Laporan berhasil dikirim.',
            'data'    => $this->format($report->load('user')),
        ], 201);
    }

    // GET /api/reports/{report}
    public function show(Request $request, Report $report)
    {
        if ($report->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        return response()->json(['data' => $this->format($report->load('user'))]);
    }

    // DELETE /api/reports/{report}
    public function destroy(Request $request, Report $report)
    {
        if ($report->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        if ($report->photo) {
            Storage::disk('public')->delete($report->photo);
        }

        $report->delete();

        return response()->json(['message' => 'Laporan berhasil dihapus.']);
    }

    // Format response agar konsisten ke Flutter
    private function format(Report $r): array
    {
        return [
            'id'           => $r->id,
            'user_id'      => $r->user_id,
            'title'        => $r->title,
            'description'  => $r->description,
            'address'      => $r->address,
            'latitude'     => $r->latitude,
            'longitude'    => $r->longitude,
            'category'     => $r->category,
            'water_height' => $r->water_height,
            'photo_url'    => $r->photo ? Storage::url($r->photo) : null,
            'status'       => $r->status,
            'created_at'   => $r->created_at,
            'updated_at'   => $r->updated_at,
            'user'         => $r->user ? [
                'id'    => $r->user->id,
                'name'  => $r->user->name,
                'email' => $r->user->email,
                'role'  => $r->user->role,
            ] : null,
        ];
    }
}
