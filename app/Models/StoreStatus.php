<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreStatus extends Model
{
    protected $table = 'store_status';
    public $timestamps = false;
    protected $fillable = ['is_open'];
}
