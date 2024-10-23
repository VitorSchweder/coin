<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    protected $table = 'coins';

    protected $fillable = [
        'name',
        'symbol',
        'current_price',
        'last_updated',
    ];
}
