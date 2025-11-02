<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemsOrder extends Model
{
    protected $fillable = ['order_id','addon_item_id'];
}
