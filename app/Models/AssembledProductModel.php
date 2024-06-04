<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssembledProductModel extends Model
{
    use HasFactory;

    protected $table = 'assembled_product';

    protected $fillable = [
        'product_id'
    ];
}
