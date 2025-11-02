<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id','product_id','count','size_id','status','order_code'];

    public function addOnItems(){

        return $this->belongsToMany(AddonItem::class, 'items_orders', 'order_id', 'addon_item_id')->withTimestamps();

    }
}