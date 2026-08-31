<?php

namespace Automobile\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    use HasFactory;

    protected $table = 'models';

    protected $fillable = [
        'manufacturer_id',
        'name',
    ];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class, 'model_id');
    }
}
