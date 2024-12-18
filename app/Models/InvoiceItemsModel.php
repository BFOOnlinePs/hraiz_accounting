<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItemsModel extends Model
{
    use HasFactory;

    protected $table = 'bfo_invoice_items';

    public function invoice()
    {
        return $this->belongsTo(PurchaseInvoicesModel::class, 'invoice_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'item_id', 'id');
    }
}
