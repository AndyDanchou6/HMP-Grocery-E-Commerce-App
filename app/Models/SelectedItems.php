<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Inventory;
use App\Models\ServiceFee;

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
        'fb_link',
        'courier_id',
        'payment_type',
        'service_fee_id',
        'reasonForDenial',
        'payment_condition',
        'proof_of_delivery',
        'order_retrieval',
        'delivery_date',
        'service_fee',
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

    public function serviceFee()
    {
        return $this->belongsTo(ServiceFee::class, 'service_fee_id');
    }
}
