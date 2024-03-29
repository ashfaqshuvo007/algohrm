<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentGrade extends Model
{
    protected $fillable = [
        'created_by', 'grade', 'basic_salary', 'yearly_increment_rate', 'house_rent', 'medical_allowance', 'convayence', 'food_allowance',
    ];

    public function designation()
    {
        return $this->hasMany(\App\Designation::class);
    }
}