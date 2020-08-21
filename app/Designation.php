<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{

    protected $fillable = [
        'created_by', 'grade_id', 'department_id', 'designation', 'publication_status', 'designation_description',
    ];

    public function paymentgrade()
    {
        return $this->belongsTo(\App\PaymentGrade::class);
    }
}