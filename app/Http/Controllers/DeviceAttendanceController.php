<?php

namespace App\Http\Controllers;

use \ZKLib\ZKLib;

class DeviceAttendanceController extends Controller
{
    //
    public function deviceAttendance()
    {
        $zklib = new ZKLib('192.168.0.201', 4370, 'TCP');
        $zklib->connect();

        echo "Device Attendance";
        $zklib->disableDevice();
        $version = $zklib->getVersion();
        $users = $zklib->getUser();
        $attendace = $zklib->getAttendance();
        //  dump($users);
        // dd($attendace);

        $zklib->enableDevice();
        $zklib->disconnect();
    }
}