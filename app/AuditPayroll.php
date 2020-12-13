<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditPayroll extends Model
{
    protected $fillable = [
        'created_by', 'user_id', 'employee_type', 'basic_salary', 'house_rent', 'medical_allowance', 'food_allowance', 'convayence', 'absent_deduction', 'overtime_rate', 'att_bonus', 'activation_status', 'increment_amount',
    ];
}