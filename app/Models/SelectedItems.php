<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Inventory;

class SelectedItems extends Model
{
    use HasFactory;

    protected $table = 'selected_items';

    protected $fillable = [
        'referenceNo',
        'user_id',
        'item_id',
        'status',
        'quantity',
        'phone',
        'address',
        'fb_link',
        'courier_id',
        'payment_type',
        'payment_condition',
        'proof_of_delivery',
        'order_retrieval',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courier()
    {
        return $this->belongsTo(User::class, 'courier_id');
    }
}
