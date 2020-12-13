<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'created_by', 'employee_id', 'attendance_date', 'check_in', 'check_out', 'total_hours', 'overtime_hours', 'late_entry',
    ];
}