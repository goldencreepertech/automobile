<?php

namespace Automobile\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'name',
    ];

    public function model()
    {
        return $this->belongsTo(VehicleModel::class, 'model_id');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
