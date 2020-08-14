<?php

namespace App\Http\Controllers;

use \ZKLib\ZKLib;

class DeviceAttendanceController extends Controller
{
    // Get Device Users
    public function getDeviceUsers()
    {
        //Emloyee details from Device
        $zklib = new ZKLib('192.168.0.201', 4370, 'TCP');
        $zklib->connect();

        $zklib->disableDevice();
        $deviceUsers = $zklib->getUser();

        $zklib->enableDevice();
        $zklib->disconnect();

    }
    //Get device attendance
    public function deviceAttendance()
    {
        $zklib = new ZKLib('192.168.0.201', 4370, 'TCP');
        $zklib->connect();

        echo "Device Attendance";
        $zklib->disableDevice();

        // $version = $zklib->getVersion();
        // $users = $zklib->getUser();
        $attendace = $zklib->getAttendance();
        dump($attendace);
        // dd($attendace);

        $zklib->enableDevice();
        $zklib->disconnect();
    }
}