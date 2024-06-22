<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'district',
        'electorate',
        'candidate',
        'description',
        'report_category',
        'type',
        // Add other fields as needed
    ];

    public function mainstream()
    {
        return $this->hasOne(Mainstream::class);
    }
}
