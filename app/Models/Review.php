<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'comment',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'name', 'id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'product_id', 'id');
    }
}
