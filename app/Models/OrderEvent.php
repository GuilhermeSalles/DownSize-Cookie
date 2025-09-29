<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderEvent extends Model
{
    public $timestamps = false; // migration usa created_at useCurrent()
    protected $table = 'order_events';

    protected $fillable = [
        'order_id',
        'old_status',
        'new_status',
        'note',
        'created_at',
    ];

    protected $casts = [
        'order_id'   => 'integer',
        'created_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
