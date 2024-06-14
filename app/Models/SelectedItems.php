<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'referenceNo',
        'user_id',
        'item_id',
    ];
}
