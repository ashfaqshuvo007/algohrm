<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'id', 'device_name', 'serial_number', 'device_version', 'device_ip_hidden', 'device_ip_internal', 'device_port_public_h', 'created_by',
    ];

    public function device_attendance()
    {
        return $this->hasMany(\App\DeviceAttendance::class);
    }

}