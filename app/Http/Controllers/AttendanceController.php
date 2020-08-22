<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\DeviceAttendance;
use App\Holiday;
use App\SetTime;
use App\User;
use App\WorkingDay;
use Auth;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function set_attendance(Request $request)
    {

        $attendance_date = date("Y-m-d", strtotime($request->date));
        $att_user_details = DeviceAttendance::leftjoin('users', 'device_attendances.employee_id', '=', 'users.employee_id')
            ->whereDate('device_attendances.date_time', $request->date)
            ->select([
                'users.id',
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
                $data = [
                    'employee_id' => $att[0]->employee_id,
                    'attendance_date' => $attendance_date,
                    'check_in' => $att[0]->date_time,
                    'check_out' => $att[1]->date_time,
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