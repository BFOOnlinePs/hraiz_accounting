<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BondsModel extends Model
{
    use HasFactory;

    protected $table = 'bonds';

    public function currency(){
        return $this->belongsTo(CurrencyModel::class, 'currency_id', 'id');
    }

    public function bank(){
        return $this->belongsTo(BankModel::class, 'bank_id', 'id');
    }


    public function client(){
        return $this->belongsTo(User::class, 'client_id', 'id');
    }
}
