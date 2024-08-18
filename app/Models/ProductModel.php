<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'id',
        'product_id',
        'product_name_ar',
        'product_name_en    ',
        'barcode',
        'category_id',
        'unit_id',
        'product_status'
    ];

    public function category(){
        return $this->belongsTo(CategoryProductModel::class,'category_id','id');
    }

    public function unit(){
        return $this->belongsTo(UnitsModel::class,'unit_id','id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItemsModel::class ,'product_id', 'id');
    }

    public function invoiceItems(){
        return $this->hasMany(InvoiceItemsModel::class,'item_id','id')
        ->whereIn('invoice_id',function($query){
            $query->select('id')->from('bfo_invoices')->where('status','stage');
        });
    }

    public function orderSalesItems(){
        return $this->hasMany(OrdersSalesItemsModel::class,'product_id','id');
    }

    public function returnsItems(){
        return $this->hasMany(ReturnItemsModel::class,'product_id','id')
        ->whereIn('invoice_id',function($query){
            $query->select('id')->from('returns')->where('status','stage');
        });
    }
}
