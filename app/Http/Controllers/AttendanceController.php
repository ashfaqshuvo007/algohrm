<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Device;
use App\DeviceAttendance;
use App\Holiday;
use App\SetTime;
use App\User;
use App\WorkingDay;
use Auth;
use Carbon;
use DB;
use Illuminate\Http\Request;
use PDF;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $devices = Device::all();
        return view('administrator.hrm.attendance.manage_attendance', compact('devices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function set_attendance(Request $request)
    {
        // dd($request)
        $deviceId = $request->device_id;
        $attendance_date = $request->date;
        if ($request->device_id == 0) {
            $device_name = "All Devices";
            $att_user_details = DeviceAttendance::leftjoin('users', 'device_attendances.employee_id', '=', 'users.employee_id')
                ->where('date_time', 'LIKE', $attendance_date . '%')
                ->select([
                    'users.employee_id',
                    'users.name',
                    'users.employee_type',
                    'device_attendances.*',
                ])
                ->get();

        } else {
            $device_name = Device::where('id', $request->device_id)->first();
            $att_user_details = DeviceAttendance::leftjoin('users', 'device_attendances.employee_id', '=', 'users.employee_id')
                ->where('date_time', 'LIKE', $attendance_date . '%')
                ->where('device_id', $request->device_id)
                ->select([
                    'users.employee_id',
                    'users.name',
                    'users.employee_type',
                    'device_attendances.*',
                ])
                ->get();

        }

        $date = $request->date;

        //grouping the data for each employee
        $groupedAttendance = $att_user_details->mapToGroups(function ($item, $key) {
            return [$item['employee_id'] => $item];
        });

        $past_att = Attendance::where('attendance_date', $attendance_date)->first();
        if (is_null($past_att->check_out)) {
            foreach ($groupedAttendance as $att) {
                $check_in = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $att[0]->date_time);
                if (sizeof($att) > 1) {
                    $check_out = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $att[count($att) - 1]->date_time);
                    $diff_in_hours = $check_in->diffInHours($check_out);
                    $overtimeHours = $diff_in_hours - 9;
                } else {
                    $check_out = null;
                    $diff_in_hours = null;
                    $overtimeHours = null;
                }
                $data = [
                    'employee_id' => $att[0]->employee_id,
                    'device_id' => $att[0]->device_id,
                    'attendance_date' => $attendance_date,
                    'check_in' => $check_in,
                    'check_out' => $check_out,
                    'total_hours' => $diff_in_hours,
                    'overtime_hours' => $overtimeHours,
                ];

                $result = Attendance::create($data + ['created_by' => auth()->user()->id]);
            }
        }
        if (count($groupedAttendance) == 0) {
            return redirect()->back()->with('exception', 'No data available');
        } else {
            return view('administrator.hrm.attendance.set_attendance', compact('attendance_date', 'groupedAttendance', 'date', 'device_name', 'deviceId'));

        }

    }

    public function editPastAttendance()
    {
        return view('administrator.hrm.attendance.edit_past_attendance');
    }

    public function set_past_attendance(Request $r)
    {
        // dd($r);
        $date = $r->date;
        $past_att = Attendance::leftjoin('users', 'attendances.employee_id', '=', 'users.employee_id')
            ->where('attendance_date', $date)
            ->select([
                'users.employee_id',
                'users.name',
                'users.employee_type',
                'attendances.check_in',
                'attendances.check_out',
                'attendances.id',

            ])
            ->get();
        return view('administrator.hrm.attendance.set_past_attendance', compact('past_att', 'date'));
    }

    public function storePastAttendance(Request $r)
    {
        $in_time = date('Y-m-d H:s:i', strtotime($r->check_in));
        $out_time = date('Y-m-d H:s:i', strtotime($r->check_out));

        $check_in = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $in_time);
        $check_out = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $out_time);
        $diff_in_hours = $check_in->diffInHours($check_out);
        $overtimeHours = $diff_in_hours - 9;

        $past_att = [
            'check_in' => $check_in,
            'check_out' => $check_out,
            'total_hours' => $diff_in_hours,
            'overtime_hours' => $overtimeHours,
        ];
        $result = Attendance::where('id', $r->row_id)->update($past_att);

        return redirect('/hrm/attendance/editPastAttendance')->with('message', 'Updated Successfully');

    }

    public function manualAttendance()
    {
        $employees = User::where('role', '>', 1)->get();
        // dd($employees);
        return view('administrator.hrm.attendance.manual_attendance_select', compact('employees'));
    }
    public function manualAttendanceSelect(Request $r)
    {
        $employee = User::where('id', $r->user_id)->first();
        $date = date('Y-m-d');

        return view('administrator.hrm.attendance.manual_attendance', compact('employee', 'date'));
    }

    public function manualAttendanceUpdate(Request $r)
    {
        $attendance_date = $r->date;
        $in_time = date('Y-m-d H:s:i', strtotime($r->in_time));
        $out_time = date('Y-m-d H:s:i', strtotime($r->out_time));

        $past_attendance = Attendance::where('employee_id', $r->employee_id)->whereDate('attendance_date', $attendance_date)->get()->toArray();

        if (count($past_attendance) === 0) {
            $check_in = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $in_time);
            $check_out = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $out_time);
            $diff_in_hours = $check_in->diffInHours($check_out);
            $overtimeHours = $diff_in_hours - 9;
            $data = [
                'employee_id' => $r->employee_id,
                'attendance_date' => $attendance_date,
                'check_in' => $check_in,
                'check_out' => $check_out,
                'total_hours' => $diff_in_hours,
                'overtime_hours' => $overtimeHours,
            ];
            $result = Attendance::create($data + ['created_by' => auth()->user()->id]);
            return redirect('/hrm/attendance/manualAttendance')->with('message', 'Attendance saved successfully!');

        } else {
            return redirect('/hrm/attendance/manualAttendance')->with('exception', 'Attendance already for this date already exists!!');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
        // return $request;
        for ($i = 0; $i < count($request->user_id); $i++) {
            Attendance::create([
                'created_by' => auth()->user()->id,
                'user_id' => $request->user_id[$i],
                'attendance_date' => $request->attendance_date[$i],
                'attendance_status' => $request->attendance_status[$i],
                'leave_category_id' => $request->leave_category_id[$i],
                'check_in' => $request->check_in[$i],
                'check_out' => $request->check_out[$i],
            ]);
        }
        return redirect('/hrm/attendance/manage')->with('message', 'Add successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        for ($i = 0; $i < count($request->user_id); $i++) {

            $attendance = Attendance::find($request->attendance_id[$i]);
            $attendance->user_id = $request->user_id[$i];
            $attendance->attendance_date = $request->attendance_date[$i];
            $attendance->attendance_status = $request->attendance_status[$i];
            $attendance->leave_category_id = $request->leave_category_id[$i];
            $attendance->check_in = '09:12:00';
            $attendance->check_out = '17:12:00';
            $affected_row = $attendance->save();

        }
        return redirect('/hrm/attendance/manage')->with('message', 'Update successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function report()
    {
        return view('administrator.hrm.attendance.report');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_report(Request $request)
    {
        $date = $request->date;
        $month = date("m", strtotime($date));
        $year = date("Y", strtotime($date));

        $number_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $attendances = Attendance::query()
        // ->leftjoin('leave_categories as leave', 'attendances.leave_category_id', '=', 'leave.id')
            ->whereYear('attendances.attendance_date', '=', $year)
            ->whereMonth('attendances.attendance_date', '=', $month)
            ->get(['attendances.*'])
            ->toArray();

        dump($attendances);
        $employees = User::query()
            ->leftjoin('designations as designations', 'users.designation_id', '=', 'designations.id')
            ->orderBy('users.name', 'ASC')
            ->where('users.role', '>=', 2)
            ->get(['designations.designation', 'users.name', 'users.id', 'users.employee_id'])
            ->toArray();
        dump($employees);
        $weekly_holidays = WorkingDay::where('working_status', 0)
            ->get()
            ->toArray();
        dump($weekly_holidays);

        $monthly_holidays = Holiday::whereYear('date', '=', $year)
            ->whereMonth('date', '=', $month)
            ->get(['date', 'holiday_name'])
            ->toArray();
        // dd($monthly_holidays);

        return view('administrator.hrm.attendance.get_report', compact('date', 'attendances', 'employees', 'number_of_days', 'weekly_holidays', 'monthly_holidays'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function timeSet(Request $request)
    {

        //return $request;

        $id = $request->id;

        $setimes = \App\SetTime::all();

        if ($setimes->count() > 0) {
            $setimes = SetTime::find($id);
            $setimes->in_time = $request->in_time;
            $setimes->out_time = $request->out_time;
            $setimes->save();

            return redirect('hrm/attendance/manage')->with('message', 'Set Update Successful!');

        } else {

            $setimes = new SetTime;
            $setimes->created_by = Auth::user()->id;
            $setimes->in_time = $request->in_time;
            $setimes->out_time = $request->out_time;
            $setimes->save();

            return redirect('hrm/attendance/manage')->with('message', 'Set Successful!');
        }

    }

    public function attDetails($id)
    {

        $attendance = Attendance::all()->where('user_id', $id);

        return view('administrator.hrm.attendance.detailsAttendense', compact('attendance'));
    }

    public function attDetailsReportGo()
    {

        $employees = User::whereBetween('access_label', [2, 3])
            ->where('deletion_status', 0)
            ->select('id', 'name')
            ->orderBy('id', 'DESC')
            ->get()
            ->toArray();

        return view('administrator.hrm.attendance.detailsAttendenseReportGo', compact('employees'));
    }

    public function attDetailsReport(Request $request)
    {
        dd($request);

        //return $request->emp_id;

        $empid = $request->emp_id;
        $daterange = $request->daterange;

        if ($request->daterange == '' or $request->emp_id == 0) {

            return redirect('/hrm/attendance/details/report/go')->with('exception', 'Please select the Date Range');
        } else {

            $empid = $request->emp_id;
            $dates = explode(' - ', $request->daterange);

            $date1 = $dates[0];
            $date2 = $dates[1];

            $startdate = date("Y-m-d", strtotime($date1));
            $enddate = date("Y-m-d", strtotime($date2));

            $attendance = DB::table('attendances')->whereBetween('attendance_date', [$startdate, $enddate])->where('user_id', $empid)->get();

            $attds = DB::table('attendances')->where('attendance_status', 1)->where('user_id', $empid)->whereBetween('attendance_date', [$startdate, $enddate])->get();

            $abs = DB::table('attendances')->where('attendance_status', 0)->where('user_id', $empid)->whereBetween('attendance_date', [$startdate, $enddate])->get();

            return view('administrator.hrm.attendance.detailsAttendenseReport', compact('attendance', 'startdate', 'enddate', 'empid', 'attds', 'abs'));
        }
    }

    public function attDetailsReportPdf(Request $request)
    {

        $empid = $request->emp_id;

        $startdate = $request->date1;
        $enddate = $request->date2;

        $attendance = DB::table('attendances')->whereBetween('attendance_date', [$startdate, $enddate])->where('user_id', $empid)->get();

        $attds = DB::table('attendances')->where('attendance_status', 1)->where('user_id', $empid)->whereBetween('attendance_date', [$startdate, $enddate])->get();

        $abs = DB::table('attendances')->where('attendance_status', 0)->where('user_id', $empid)->whereBetween('attendance_date', [$startdate, $enddate])->get();

        $pdf = PDF::loadView('administrator.hrm.attendance.detailsAttendenseReportPdf', compact('attendance', 'startdate', 'enddate', 'empid', 'attds', 'abs'));

        return $pdf->download('AttendenceStatement.pdf');

    }

    public function attendanceReportGo()
    {
        return view('administrator.hrm.attendance.get_attendance_report');
    }

    public function attendanceShowReport(Request $r)
    {
        $date = date("Y-m-d", strtotime($r->date));
        $att_user_details = Attendance::leftjoin('users', 'attendances.employee_id', '=', 'users.employee_id')
            ->where('attendance_date', $date)
            ->select([
                'users.employee_id',
                'users.name',
                'users.employee_type',
                'attendances.check_in',
                'attendances.check_out',
            ])
            ->get();

        //grouping the data for each employee
        $groupedAttendance = $att_user_details->mapToGroups(function ($item, $key) {
            return [$item['employee_id'] => $item];
        });
        return view('administrator.hrm.attendance.attendance_chart', compact('att_user_details', 'date'));

    }
}