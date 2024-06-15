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
    ];
}
