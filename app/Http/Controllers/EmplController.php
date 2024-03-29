<?php

namespace App\Http\Controllers;

use App\Department;
use App\Designation;
use App\Device;
use App\Holiday;
use App\Role;
use App\User;
use App\WorkingDay;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use PDF;

class EmplController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = User::query()
            ->join('designations', 'users.designation_id', '=', 'designations.id')
            ->where('users.role', '>=', 2)
            ->where('users.deletion_status', '!=', 1)
            ->select('employee_id', 'users.id', 'users.name', 'users.contact_no_one', 'users.created_at', 'users.activation_status', 'designations.designation')
            ->orderBy('users.employee_id', 'ASC')
            ->get()
            ->toArray();
        return view('administrator.people.employee.manage_employees', compact('employees'));
    }

    function print() {
        $employees = User::query()
            ->join('designations', 'users.designation_id', '=', 'designations.id')
            ->whereBetween('users.access_label', [2, 3])
            ->where('users.deletion_status', 0)
            ->select('users.id', 'users.employee_id', 'users.name', 'users.email', 'users.present_address', 'users.contact_no_one', 'designations.designation')
            ->orderBy('users.id', 'DESC')
            ->get()
            ->toArray();
        return view('administrator.people.employee.employees_print', compact('employees'));
    }

    //Select device for Employee add
    // public function getDevicesForEmployeeAdd()
    // {
    //     $devices = Device::all();
    //     return view('administrator.people.employee.select_device', compact('devices'));
    //     # code...
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Get designations
        $designations = Designation::where('deletion_status', 0)
            ->where('publication_status', 1)
            ->orderBy('designation', 'ASC')
            ->select('id', 'designation')
            ->get()
            ->toArray();
        $roles = Role::all();

        $devices = Device::all();
        $departments = Department::all();

        return view('administrator.people.employee.add_employee', compact('designations', 'roles', 'devices', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dump($request);
        $url = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        $employee = request()->validate([
            'employee_id' => 'required|max:250|unique:users',
            'name' => 'required|max:100',
            'father_name' => 'nullable|max:100',
            'mother_name' => 'nullable|max:100',
            'spouse_name' => 'nullable|max:100',
            'email' => 'required|email|max:100',
            'contact_no_one' => 'required|max:20',
            'emergency_contact' => 'nullable|max:20',
            // 'web' => 'nullable|max:150|regex:' . $url,
            'gender' => 'required',
            'date_of_birth' => 'nullable|date',
            'present_address' => 'required|max:250',
            'permanent_address' => 'nullable|max:250',
            'home_district' => 'nullable|max:250',
            'academic_qualification' => 'nullable',
            'professional_qualification' => 'nullable',
            'experience' => 'nullable',
            'height' => 'nullable',
            'weight' => 'nullable',
            'insurance' => 'required',
            'employee_type' => 'required',
            'physical_ability' => 'required',
            // 'reference' => 'nullable',
            'joining_date' => 'required',
            'designation_id' => 'required|numeric',
            'department_id' => 'required|numeric',
            'marital_status' => 'nullable',
            'id_name' => 'nullable',
            'id_number' => 'nullable|max:100',
            'role' => 'required',
        ], [
            'designation_id.required' => 'The designation field is required.',
            'department_id.required' => 'The department field is required.',
            'contact_no_one.required' => 'The contact no field is required.',
            'web.regex' => 'The URL format is invalid.',
            'name.regex' => 'No number is allowed.',
            'access_label' => 'The position field is required.',
        ]);
        // dd($employee);

        $result = User::create($employee + ['created_by' => auth()->user()->id, 'access_label' => 2, 'password' => bcrypt(12345678)]);
        $inserted_id = $result->id;

        $result->attachRole(Role::where('id', $request->role)->first());

        if (!empty($inserted_id)) {
            return redirect('/people/employees/create')->with('message', 'Add successfully.');
        }
        return redirect('/people/employees/create')->with('exception', 'Operation failed !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {
        $affected_row = User::where('id', $id)
            ->update(['activation_status' => 1]);

        if (!empty($affected_row)) {
            return redirect('/people/employees')->with('message', 'Activate successfully.');
        }
        return redirect('/people/employees')->with('exception', 'Operation failed !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactive($id)
    {
        $affected_row = User::where('id', $id)
            ->update(['activation_status' => 0]);

        if (!empty($affected_row)) {
            return redirect('/people/employees')->with('message', 'Deactive successfully.');
        }
        return redirect('/people/employees')->with('exception', 'Operation failed !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // Employee Platform Details
        $employee = DB::table('users')
            ->join('designations', 'users.designation_id', '=', 'designations.id')
            ->select('users.*', 'designations.designation')
            ->where('users.id', $id)
            ->first();
        $created_by = User::where('id', $employee->created_by)
            ->select('id', 'name')
            ->first();
        $designations = Designation::where('deletion_status', 0)
            ->select('id', 'designation')
            ->get();
        $departments = Department::where('deletion_status', 0)
            ->select('id', 'department')
            ->get();

        return view('administrator.people.employee.show_employee', compact('employee', 'created_by', 'designations', 'departments'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pdf($id)
    {
        $employee = DB::table('users')
            ->join('designations', 'users.designation_id', '=', 'designations.id')
            ->select('users.*', 'designations.designation')
            ->where('users.id', $id)
            ->first();

        $created_by = User::where('id', $employee->created_by)
            ->select('id', 'name')
            ->first();

        $designations = Designation::where('deletion_status', 0)
            ->select('id', 'designation')
            ->get();

        $pdf = PDF::loadView('administrator.people.employee.pdf', compact('employee', 'created_by', 'designations'));
        $file_name = 'EMP-' . $employee->id . '.pdf';
        return $pdf->download($file_name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = User::find($id)->toArray();
        $designations = Designation::where('deletion_status', 0)
            ->where('publication_status', 1)
            ->orderBy('designation', 'ASC')
            ->select('id', 'designation')
            ->get()
            ->toArray();
        $departments = Department::all();
        $roles = Role::all();
        return view('administrator.people.employee.edit_employee', compact('employee', 'departments', 'designations', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        $employee = User::find($id);

        $url = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        request()->validate([
            'name' => 'required|max:100',
            'father_name' => 'nullable|max:100',
            'mother_name' => 'nullable|max:100',
            'spouse_name' => 'nullable|max:100',
            'email' => 'required|email|max:100',
            'contact_no_one' => 'required|max:20',
            'emergency_contact' => 'nullable|max:20',
            'gender' => 'required',
            'date_of_birth' => 'nullable|date',
            'present_address' => 'required|max:250',
            'permanent_address' => 'nullable|max:250',
            'home_district' => 'nullable|max:250',
            'academic_qualification' => 'nullable',
            'professional_qualification' => 'nullable',
            'experience' => 'nullable',
            'height' => 'nullable',
            'weight' => 'nullable',
            'insurance' => 'required',
            'employee_type' => 'required',
            'physical_ability' => 'required',
            'joining_date' => 'nullable',
            'designation_id' => 'required|numeric',
            'department_id' => 'required|numeric',
            'marital_status' => 'nullable',
            'id_name' => 'nullable',
            'id_number' => 'nullable|max:100',
        ], [
            'designation_id.required' => 'The designation field is required.',
            'department_id.required' => 'The department field is required.',
            'physical_ability.required' => 'The physical ability field is required.',
            'contact_no_one.required' => 'The contact no field is required.',
            'web.regex' => 'The URL format is invalid.',
            'name.regex' => 'No number is allowed.',
            'access_label' => 'The position field is required.',
        ]);

        // $employee->employee_id = $request->get('employee_id');
        $employee->name = $request->get('name');
        $employee->father_name = $request->get('father_name');
        $employee->mother_name = $request->get('mother_name');
        $employee->spouse_name = $request->get('spouse_name');
        $employee->email = $request->get('email');
        $employee->contact_no_one = $request->get('contact_no_one');
        $employee->emergency_contact = $request->get('emergency_contact');
        $employee->web = $request->get('web');
        $employee->gender = $request->get('gender');
        $employee->date_of_birth = $request->get('date_of_birth');
        $employee->present_address = $request->get('present_address');
        $employee->permanent_address = $request->get('permanent_address');
        $employee->home_district = $request->get('home_district');
        $employee->academic_qualification = $request->get('academic_qualification');
        $employee->professional_qualification = $request->get('professional_qualification');
        $employee->experience = $request->get('experience');
        $employee->reference = $request->get('reference');
        $employee->joining_date = $request->get('joining_date');
        $employee->designation_id = $request->get('designation_id');
        $employee->department_id = $request->get('department_id');
        $employee->physical_ability = $request->get('physical_ability');
        $employee->employee_type = $request->get('employee_type');
        $employee->access_label = 2;
        $employee->marital_status = $request->get('marital_status');
        $employee->id_name = $request->get('id_name');
        $employee->id_number = $request->get('id_number');
        $employee->role = $request->get('role');
        $affected_row = $employee->save();

        DB::table('role_user')
            ->where('user_id', $id)
            ->update(['role_id' => $request->input('role')]);

        if (!empty($affected_row)) {
            return redirect('/people/employees')->with('message', 'Update successfully.');
        }
        return redirect('/people/employees')->with('exception', 'Operation failed !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $affected_row = User::where('id', $id)
            ->update(['deletion_status' => 1]);

        if (!empty($affected_row)) {
            return redirect('/people/employees')->with('message', 'Delete successfully.');
        }
        return redirect('/people/employees')->with('exception', 'Operation failed !');
    }

    public function showIdCard($id)
    {

        // Employee Platform Details
        $employee = DB::table('users')
            ->join('designations', 'users.designation_id', '=', 'designations.id')
            ->select('users.*', 'designations.designation')
            ->where('users.id', $id)
            ->first();
        $created_by = User::where('id', $employee->created_by)
            ->select('id', 'name')
            ->first();
        $designations = Designation::where('deletion_status', 0)
            ->select('id', 'designation')
            ->get();
        $departments = Department::where('deletion_status', 0)
            ->select('id', 'department')
            ->get();
        // $pdf = PDF::loadView('administrator.people.employee.show_employee_id_card', compact('employee', 'departments', 'created_by', 'designations'));
        // $pdf->setPaper(array(0, 0, 164.16, 274.32));
        // $file_name = 'EMPID-' . $employee->name . '.pdf';
        // return $pdf->download($file_name);
        return view('administrator.people.employee.show_employee_id_card', compact('employee', 'created_by', 'designations', 'departments'));
    }

    public function showPayslip($id)
    {
        $salryMonth = date('m', strtotime(Carbon::now()->subMonth(1)));
        $salaryMonthAndYear = date('"F Y"', strtotime(Carbon::now()->subMonth(1)));
        // dump($salaryMonthAndYear);

        $monthly_holidays = Holiday::whereMonth('date', '=', $salryMonth)
            ->pluck('date')
            ->toArray();

        $holidayCount = count($monthly_holidays);

        $weekly_holidays = WorkingDay::where('working_status', 0)
            ->pluck('day')
            ->toArray();

        $month = date('m', strtotime(Carbon::now()->subMonth(1)));
        $year = date('Y', strtotime(Carbon::now()->subMonth(1)));

        $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $numDays = (int) $numDays;
        $totalHolidays = $holidayCount + (count($weekly_holidays) * 4);
        $workingDays = $numDays - $totalHolidays;

        $salaries = User::query()
            ->leftJoin('payrolls', 'users.id', '=', 'payrolls.user_id')
            ->leftjoin('designations', 'users.designation_id', '=', 'designations.id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftjoin('payment_grades', 'designations.grade_id', '=', 'payment_grades.id')
            ->where('users.id', $id)
            ->where('users.deletion_status', 0)
            ->get([
                'payrolls.*',
                'users.name', 'users.joining_date', 'users.employee_id',
                'designations.designation', 'designations.grade_id',
                'departments.department',
                'payment_grades.grade',
            ])
            ->toArray();
        // dd($salaries);
        $pdf = PDF::loadView('administrator.hrm.payroll.single_payslip', compact('salaries', 'numDays', 'salryMonth', 'totalHolidays', 'salaryMonthAndYear', 'workingDays'))->setPaper(array(0, 0, 204, 650))->setOptions(['dpi' => 72]);

        // download PDF file with download method
        return $pdf->stream($salaries[0]['name'] . '_payslip.pdf');
    }

    public function edit_employee_profile_image(Request $request, $id)
    {

        $user = User::find($id)->toArray();
        return view('administrator.people.employee.edit_employee_profile_image', compact('user'));
    }
    public function updateProfileImage(Request $request, $id)
    {

        $user = User::find($id);

        $url = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        $data = request()->validate([
            'avatar' => 'nullable|mimes:jpeg,png,jpg,gif',
        ]);
        if (!empty($data['avatar'])) {
            $avatar = time() . '.' . request()->avatar->getClientOriginalExtension();
            request()->avatar->move(public_path('profile_picture'), $avatar);
        } else {
            $avatar = $request->get('previous_avater');
        }
        $user->avatar = $avatar;
        $affected_row = $user->save();

        if (!empty($affected_row)) {
            return redirect('/people/employees')->with('message', 'Update successfully.');
        }
        return redirect('/people/employees')->with('exception', 'Operation failed !');
    }

    // public function saveDeviceUsers(Request $r)
    // {

    //     $device = Device::where('id', $r->device_id)->first();
    //     // dd($device);
    //     $port = (string) $device->device_port_public_h;
    //     $ip = (string) $device->device_ip_hidden;

    //     //Emloyee details from Device
    //     $zklib = new ZKLib($ip, $port, 'TCP');
    //     $zklib->connect();
    //     $zklib->disableDevice();
    //     $users = $zklib->getUser();
    //     $zklib->enableDevice();
    //     $zklib->disconnect();

    //     dump($users);
    //     $existing_users = User::pluck('employee_id')->toArray();
    //     dd($existing_users);
    //     foreach($users as $key =>$val){

    //     }

    //     // if (empty($past_att)) {
    //     //     foreach ($attendances as $key => $val) {
    //     //         $device_att = new DeviceAttendance;
    //     //         $device_att->device_id = $r->device_id;
    //     //         $device_att->uuid = $val[0];
    //     //         $device_att->employee_id = $val[1];
    //     //         $device_att->state = $val[2];
    //     //         $device_att->date_time = $val[3];

    //     //         $device_att->save();
    //     //     }
    //     //     return redirect('/hrm/attendance/manage')->with('message', 'Data Saved Successfully!');
    //     // } else {
    //     //     return redirect('/device/getAttendance/select')->with('exception', 'Data already exists for this date!');
    //     // }
    // }

    public function downLoadEmployeeIdCard($id)
    {

        // Employee Platform Details
        $employee = DB::table('users')
            ->join('designations', 'users.designation_id', '=', 'designations.id')
            ->select('users.*', 'designations.designation')
            ->where('users.id', $id)
            ->first();
        $created_by = User::where('id', $employee->created_by)
            ->select('id', 'name')
            ->first();
        $designations = Designation::where('deletion_status', 0)
            ->select('id', 'designation')
            ->get();
        $departments = Department::where('deletion_status', 0)
            ->select('id', 'department')
            ->get();

        $employee = User::leftjoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('designations', 'users.designation_id', '=', 'designations.id')
            ->where('users.id', $id)
            ->select([
                'users.employee_id', 'users.name', 'users.employee_type', 'users.joining_date', 'users.avatar',
                'designations.designation',
                'departments.department',
            ])
            ->first();
        // dd($employee);

        $pdf = PDF::loadView('administrator.people.employee.employee_id_card_pdf', compact('employee'));
        $file_name = 'IdCard-' . $employee->name . '.pdf';
        return $pdf->stream($file_name);
        // return view('administrator.people.employee.employee_id_card_pdf', compact('employee', 'created_by', 'designations', 'departments'));
    }

    public function employeeBulkIdCardsCreate()
    {
        $departments = Department::where('deletion_status', 0)->get();
        return view('administrator.people.employee.emplolyee_bulk_id_cards_create', compact('departments'));
    }

    public function generateDepartementWiseEmployeeBulkIdCards(Request $request)
    {
        // dd($request);
        if ($request->department_id == 0) {
            $departmentName = 'All Departments';
            $employees = User::leftjoin('departments', 'users.department_id', '=', 'departments.id')
                ->leftJoin('designations', 'users.designation_id', '=', 'designations.id')
                ->where('role', '>=', 2)
                ->select([
                    'users.employee_id', 'users.name', 'users.employee_type', 'users.joining_date', 'users.avatar',
                    'designations.designation',
                    'departments.department',
                ])
                ->get()->toArray();

            $pdf = PDF::loadView('administrator.people.employee.departmentwise_employee_id_card_bulk_pdf', compact('employees'));
            $file_name = 'EMPLOYEES-' . $departmentName . '.pdf';
            return $pdf->stream($file_name);
            //        return $pdf->download($file_name);
        } else {
            $departmentName = Department::where('id', $request->department_id)->first();

            $employees = User::leftjoin('departments', 'users.department_id', '=', 'departments.id')
                ->leftJoin('designations', 'users.designation_id', '=', 'designations.id')
                ->where('role', '>=', 2)
                ->where('departments.id', $request->department_id)
                ->select([
                    'users.employee_id', 'users.name', 'users.employee_type', 'users.joining_date', 'users.avatar',
                    'designations.designation',
                    'departments.department',
                ])
                ->get()->toArray();

            $pdf = PDF::loadView('administrator.people.employee.departmentwise_employee_id_card_bulk_pdf', compact('employees', 'departmentName'));
            $file_name = 'EMPLOYEES-' . $departmentName->department . '.pdf';
            return $pdf->stream($file_name);
//        return $pdf->download($file_name);
        }

    }

}