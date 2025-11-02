<?php

namespace App\Models;

use App\Models\AddonItem;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id','product_id','size_id','qty'];


    public function addOnItems(){

        return $this->belongsToMany(AddonItem::class, 'items_carts', 'cart_id', 'addon_item_id')->withTimestamps();

    }
}
