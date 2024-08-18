<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersSalesItemsModel extends Model
{
    use HasFactory;

    protected $table = 'orders_sales_items';

    public function product(){
        return $this->belongsTo(ProductModel::class,'product_id','id');
    }
}
