<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminReportController extends Controller
{
    /*
    |------------------------------------------------------------------
    | Status valid: pending | selesai | batal
    | (sesuai enum di migration)
    |------------------------------------------------------------------
    */

    // GET /api/admin/reports?status=pending&q=keyword
    public function index(Request $request)
    {
        $query = Report::with('user')->latest();

        // Filter status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        // Search keyword
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('address', 'like', "%{$q}%")
                      ->orWhereHas('user', fn ($u) =>
                            $u->where('name', 'like', "%{$q}%")
                              ->orWhere('email', 'like', "%{$q}%")
                        );
            });
        }

        return response()->json([
            'data' => $query->get()->map(fn ($r) => $this->format($r)),
        ]);
    }

    // GET /api/admin/reports/{report}
    public function show(Report $report)
    {
        return response()->json([
            'data' => $this->format($report->load('user')),
        ]);
    }

    // POST /api/admin/reports/{report}/status
    public function updateStatus(Request $request, Report $report)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,selesai,batal',
        ]);

        $report->update(['status' => $data['status']]);

        return response()->json([
            'message' => 'Status laporan berhasil diperbarui.',
            'data'    => $this->format($report->load('user')),
        ]);
    }

    // DELETE /api/admin/reports/{report}
    public function destroy(Report $report)
    {
        if ($report->photo) {
            Storage::disk('public')->delete($report->photo);
        }

        $report->delete();

        return response()->json(['message' => 'Laporan berhasil dihapus.']);
    }

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
