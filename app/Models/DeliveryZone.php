<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryZone extends Model
{
    public $timestamps = false; // migration não criou timestamps
    protected $table = 'delivery_zones';

    protected $fillable = [
        'name',
        'base_fee',
        'miles_limit',
        'extra_per_mile',
        'active',
    ];

    protected $casts = [
        'base_fee'       => 'decimal:2',
        'miles_limit'    => 'integer',
        'extra_per_mile' => 'decimal:2',
        'active'         => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
