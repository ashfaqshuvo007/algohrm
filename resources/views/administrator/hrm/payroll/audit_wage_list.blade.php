@extends('administrator.master')
@section('title', __('Wage List'))

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           {{ __('PAYROLL') }} 
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a></li>
            <li><a>{{ __('Payroll') }}</a></li>
            <li class="active">{{ __('Wage List') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Wage List') }}</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                {{-- <div  class="col-md-6">
                    <a href="{{ url('/hrm/payroll') }}" class="btn btn-primary btn-flat"><i class="fa fa-edit"></i> {{ __('Manage Salary') }}</a>
                </div> --}}
                
                <div  class="col-md-6">
                    <input type="text" id="myInput" class="form-control" placeholder="{{ __('Search..') }}">
                </div>
                <div  class="col-md-3">
                    <button type="button" class="tip btn btn-primary btn-flat" title="Export Excel" data-original-title="Label Export As Excel" id="btnExport">
                          <i class="fa fa-print"></i>
                          <span class="hidden-sm hidden-xs"> {{ __('Export As Excel') }}</span>
                      </button>
                  </div>
                <!-- Notification Box -->
                <div class="col-md-12">
                    @if (!empty(Session::get('message')))
                    <div class="alert alert-success alert-dismissible" id="notification_box">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-check"></i> {{ Session::get('message') }}
                    </div>
                    @elseif (!empty(Session::get('exception')))
                    <div class="alert alert-warning alert-dismissible" id="notification_box">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-warning"></i> {{ Session::get('exception') }}
                    </div>
                    @endif
                </div>
                <!-- /.Notification Box -->
                <div class="col-md-12 table-responsive">
                    <table  class="table table-bordered table-striped" id="printable_area">
                        <thead>
                            <tr>
                                <th>{{ __('SL#') }}</th>
                                <th>{{ __('Employee Name') }}</th>
                                <th>{{ __('Card no.') }}</th>
                                <th>{{ __('Designation') }}</th>
                                <th>{{ __('Joining Date') }}</th>
                                <th>{{ __('Grade') }}</th>
                                <th>{{ __('Wages') }}</th>
                                <th>{{ __('Total Days in month') }}</th>
                                <th>{{ __('Working Days') }}</th>
                                <th>{{ __('Holidays') }}</th>
                                <th>{{ __('C.L') }}</th>
                                <th>{{ __('S.L') }}</th>
                                <th>{{ __('E.L') }}</th>
                                <th>{{ __('Absent Days') }}</th>
                                <th>{{ __('Basic Salary') }}</th>
                                <th>{{ __('House Rent') }}</th>
                                <th>{{ __('Medical Allowance') }}</th>
                                <th>{{ __('Food Allowance') }}</th>
                                <th>{{ __('Convaynce') }}</th>
                                <th>{{ __('Absent Deduction') }}</th>
                                <th>{{ __('Total As per attendance') }}</th>
                                <th>{{ __('Overtime Hours') }}</th>
                                <th>{{ __('Overtime rate') }}</th>
                                <th>{{ __('Overtime Taka') }}</th>
                                <th>{{ __('Increment Amount') }}</th>
                                <th>{{ __('Atten. Bonus') }}</th>
                                <th>{{ __('Total additional') }}</th>
                                <th>{{ __('Net Payable Wages') }}</th>
                                {{-- <th class="text-center">{{ __('Updated At') }}</th> --}}
                                {{-- <th class="text-center">{{ __('Actions') }}</th> --}}
                            </tr>
                        </thead>
                       
                        <tbody id="myTable">
                            @php $sl = 1; @endphp
                            @foreach($salaries as $salary)
                            @php
                                $present = \App\Attendance::where('employee_id',$salary['employee_id'])->whereMonth('created_at',$salryMonth)->get()->toArray();
                                $presentCount = count($present);
                                $leaves = \App\LeaveApplication::where('holiday_for',$salary['user_id'])->whereMonth('start_date',$salryMonth)->where('publication_status',1)->first();
                                // dd($leaves);
                                if(!empty($leaves)){
                                    $leaveCategory = \App\LeaveCategory::where('id',$leaves->leave_category_id)->first();
                                    $leaveCount = \Carbon\Carbon::parse($leaves->start_date)->diffInDays(\Carbon\Carbon::parse($leaves->end_date))+1;
                                    
                                    $workingDays = $numDays - $totalHolidays;
                                    $absent_days = $workingDays - $presentCount - $leaveCount;
                                    
                                }else{
                                    $leaveCategory = '';
                                    $workingDays = $numDays - $totalHolidays;
                                    $absent_days = $workingDays - $presentCount;
                                }

                                if($salary['employee_type'] == 'worker'){
                                    
                                    $hours_overtime = array_column($present,'overtime_hours');
                                    $total_overtime = array_sum($hours_overtime);
                                }else{
                                    $hours_overtime = "N/A";
                                    $total_overtime = "N/A"; 
                                }
                            @endphp
                            <tr>
                                <td>{{ $sl++ }}</td>
                                <td>{{ $salary['name'] }}</td>
                                <td>{{ $salary['employee_id'] }}</td>
                                <td>{{ $salary['designation'] }}</td>
                                <td>{{ $salary['joining_date'] }}</td>
                                <td>{{ $salary['grade_id'] }}</td>
                                
                                <td>
                                @php $gross_salary = (int)$salary['basic_salary'] + (int)$salary['house_rent'] + (int)$salary['medical_allowance'] + (int)$salary['food_allowance'] + (int)$salary['convayence'] ; @endphp
                                {{ $gross_salary }}
                                </td>
                                <td>{{ $numDays }}</td>
                                <td>{{ $numDays - $totalHolidays }}</td>
                                <td>{{ $totalHolidays}}</td>
                                @php
                                if(!empty($leaveCategory)){
                                    $sickCategoryCount = ($leaveCategory->leave_category == 'S.L') ? $leaveCount : 0;
                                    $casualCategoryCount = ($leaveCategory->leave_category == 'C.L') ? $leaveCount : 0;
                                    $eCategoryCount = ($leaveCategory->leave_category == 'E.L') ? $leaveCount : 0;
                                } else{
                                    $sickCategoryCount =  0;
                                    $casualCategoryCount =  0;
                                    $eCategoryCount =  0;
                                }
                                @endphp
                                <td>{{$sickCategoryCount }}</td>
                                <td>{{ $casualCategoryCount}}</td>
                                <td>{{  $eCategoryCount}}</td>
                                
                                <td>{{  $absent_days }}</td>
                                <td>{{$salary['basic_salary']}}</td>
                                <td>{{$salary['house_rent']}}</td>
                                <td>{{$salary['medical_allowance']}}</td>
                                <td>{{$salary['food_allowance']}}</td>
                                <td>{{$salary['convayence']}}</td>
                                @php 
                                    $amount_to_deduct = intval($gross_salary / $numDays);
                                    $tot_absent_deduction = $amount_to_deduct * $absent_days;
                                @endphp
                                <td>{{ $tot_absent_deduction }}</td>
                                @php 
                                    $total_deduction = (int)$salary['absent_deduction'] * ($workingDays - $presentCount); 
                                @endphp
                                <td>{{ $gross_salary - $tot_absent_deduction }}</td>
                                <td>
                                    @php
                                    if($salary['employee_type'] == 'worker'){
                                        if($total_overtime < 0){
                                            $overtime_hours = 0;
                                        }else{
                                            $overtime_hours = $total_overtime;
                                        }
                                        $audit_overtime_hours = 60;
                                        $actual_overtime_hours = $overtime_hours > $audit_overtime_hours ? $audit_overtime_hours : $overtime_hours;
                                    }else{
                                        $actual_overtime_hours = "N/A";
                                    }
                                    @endphp
                                    {{ $actual_overtime_hours  }}
                                </td>
                                @php
                                    if($salary['employee_type'] == 'worker'){
                                       
                                        $overtime_rate = (int)$salary['overtime_rate'];
                                        $overtime_taka = (int)$actual_overtime * $overtime_rate;
                                    }else{
                                        $overtime_rate = "N/A";
                                        $overtime_taka = "N/A";
                                    }
                                @endphp    

                                <td>{{$overtime_rate}}</td>
                                <td>
                                    {{ $overtime_taka }}
                                </td>
                                <td>
                                    @php
                                        $increment = ($salary['increment_amount'] == null) ? 0 : $salary['increment_amount']
                                    @endphp
                                    
                                    {{ $increment }}
                                </td>
                                <td>
                                    @php
                                      if($absent_days > 0){
                                          $bonus = 0;
                                      }else{
                                        $bonus = $salary['att_bonus'];

                                      }   
                                    @endphp
                                    {{$bonus}}
                                </td>
                                @php
                                $join = strtotime($salary['joining_date']);
                                $today = strtotime(date("Y-m-d"));
                                $days = (int)(($join - $today)/86400);

                                $factor = $days/365;
                                if (($factor) > 0){
                                    $act_increment_amount = $increment * $factor;
                                }else{
                                    $act_increment_amount = $increment * 0;
                                }

                                $total_additional = $bonus + (int)$act_increment_amount + (int)$overtime_taka;
                                $net_payable = $gross_salary + $total_additional - $tot_absent_deduction;
                            @endphp
                                <td>{{ $total_additional}}</td>

                                <td>{{ $net_payable }}</td>


                                {{-- <td class="text-center">{{ date("d F Y", strtotime($salary['updated_at'])) }}</td> --}}
                                {{-- <td class="text-center">
                                    <a href="{{ url('/hrm/payroll/manage-salary/' . $salary['user_id']) }}"><i class="icon fa fa-edit"></i> {{ __('Edit') }}</a>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
<script>
$(document).ready(function(){
    $("#btnExport").click(function() {
        var d = new Date();
        var date = d.getDate();
        let table = document.getElementsByTagName("table");
        TableToExcel.convert(table[0], { // html code may contain multiple tables so here we are refering to 1st table tag
           name: `WageList.xlsx`, // fileName you could use any name
           sheet: {
              name: 'Sheet 1' // sheetName
           }
        });
    });
});
</script>
@endsection