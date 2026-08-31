<?php

namespace Automobile\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function models()
    {
        return $this->hasMany(VehicleModel::class);
    }
}
