<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'product_name',
        'product_img',
        'price',
        'quantity'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'selected_items', 'user_id', 'item_id');
    }
}
