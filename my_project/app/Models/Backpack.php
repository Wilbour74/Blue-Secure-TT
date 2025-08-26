<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Item;

class Backpack extends Model
{
    use HasFactory;
    protected $fillable = ['max_weight', 'max_volume', 'weight', 'volume'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
