<?php

namespace App\Http\Controllers;

use App\Models\WaterLevel;
use App\Models\Report;
use Illuminate\Http\Request;

class WaterLevelController extends Controller
{
public function index()
{
    $query = Report::with('user');

    $reports = $query->paginate(5);

    $reportMarkers = $reports->map(function($r){
        return [
            'id' => $r->id,
            'title' => $r->title,
            'name' => $r->user->name ?? '-',
            'address' => $r->address ?? '-',
            'status' => $r->status,
            'lat' => $r->latitude,
            'lng' => $r->longitude,
        ];
    });

    return view('water-levels.index', [
        'reports' => $reports,
        'reportMarkers' => $reportMarkers,
    ]);
}

}
