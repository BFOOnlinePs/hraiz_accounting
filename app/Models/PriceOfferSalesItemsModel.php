<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceOfferSalesItemsModel extends Model
{
    use HasFactory;

    protected $table = 'price_offer_sales_item';

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'id');
    }
}
