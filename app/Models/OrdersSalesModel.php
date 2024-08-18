<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersSalesModel extends Model
{
    use HasFactory;

    protected $table = 'orders_sales';

    public function order_sales_items(){
        return $this->hasMany(OrdersSalesItemsModel::class , 'order_id' ,'id');
    }

    public function user(){
        return $this->belongsTo(User::class , 'user_id' ,'id');
    }

    public function getTotalSumAttribute()
    {
        return $this->order_sales_items->sum(function($item) {
            return $item->price * $item->qty;
        });
    }
}
