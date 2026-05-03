<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Events\NewReportNotification;

class ReportController extends Controller
{
    /**
     * Daftar laporan milik user
     */
    public function index()
{
    $reports = Report::where('user_id', auth()->id())
                     ->latest()
                     ->paginate(5);

    return view('reports.index', compact('reports'));
}

    /**
     * Form buat laporan
     */
  public function create()
{
   $reports = Report::where('user_id', auth()->id())
                     ->latest()
                     ->paginate(5); 

    return view('reports.create', compact('reports'));
}

 /**
 * Simpan laporan
 */
public function store(Request $request)
{
    $request->validate([
    'title'        => 'required|string|max:255',
    'category'     => 'required|in:genangan,banjir_sedang,banjir_parah',
    'water_height' => 'nullable|numeric|min:0|max:9999',
    'description'  => 'required|string',
    'latitude'     => 'required|numeric',
    'longitude'    => 'required|numeric',
    'address'      => 'nullable|string|max:500',
    'photo'        => 'nullable|image|max:2048',
    ]);

    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('reports', 'public');
    }

    $report = Report::create([
    'user_id'      => auth()->id(),
    'title'        => $request->title,
    'category'     => $request->category,
    'water_height' => $request->water_height,
    'description'  => $request->description,
    'latitude'     => $request->latitude,
    'longitude'    => $request->longitude,
    'address'      => $request->address,
    'photo'        => $photoPath,
    'status'       => 'pending',
    ]);

    // Trigger event notifikasi ke pemerintah
    event(new NewReportNotification($report));

    return redirect()->route('reports.create')
        ->with('success', 'Laporan berhasil dikirim');
}

    /**
     * Detail laporan
     */
    public function show(Report $report)
    {
        if ($report->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('reports.show', compact('report'));
    }

    /**
     * Update status laporan (pemerintah)
     */
    public function updateStatus(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai',
            'note' => 'nullable|string',
        ]);

        $report->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status laporan diperbarui');
    }
}
