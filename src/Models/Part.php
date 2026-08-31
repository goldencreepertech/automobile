<?php

namespace Automobile\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $casts = [
        'details' => 'array',
    ];

    protected $fillable = [
        'name',
        'part_number',
        'category',
        'details',
    ];

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class);
    }
}
