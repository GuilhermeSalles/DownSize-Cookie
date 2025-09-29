<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_address',
        'service_type',
        'delivery_zone_id',
        'delivery_city_text',
        'delivery_fee',
        'delivery_day',
        'delivery_time',
        'pickup_day',
        'pickup_time',
        'payment_method',
        'customer_observation',
        'addon_observation',
        'subtotal',
        'addons_total',
        'delivery_total',
        'total',
        'status',
    ];

    protected $casts = [
        'delivery_zone_id'   => 'integer',
        'delivery_fee'       => 'decimal:2',
        'subtotal'           => 'decimal:2',
        'addons_total'       => 'decimal:2',
        'delivery_total'     => 'decimal:2',
        'total'              => 'decimal:2',
        'delivery_time'      => 'datetime:H:i',
        'pickup_time'        => 'datetime:H:i',
        'created_at'         => 'datetime',
        'updated_at'         => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(OrderEvent::class);
    }

    public function deliveryZone(): BelongsTo
    {
        return $this->belongsTo(DeliveryZone::class, 'delivery_zone_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
    public function recalcTotals(): void
    {
        $subtotal = $this->items()->sum('line_total');
        $this->subtotal       = $subtotal;
        $this->total          = $subtotal + (float)$this->addons_total + (float)$this->delivery_total;
        $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
