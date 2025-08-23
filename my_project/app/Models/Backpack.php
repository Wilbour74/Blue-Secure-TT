<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Backpack extends Model
{
    protected $fillable = ['max_weight', 'max_volume', 'weight', 'volume'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
