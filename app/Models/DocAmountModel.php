<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocAmountModel extends Model
{
    use HasFactory;

    protected $table = 'doc_amount';

    public function invoice(){
        return $this->belongsTo(PurchaseInvoicesModel::class, 'invoice_id', 'id');
    }

    public function currency_info(){
        return $this->belongsTo(CurrencyModel::class, 'currency', 'id');
    }

    public function invoice_items(){
        return $this->belongsTo(InvoiceItemsModel::class, 'id', 'invoice_id');
    }
}
