<?php

namespace Automobile\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $casts = [
        'details' => 'array',
        'launch_date' => 'date',
        'discontinue_date' => 'date',
    ];

    protected $fillable = [
        'variant_id',
        'launch_date',
        'discontinue_date',
        'details',
    ];

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function parts()
    {
        return $this->belongsToMany(Part::class);
    }
}
