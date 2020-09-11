<?php

namespace App\Http\Controllers;

use App\Device;
use App\DeviceAttendance;
use Illuminate\Http\Request;
use \ZKLib\ZKLib;

class DeviceAttendanceController extends Controller
{
    //Manage Devices
    public function manageDevices()
    {
        $devices = Device::all();
        return view('administrator.device.manage_devices', compact('devices'));
    }

    //Add device
    public function addDevice()
    {
        return view('administrator.device.add_device');
    }

    //Get device info
    public function getDeviceInfo(Request $request)
    {
        // dd($request);
        if ($request->json()) {
            $ip = (string) $request->device_ip;
            $device_port_public = (string) $request->device_port_public;
            $zklib = new ZKLib($ip, $device_port_public, 'TCP');
            $zklib->connect();

            $zklib->disableDevice();
            $device_name = $zklib->getDeviceName();
            $serial_number = $zklib->getSerialNumber();
            $device_version = $zklib->getFirmwareVersion();

            $zklib->enableDevice();
            $zklib->disconnect();
            $response = array(
                'status' => 'success',
                'device_ip' => $ip,
                'device_port_public' => $device_port_public,
                'device_name' => $device_name,
                'serial_number' => $serial_number,
                'device_version' => $device_version,
            );

            return response()->json($response);
        }

    }

    //Store Device Information
    public function storeDevice(Request $request)
    {
        // dd($request);
        $device = $this->validate(request(), [
            'device_name' => 'required|unique:devices',
            'serial_number' => 'required|unique:devices',
            'device_version' => 'required',
            'device_ip_hidden' => 'required',
            'device_port_public_h' => 'required|unique:devices',
            'device_ip_internal' => 'required|unique:devices',
        ], [
            'device_ip_hidden.required' => 'The device IP field is required.',
            'device_port_public_h.required' => 'This device public port field is required.',
            'device_port_public_h.unique' => 'This device public port already Exists.',
            'device_ip_internal.required' => 'The device internal IP field is required.',
            'device_ip_internal.unique' => 'This IP address already Exists',
        ]);

        $result = Device::create($device + ['created_by' => auth()->user()->id]);
        $inserted_id = $result->id;
        if (!empty($inserted_id)) {
            return redirect('/device/add')->with('message', 'Add successfully.');
        } else {
            return redirect('/device/add')->with('exception', 'Operation failed !');

        }

    }

    //Edit device
    public function editDeviceInfo($id)
    {
        $device = Device::where('id', $id)->first();
        return view('administrator.device.edit_device', compact('device'));
    }

    //Update Device Information
    public function updateDeviceInfo(Request $request)
    {
        // dd($request);
        $device = $this->validate(request(), [
            'device_name' => 'required|unique:devices',
            'device_ip_hidden' => 'required',
            'device_port_public_h' => 'required|unique:devices',
            'device_ip_internal' => 'required|unique:devices',
        ], [
            'device_ip_hidden.required' => 'The device IP field is required.',
            'device_port_public_h.required' => 'This device public port field is required.',
            'device_port_public_h.unique' => 'This device public port already Exists.',
            'device_ip_internal.required' => 'The device internal IP field is required.',
            'device_ip_internal.unique' => 'This IP address already Exists',
        ]);

        $result = Device::update($device + ['created_by' => auth()->user()->id]);
        $updated_id = $result->id;
        if (!empty($inserted_id)) {
            return redirect('/device/manage')->with('message', 'Add successfully.');
        } else {
            return redirect()->back()->with('exception', 'Operation failed !');

        }

    }

    //selectDevice
    public function selectDevice()
    {
        $devices = Device::all();
        return view('administrator.device.select_device', compact('devices'));
    }

    // Get Device Users
    public function getDeviceUsers(Request $r)
    {
        // dd($r);
        $device = Device::where('id', $r->device_id)->first();
        $port = (string) $device->device_port_public_h;
        $ip = (string) $device->device_ip_hidden;
        //Emloyee details from Device
        $zklib = new ZKLib($ip, $port, 'TCP');
        $zklib->connect();
        $zklib->disableDevice();
        $deviceUsers = $zklib->getUser();
        $zklib->enableDevice();
        $zklib->disconnect();

        return view('administrator.device.device_users_list', compact('device', 'deviceUsers'));

    }

    //selectAttendance Device
    public function selectAttendanceDevice()
    {
        $devices = Device::all();
        return view('administrator.device.select_att_device', compact('devices'));
    }

    //pullDeviceAttendance and save
    public function pullDeviceAttendance()
    {
        $devices = Device::all();
        return view('administrator.device.select_att_pull_device', compact('devices'));
    }

    //saveDeviceAttendance
    public function saveDeviceAttendance(Request $r)
    {
        $device = Device::where('id', $r->device_id)->first();
        $port = (string) $device->device_port_public_h;
        $ip = (string) $device->device_ip_hidden;

        //Emloyee details from Device
        $zklib = new ZKLib($ip, $port, 'TCP');
        $zklib->connect();
        $zklib->disableDevice();
        $attendances = $zklib->getAttendance();
        $zklib->enableDevice();
        $zklib->disconnect();

        // dd($attendances);
        $past_att = DeviceAttendance::whereDate('created_at', date('Y-m-d'))->first();
        if (empty($past_att)) {
            foreach ($attendances as $key => $val) {
                $device_att = new DeviceAttendance;
                $device_att->device_id = $r->device_id;
                $device_att->uuid = $val[0];
                $device_att->employee_id = $val[1];
                $device_att->state = $val[2];
                $device_att->date_time = $val[3];

                $device_att->save();
            }
            return redirect('/hrm/attendance/manage')->with('message', 'Data Saved Successfully!');
        } else {
            return redirect('/device/getAttendance/select')->with('exception', 'Data already exists for this date!');
        }
    }

    //Get device attendance
    public function deviceAttendance(Request $r)
    {

        $device = Device::where('id', $r->device_id)->first();
        $port = (string) $device->device_port_public_h;
        $ip = (string) $device->device_ip_hidden;

        //Emloyee details from Device
        $zklib = new ZKLib($ip, $port, 'TCP');
        $zklib->connect();
        $zklib->disableDevice();
        $attendances = $zklib->getAttendance();
        $zklib->enableDevice();
        $zklib->disconnect();

        return view('administrator.device.device_att_list', compact('device', 'attendances'));
    }

    // Clear Attendance Data clearAttData
    public function clearAttData($id)
    {
        $device = Device::where('id', $id)->first();
        $port = (string) $device->device_port_public_h;
        $ip = (string) $device->device_ip_hidden;

        //Clear attendance from Device
        $zklib = new ZKLib($ip, $port, 'TCP');
        $zklib->connect();
        $zklib->disableDevice();
        $clearData = $zklib->clearAttendance();
        $zklib->enableDevice();
        $zklib->disconnect();

        return redirect('/device/manage')->with('message', 'Add successfully.');

    }

}