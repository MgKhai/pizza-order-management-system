<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $fillable = ['name','phone','address','payslip_image','payment_method','order_code','total_amt'];
}
