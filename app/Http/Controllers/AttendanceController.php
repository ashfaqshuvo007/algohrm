<?php

namespace App\Http\Controllers;

use App\Attendance;
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
        return view('administrator.hrm.attendance.manage_attendance');
    }

    public function editPastAttendance()
    {
        return view('administrator.hrm.attendance.edit_past_attendance');
    }

    public function set_past_attendance(Request $r)
    {
        // dd($r);
        $date = $r->date;
        $past_att = Attendance::where('attendance_date', $date)->get();
        return view('administrator.hrm.attendance.set_past_attendance', compact('past_att', 'date'));
    }

    public function storePastAttendance(Request $r)
    {
        // dd($r);
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
        $result = Attendance::where('id', $r->row_id)->update($past_att + ['created_by' => auth()->user()->id]);

        return redirect('/hrm/attendance/editPastAttendance')->with('message', 'Updated Successfully');

    }

    public function manualAttendance()
    {
        $employees = User::where('role', 'employee')->get();
        return view('administrator.hrm.attendance.manual_attendance_select', compact('employees'));
    }
    public function manualAttendanceSelect(Request $r)
    {
        $employee = User::where('id', $r->user_id)->where('role', 'employee')->first();
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
            return view('administrator.hrm.attendance.manage_attendance')->with('message', 'Attendance saved successfully!');

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
    public function set_attendance(Request $request)
    {
        // dd($request);
        $attendance_date = date("Y-m-d", strtotime($request->date));
        $att_user_details = DeviceAttendance::leftjoin('users', 'device_attendances.employee_id', '=', 'users.employee_id')
            ->whereDate('device_attendances.date_time', $request->date)
            ->select([
                'users.employee_id',
                'users.name',
                'device_attendances.*',
            ])
            ->get();

        $date = $request->date;

        //grouping the data for each employee
        $groupedAttendance = $att_user_details->mapToGroups(function ($item, $key) {
            return [$item['employee_id'] => $item];
        });

        $past_att = Attendance::where('attendance_date', $attendance_date)->first();
        if (empty($past_att)) {
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

                // print_r($diff_in_hours);

                $data = [
                    'employee_id' => $att[0]->employee_id,
                    'attendance_date' => $attendance_date,
                    'check_in' => $check_in,
                    'check_out' => $check_out,
                    'total_hours' => $diff_in_hours,
                    'overtime_hours' => $overtimeHours,
                ];
                $result = Attendance::create($data + ['created_by' => auth()->user()->id]);
            }
        }

        return view('administrator.hrm.attendance.set_attendance', compact('attendance_date', 'groupedAttendance', 'date'));

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
            ->leftjoin('leave_categories as leave', 'attendances.leave_category_id', '=', 'leave.id')
            ->whereYear('attendances.attendance_date', '=', $year)
            ->whereMonth('attendances.attendance_date', '=', $month)
            ->get(['attendances.*', 'leave.leave_category'])
            ->toArray();

        $employees = User::query()
            ->leftjoin('designations as designations', 'users.designation_id', '=', 'designations.id')
            ->orderBy('users.name', 'ASC')
            ->where('users.access_label', '>=', 2)
            ->where('users.access_label', '<=', 3)
            ->get(['designations.designation', 'users.name', 'users.id'])
            ->toArray();

        $weekly_holidays = WorkingDay::where('working_status', 0)
            ->get()
            ->toArray();

        $monthly_holidays = Holiday::whereYear('date', '=', $year)
            ->whereMonth('date', '=', $month)
            ->get(['date', 'holiday_name'])
            ->toArray();

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
}