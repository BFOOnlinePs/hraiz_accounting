<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceOfferSalesModel extends Model
{
    use HasFactory;

    protected $table = 'price_offer_sale';

    public function user()
    {
        return $this->belongsTo(User::class , 'customer_id' , 'id');
    }

    public function orderSales()
    {
        return $this->hasMany(OrdersSalesModel::class , 'price_offer_sales_id' , 'id');
    }
}
