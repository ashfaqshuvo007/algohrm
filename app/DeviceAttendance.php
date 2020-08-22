<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceAttendance extends Model
{
    protected $fillable = [
        'uuid', 'employee_id', 'device_id', 'state', 'date_time',

    ];
    public function device()
    {
        return $this->belongsTo(\App\Device::class);
    }
}