<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingHoursModel extends Model
{
    use HasFactory;

    protected $table = 'working_hours';

    protected $fillable = [
        'employee_id','day'
    ];
}
