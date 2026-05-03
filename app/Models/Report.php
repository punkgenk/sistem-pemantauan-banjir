<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id', 'title', 'category', 'water_height',
    'description', 'latitude', 'longitude', 'address', 'photo', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function histories()
    {
        return $this->hasMany(ReportStatusHistory::class);
    }
}

