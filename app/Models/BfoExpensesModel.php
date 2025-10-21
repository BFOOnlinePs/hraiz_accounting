<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BfoExpensesModel extends Model
{
    use HasFactory;

    protected $table = 'bfo_expenses';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function expensesCategory()
    {
        return $this->belongsTo(BfoExpenseCategoriesModel::class, 'category_id');
    }
}
