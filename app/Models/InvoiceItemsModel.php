<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItemsModel extends Model
{
    use HasFactory;

    protected $table = 'bfo_invoice_items';
}
