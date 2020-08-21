<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceAttendance extends Model
{
    protected $fillable = [
        'uuid', 'employee_id', 'state', 'date', 'in_time', 'out_time', 'ot_time_in', 'ot_time_out',

    ];
    public function device()
    {
        return $this->belongsTo(\App\Device::class);
    }
}