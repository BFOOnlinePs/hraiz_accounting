<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BfoAttendance extends Model
{
    use HasFactory;
    protected $table = 'bfo_attendance';
    protected $fillable = ['status', 'user_id', 'in_time', 'out_time']; 
}
