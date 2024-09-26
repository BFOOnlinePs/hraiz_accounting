<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreparationModel extends Model
{
    use HasFactory;

    protected $table = 'preparation';

    public function fromUser(){
        return $this->belongsTo(User::class,'from_user','id');
    }

    public function toUser(){
        return $this->belongsTo(User::class,'to_user','id');
    }

    public function order(){
        return $this->belongsTo(OrdersSalesModel::class,'order_id','id');
    }
}
