<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoicesModel extends Model
{
    use HasFactory;

    protected $table = 'bfo_invoices';

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItemsModel::class, 'invoice_id', 'id'); // Adjust 'invoice_id' if the foreign key is different
    }
    public function totalAmount()
    {
        $total = 0;
        foreach ($this->invoiceItems as $item) {
            $discount = $item->discount ?? 0;
            $itemTotal = $item->quantity * $item->rate;
            $total += $itemTotal - ($itemTotal * $discount / 100);
        }
        return $total;
    }

    public function client(){
        return $this->belongsTo(User::class,'client_id');
    }

    public function unit(){
        return $this->belongsTo(UnitsModel::class,'unit_id');
    }

    public function currency(){
        return $this->belongsTo(CurrencyModel::class,'currency_id');
    }

}
