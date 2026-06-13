<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('user')->latest()->get();
        $reports = Report::with('user')->latest()->paginate(10); 
        return view('admin.reports', compact('reports'));
    }

    public function show(Report $report)
    {
        return view('admin.report-show', compact('report'));
    }

    public function updateStatus(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:pending,batal,selesai'
        ]);

        $report->update([
            'status' => $request->status
        ]);

        return back()->with('success','Status laporan diperbarui');
    }

    public function destroy(Report $report)
    {
        // hapus foto jika ada
        if ($report->photo) {
            Storage::disk('public')->delete($report->photo);
        }

        $report->delete();

        return redirect()
            ->route('admin.reports')
            ->with('success','Laporan berhasil dihapus');
    }
}