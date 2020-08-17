<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'created_by', 'user_id', 'employee_type', 'basic_salary', 'house_rent', 'medical_allowance', 'food_allowance', 'convayance', 'absent_deduction', 'activation_status',
    ];
}