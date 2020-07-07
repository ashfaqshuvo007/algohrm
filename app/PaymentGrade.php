<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentGrade extends Model
{
    protected $fillable = [
        'grade', 'basic_salary', 'overtime_rate', 'min_overtime_hrs', 'activation_status',
    ];

    public function designation()
    {
        return $this->hasMany(\App\Designation::class);
    }
}
