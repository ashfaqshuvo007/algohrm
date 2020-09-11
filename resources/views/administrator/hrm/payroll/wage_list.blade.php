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
                          <i class="fa fa-excel"></i>
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
                                <th>{{ __('Employee Card no.') }}</th>
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
                                $present = \App\Attendance::where('employee_id',$salary['employee_id'])->whereMonth('created_at',$salryMonth)->first()->toArray();
                                // dd((int)$present['overtime_hours']);
                                $presentCount = count($present);
                                $workingDays = date("t") - $totalHolidays;
                                $absent_days = $workingDays - $presentCount;
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
                                <td>{{ date("t") }}</td>
                                <td>{{ date("t") - $totalHolidays }}</td>
                                <td>{{ $totalHolidays}}</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>{{  $absent_days }}</td>
                                <td>{{$salary['basic_salary']}}</td>
                                <td>{{$salary['house_rent']}}</td>
                                <td>{{$salary['medical_allowance']}}</td>
                                <td>{{$salary['food_allowance']}}</td>
                                <td>{{$salary['convayence']}}</td>
                                <td>{{$salary['absent_deduction']}}</td>
                                @php $total_deduction = ((int)$salary['absent_deduction'] * ($workingDays - $presentCount)); @endphp
                                <td>{{ $gross_salary - $total_deduction }}</td>
                                <td>
                                    @php
                                        if($present['overtime_hours'] < 0){
                                            $overtime_hours = 0;
                                        }else{
                                            $overtime_hours = $present['overtime_hours'];
                                        }
                                        if($overtime_hours > 30 ){
                                            
                                        }
                                        $audit_overtime_hours = 30;
                                        $actual_overtime_hours = $overtime_hours > $audit_overtime_hours ? $audit_overtime_hours : $overtime_hours;
                                    @endphp
                                    {{ $actual_overtime_hours  }}
                                </td>
                                <td>{{$salary['overtime_rate']}}</td>
                                <td>{{ $overtime_hours * (int)$salary['overtime_rate'] }}</td>
                                <td>{{($salary['increment_amount'] == null) ? 0 : $salary['increment_amount']}}</td><td>
                                    @php
                                      if($absent_days > 0){
                                          $bonus = 0;
                                      }else{
                                        $bonus = $salary['att_bonus'];

                                      }   
                                    @endphp
                                    {{$bonus}}
                                </td>
                                <td>1988</td>

                                <td>{{ $gross_salary + 1988 }}</td>


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