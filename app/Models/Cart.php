<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'name', 'id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'product_name', 'price', 'id');
    }
}
