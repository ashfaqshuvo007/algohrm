<?php

namespace App\Http\Controllers;

use App\Holiday;
use App\PaymentGrade;
use App\Payroll;
use App\User;
use App\WorkingDay;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = User::query()
            ->leftjoin('designations as designations', 'users.designation_id', '=', 'designations.id')
            ->orderBy('users.name', 'ASC')
            ->where('users.access_label', '>=', 2)
            ->where('users.access_label', '<=', 3)
            ->get(['designations.designation', 'users.name', 'users.id', 'users.employee_id'])
            ->toArray();

        return view('administrator.hrm.payroll.manage_salary', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function go(Request $request)
    {
        request()->validate([
            'user_id' => 'required',
        ], [
            'user_id.required' => 'The employee name field is required',
        ]);
        return redirect('/hrm/payroll/manage-salary/' . $request->user_id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id)
    {
        $employee_id = $user_id;

        $employees = User::query()
            ->leftjoin('designations as designations', 'users.designation_id', '=', 'designations.id')
            ->leftjoin('payment_grades as grades', 'designations.grade_id', '=', 'grades.id')
            ->orderBy('users.employee_id', 'ASC')
            ->where('users.id', $employee_id)
            ->select('designations.designation', 'grades.*', 'users.employee_id', 'users.id')
            ->get()
            ->toArray();
        $user_emp_id = User::where('id', $user_id)->pluck('employee_id');

        // $emp_attendance = Attendance::where('employee_id',$user_emp_id[0])->get();
        // $att_count =
        // dd($employees);

        $salary = Payroll::where('user_id', $user_id)
            ->first();

        if (!empty($salary)) {
            return view('administrator.hrm.payroll.edit_salary', compact('employees', 'employee_id', 'salary'));
        } else {
            return view('administrator.hrm.payroll.create_salary', compact('employees', 'employee_id'));
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
        $salary = request()->validate([
            'employee_type' => 'required',
            'basic_salary' => 'required|numeric',
            'house_rent' => 'nullable|numeric',
            'medical_allowance' => 'nullable|numeric',
            'food_allowance' => 'nullable|numeric',
            'convayence' => 'nullable|numeric',
            'absent_deduction' => 'nullable|numeric',
            'overtime_rate' => 'nullable|numeric',
            'att_bonus' => 'nullable|numeric',
            'increment_amount' => 'nullable|numeric',

        ]);

        $result = Payroll::create($salary + ['created_by' => auth()->user()->id, 'user_id' => $request->user_id]);
        $inserted_id = $result->id;

        if (!empty($inserted_id)) {
            return redirect('/hrm/payroll')->with('message', 'Add successfully.');
        }
        return redirect('/hrm/payroll')->with('exception', 'Operation failed !');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function list() {
        $salaries = Payroll::query()
            ->leftjoin('users', 'payrolls.user_id', '=', 'users.id')
            ->leftjoin('designations', 'users.designation_id', '=', 'designations.id')
            ->orderBy('users.name', 'ASC')
            ->where('users.deletion_status', 0)
            ->get([
                'payrolls.*',
                'users.name',
                'designations.designation',
            ])
            ->toArray();
        return view('administrator.hrm.payroll.salary_list', compact('salaries'));
    }

    ///hrm/payroll/generate-wages-list
    public function generate_wages_list()
    {
        $employees = User::where('role', 'employee')->get();
        $grades = PaymentGrade::all();
        return view('administrator.hrm.payroll.generate_wage_list', compact('employees', 'grades'));
    }
    //hrm/audit/generate_wage_list
    public function generate_audit_wages_list()
    {
        return view('administrator.hrm.payroll.generate_audit_wages_list');
    }

    public function generateAuditWageList(Request $r)
    {
        $salryMonth = date('m', strtotime($r->salary_month));

        if ($salryMonth == date('m')) {
            return redirect()->back()->with('exception', 'You can not generate Wagelist for the current month!');
        }

        $monthly_holidays = Holiday::whereMonth('date', '=', $salryMonth)
            ->pluck('date')
            ->toArray();

        $holidayCount = count($monthly_holidays);

        $weekly_holidays = WorkingDay::where('working_status', 0)
            ->pluck('day')
            ->toArray();

        $month = date('m', strtotime($r->salary_month));
        $year = date('Y', strtotime($r->salary_month));

        $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $totalHolidays = $holidayCount + (count($weekly_holidays) * 4);
        $salaries = Payroll::query()
            ->leftjoin('users', 'payrolls.user_id', '=', 'users.id')
            ->leftjoin('designations', 'users.designation_id', '=', 'designations.id')
            ->leftjoin('payment_grades', 'designations.grade_id', '=', 'payment_grades.id')
            ->orderBy('users.name', 'ASC')
            ->where('users.deletion_status', 0)
            ->get([
                'payrolls.*',
                'users.name', 'users.joining_date', 'users.id_number', 'users.employee_id',
                'designations.designation', 'designations.grade_id',
                'payment_grades.grade',
            ])
            ->toArray();
        // dd($salaries);

        return view('administrator.hrm.payroll.audit_wage_list', compact('salaries', 'totalHolidays', 'salryMonth'));
    }

    public function generateWageList(Request $r)
    {
        $salryMonth = date('m', strtotime($r->salary_month));
        $user_id = $r->emp_office_id;
        $grade_id = $r->emp_grade;

        if ($salryMonth == date('m')) {
            return redirect()->back()->with('exception', 'You can not generate Wagelist for the current month!');
        }

        $monthly_holidays = Holiday::whereMonth('date', '=', $salryMonth)
            ->pluck('date')
            ->toArray();

        $holidayCount = count($monthly_holidays);

        $weekly_holidays = WorkingDay::where('working_status', 0)
            ->pluck('day')
            ->toArray();

        $month = date('m', strtotime($r->salary_month));
        $year = date('Y', strtotime($r->salary_month));

        $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $totalHolidays = $holidayCount + (count($weekly_holidays) * 4);
        if ($user_id != '0') {
            $salaries = Payroll::query()
                ->leftjoin('users', 'payrolls.user_id', '=', 'users.id')
                ->leftjoin('designations', 'users.designation_id', '=', 'designations.id')
                ->leftjoin('payment_grades', 'designations.grade_id', '=', 'payment_grades.id')
                ->orderBy('users.name', 'ASC')
                ->where('users.deletion_status', 0)
                ->where('users.id', $user_id)
                ->get([
                    'payrolls.*',
                    'users.name', 'users.joining_date', 'users.id_number', 'users.employee_id',
                    'designations.designation', 'designations.grade_id',
                    'payment_grades.grade',
                ])
                ->toArray();
        } elseif ($grade_id != '0') {
            $salaries = Payroll::query()
                ->leftjoin('users', 'payrolls.user_id', '=', 'users.id')
                ->leftjoin('designations', 'users.designation_id', '=', 'designations.id')
                ->leftjoin('payment_grades', 'designations.grade_id', '=', 'payment_grades.id')
                ->orderBy('users.name', 'ASC')
                ->where('users.deletion_status', 0)
                ->where('payment_grades.id', $grade_id)
                ->get([
                    'payrolls.*',
                    'users.name', 'users.joining_date', 'users.id_number', 'users.employee_id',
                    'designations.designation', 'designations.grade_id',
                    'payment_grades.grade',
                ])
                ->toArray();
        } else {
            $salaries = Payroll::query()
                ->leftjoin('users', 'payrolls.user_id', '=', 'users.id')
                ->leftjoin('designations', 'users.designation_id', '=', 'designations.id')
                ->leftjoin('payment_grades', 'designations.grade_id', '=', 'payment_grades.id')
                ->orderBy('users.name', 'ASC')
                ->where('users.deletion_status', 0)
                ->get([
                    'payrolls.*',
                    'users.name', 'users.joining_date', 'users.id_number', 'users.employee_id',
                    'designations.designation', 'designations.grade_id',
                    'payment_grades.grade',
                ])
                ->toArray();
        }

        return view('administrator.hrm.payroll.wage_list', compact('salaries', 'totalHolidays', 'salryMonth'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $salary = Payroll::query()
            ->leftjoin('users', 'payrolls.user_id', '=', 'users.id')
            ->leftjoin('designations', 'users.designation_id', '=', 'designations.id')
            ->leftjoin('departments', 'designations.department_id', '=', 'departments.id')
            ->orderBy('users.name', 'ASC')
            ->where('payrolls.id', $id)
            ->where('users.deletion_status', 0)
            ->first([
                'payrolls.*',
                'users.name',
                'users.avatar',
                'designations.designation',
                'departments.department',
            ])
            ->toArray();
        return view('administrator.hrm.payroll.salary_details', compact('salary'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $salary = Payroll::find($id);
        request()->validate([
            'employee_type' => 'required',
            'basic_salary' => 'required|numeric',
            'house_rent' => 'nullable|numeric',
            'medical_allowance' => 'nullable|numeric',
            'food_allowance' => 'nullable|numeric',
            'convayence' => 'nullable|numeric',
            'overtime_rate' => 'nullable|numeric',
            'absent_deduction' => 'nullable|numeric',
            'att_bonus' => 'nullable|numeric',
            'increment_amount' => 'nullable|numeric',

        ]);

        $salary->employee_type = $request->get('employee_type');
        $salary->basic_salary = $request->get('basic_salary');
        $salary->house_rent = $request->get('house_rent');
        $salary->medical_allowance = $request->get('medical_allowance');
        $salary->food_allowance = $request->get('food_allowance');
        $salary->convayence = $request->get('convayence');
        $salary->overtime_rate = $request->get('overtime_rate');
        $salary->absent_deduction = $request->get('absent_deduction');
        $salary->att_bonus = $request->get('att_bonus');
        $salary->increment_amount = $request->get('increment_amount');
        $affected_row = $salary->save();

        if (!empty($affected_row)) {
            return redirect('/hrm/payroll/')->with('message', 'Update successfully.');
        }
        return redirect('/hrm/payroll/')->with('exception', 'Operation failed !');
    }

    //Weeekly Night Bill Management
    // <div class="form-group{{ $errors->has('salary_month') ? ' has-error' : '' }}">
    //             <label for="salary_month" class="col-sm-3 control-label">{{ __('Select Month') }}</label>
    //             <div class="col-sm-3">

    //                 <input type="text" name="daterange" class="form-control" id="reservation">

    //             </div>
    //           </div>

    // selectWeek
    // public function selectWeek()
    // {
    //     return view('administrator.hrm.weeklyNightBill.weekly_nightBill_select');
    // }

    public function getWeeklyNightBill()
    {
        // dump($startDate);
        // dd($endDate);
        // $now = Carbon::now();
        // $lastweekStartDate = $now->startOfWeek(Carbon::SATURDAY)->subWeek()->format('Y-m-d');
        // $lastweekEndDate = $now->startOfWeek(Carbon::SATURDAY)->addDays(5)->format('Y-m-d');

        // // $weekStartDate = $now->startOfWeek(Carbon::SATURDAY)->format('Y-m-d');
        // // $weekEndDate = $now->endOfWeek(Carbon::THURSDAY)->format('Y-m-d');

        // $attendances = Attendance::leftJoin('users', 'attendances.employee_id', '=', 'users.employee_id')
        //     ->leftJoin('designations', 'users.designation_id', '=', 'designations.id')
        //     ->whereBetween('attendances.attendance_date', [$lastweekStartDate, $lastweekEndDate])
        //     ->groupBy('attendances.attendance_date')
        //     ->select([
        //         'users.employee_id',
        //         'users.name',
        //         'designations.designation',
        //         'attendances.attendance_date', 'attendances.overtime_hours', 'attendances.attendance_date',
        //     ])
        //     ->get();

        // // dump($lastweekStartDate);
        // // dd($lastweekEndDate);
        // return $attendances;

        $employees = User::leftJoin('designations', 'users.designation_id', '=', 'designations.id')
            ->where('role', 'employee')
            ->select([
                'users.employee_id as employee_id',
                'users.name as employee_name',
                'designations.designation as employee_designation',
            ])->get();
        // return $employees;
        return view('administrator.hrm.weeklyNightBill.weekly_nightBill_list', compact('employees'));

    }
    public function payslip()
    {
        $employees = User::where('role', 'employee')->get();
        $grades = PaymentGrade::all();
        return view('administrator.hrm.payroll.payslip_create', compact('employees', 'grades'));
    }

    public function generatePayslip(Request $r)
    {
        $salryMonth = date('m', strtotime($r->salary_month));
        $salaryMonthAndYear = date('"F Y"',strtotime($r->salary_month));
        $user_id = $r->emp_office_id;
        $grade_id = $r->emp_grade;

        if ($salryMonth == date('m')) {
            return redirect()->back()->with('exception', 'You can not generate Wagelist for the current month!');
        }

        $monthly_holidays = Holiday::whereMonth('date', '=', $salryMonth)
            ->pluck('date')
            ->toArray();

        $holidayCount = count($monthly_holidays);

        $weekly_holidays = WorkingDay::where('working_status', 0)
            ->pluck('day')
            ->toArray();

        $month = date('m', strtotime($r->salary_month));
        $year = date('Y', strtotime($r->salary_month));

        $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $totalHolidays = $holidayCount + (count($weekly_holidays) * 4);
        if ($user_id != '0') {
            $salaries = Payroll::query()
                ->leftjoin('users', 'payrolls.user_id', '=', 'users.id')
                ->leftjoin('designations', 'users.designation_id', '=', 'designations.id')
                ->leftjoin('payment_grades', 'designations.grade_id', '=', 'payment_grades.id')
                ->orderBy('users.name', 'ASC')
                ->where('users.deletion_status', 0)
                ->where('users.id', $user_id)
                ->get([
                    'payrolls.*',
                    'users.name', 'users.joining_date', 'users.id_number', 'users.employee_id',
                    'designations.designation', 'designations.grade_id',
                    'payment_grades.grade',
                ])
                ->toArray();
        } elseif ($grade_id != '0') {
            $salaries = Payroll::query()
                ->leftjoin('users', 'payrolls.user_id', '=', 'users.id')
                ->leftjoin('designations', 'users.designation_id', '=', 'designations.id')
                ->leftjoin('payment_grades', 'designations.grade_id', '=', 'payment_grades.id')
                ->orderBy('users.name', 'ASC')
                ->where('users.deletion_status', 0)
                ->where('payment_grades.id', $grade_id)
                ->get([
                    'payrolls.*',
                    'users.name', 'users.joining_date', 'users.id_number', 'users.employee_id',
                    'designations.designation', 'designations.grade_id',
                    'payment_grades.grade',
                ])
                ->toArray();
        } else {
            $salaries = Payroll::query()
                ->leftjoin('users', 'payrolls.user_id', '=', 'users.id')
                ->leftjoin('designations', 'users.designation_id', '=', 'designations.id')
                ->leftjoin('payment_grades', 'designations.grade_id', '=', 'payment_grades.id')
                ->orderBy('users.name', 'ASC')
                ->where('users.deletion_status', 0)
                ->get([
                    'payrolls.*',
                    'users.name', 'users.joining_date', 'users.id_number', 'users.employee_id',
                    'designations.designation', 'designations.grade_id',
                    'payment_grades.grade',
                ])
                ->toArray();
        }

        return view('administrator.hrm.payroll.payslip', compact('salaries', 'totalHolidays', 'salryMonth','salaryMonthAndYear'));
    }

}