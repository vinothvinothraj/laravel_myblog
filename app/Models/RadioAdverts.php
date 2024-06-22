<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadioAdverts extends Model
{
    use HasFactory;

    protected $fillable = [
        'mainstream_id',
        'name_of_radio_channel',
        'date',
        'time',
        'duration_from',
        'duration_to',
        'repetition',
        'repetition_count',
        'cost',
        'other_details',
        'evidence',
        // Add other fields as needed
    ];

    public function mainstream()
    {
        return $this->belongsTo(Mainstream::class);
    }
}
