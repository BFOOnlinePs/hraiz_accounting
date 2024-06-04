<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLevels extends Model
{
    use HasFactory;

    protected $table = 'user_levels';

    protected $fillable = ['user_id','role_id','id'];
}
