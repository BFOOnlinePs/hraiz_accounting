<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnsModel extends Model
{
    use HasFactory;

    protected $table = 'returns';

    public function invoice(){
        return $this->belongsTo(PurchaseInvoicesModel::class,'invoice_id');
    }
}
