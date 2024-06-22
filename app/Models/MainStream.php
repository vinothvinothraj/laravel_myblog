<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainStream extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'type',
        'cost',
        'other_details',
        // Add other fields as needed
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function tvAdvertisements()
    {
        return $this->hasMany(TvAdverts::class);
    }
}
