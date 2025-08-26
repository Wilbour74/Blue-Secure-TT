<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Backpack;

class Item extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'type',
        'name',       
        'description',
        'weight',      
        'volume',    
        'quantity',
        'quantity_cl',  
        'wear',      
        'backpack_id'
    ];

    public function backpack()
    {
        return $this->belongsTO(Backpack::class);
    }
}
