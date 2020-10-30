@extends('administrator.master')
@section('title', __('PaySlip'))

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
            <li class="active">{{ __('PaySlip') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('PaySlip') }}</h3>


                <div class="box-tools pull-right">
                    <a href="{{ url('/hrm/payroll/payslip') }}" class="btn btn-primary btn-flat"><i
                                class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                {{-- <div  class="col-md-6">
                    <a href="{{ url('/hrm/payroll') }}" class="btn btn-primary btn-flat"><i class="fa fa-edit"></i> {{ __('Manage Salary') }}</a>
                </div> --}}
                
{{--                <div  class="col-md-6">--}}
{{--                    <input type="text" id="myInput" class="form-control" placeholder="{{ __('Search..') }}">--}}
{{--                </div>--}}
{{--                <div  class="col-md-3">--}}
{{--                    <button type="button" class="tip btn btn-primary btn-flat" title="Export Excel" data-original-title="Label Export As Excel" id="btnExport">--}}
{{--                          <i class="fa fa-excel"></i>--}}
{{--                          <span class="hidden-sm hidden-xs"> {{ __('Export As Excel') }}</span>--}}
{{--                    </button>--}}
{{--                  </div>--}}
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
                <div id="printable_area">
                    @php $sl = 1; @endphp
                    @foreach($salaries as $salary)
                        @php
                            $present = \App\Attendance::where('employee_id',$salary['employee_id'])->whereMonth('created_at',$salryMonth)->first()->toArray();
                            // dd((int)$present['overtime_hours']);
                            $presentCount = count($present);
                            $workingDays = date("t") - $totalHolidays;
                            $absent_days = $workingDays - $presentCount;
                        @endphp
                    <div class="row col-lg-12 text-center">
                        <h2>MAVEN DESIGN LTD</h2>
                        <h4>Prodhan Tower, 22/A DN, Lalpur, Fatullah, Narayangonj</h4>
                        <h5>PAYSLIP</h5>
                        <p><b>{{$salaryMonthAndYear}}</b></p>
                    </div>
                    <div class="row col-md-2 text-center">
                    </div>
                    <div class="row col-md-4 text-center">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>NAME</th>
                                <td>{{ $salary['name'] }}</td>
                            </tr>
                            <tr>
                                <th>EMPLOYEE ID</th>
                                <td>{{ $salary['employee_id'] }}</td>
                            </tr>
                            <tr>
                                <th>DESIGNATION</th>
                                <td>{{ $salary['designation'] }}</td>
                            </tr>

                            <tr>
                                <th>GRADE</th>
                                <td>{{ $salary['grade_id'] }}</td>
                            </tr>
                            <tr>
                                <th>JOINING DATE</th>
                                <td>{{ $salary['joining_date'] }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row col-md-2 text-center">
                    </div>
                    <div class="row col-md-4 text-center">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>আইডি</th>
                                <td>{{ $salary['employee_id'] }}</td>
                            </tr>
                            <tr>
                                <th>মাসে মোট দিন</th>
                                <td>{{ date("t") }}</td>
                            </tr>
                            <tr>
                                <th>কার্যদিবস</th>
                                <td>{{ date("t") - $totalHolidays }}</td>
                            </tr>
                            <tr>
                                <th>ছুটি</th>
                                <td>{{ $totalHolidays}}</td>
                            </tr>
                            <tr>
                                <th>অনুপস্থিত দিন</th>
                                <td>{{  $absent_days }}</td>
                            </tr>

                            <tr>
                                <th>মূল মজুরী</th>
                                <td>{{$salary['basic_salary']}} </td>
                            </tr>
                            <tr>
                                <th>বাড়ি ভাড়া</th>
                                <td>{{$salary['house_rent']}}</td>
                            </tr>
                            <tr>
                                <th>চিকিৎসা ভাতা</th>
                                <td>{{$salary['medical_allowance']}}</td>
                            </tr>
                            <tr>
                                <th>যাতায়াত ভাতা</th>
                                <td>{{$salary['convayence']}}</td>
                            </tr>
                            <tr>
                                <th>খাদ্য ভাতা</th>
                                <td>{{$salary['food_allowance']}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('অতিরিক্ত সময় (ঘন্টা)') }}</th>
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
                            </tr>
                            <tr>
                                <th>{{ __('অতিরিক্ত সময় হার') }}</th>
                                <td>{{$salary['overtime_rate']}}</td>
                            </tr>
                            <tr>
                                <th>{{ __('অতিরিক্ত সময় টাকা') }}</th>
                                @php
                                    $overtime_money = $overtime_hours * (int)$salary['overtime_rate'];
                                @endphp
                                <td>{{ $overtime_money }}</td>
                            </tr>
                            <tr>
                                <th>উপস্থিতি বোনাস</th>
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
                            </tr>

                            <tr>
                                <th>বর্ধিত পরিমাণ</th>
                                <td>{{($salary['increment_amount'] == null) ? 0 : $salary['increment_amount']}}</td>
                            </tr>

                            <tr>
                                <th>অনুপস্থিতি কর্তন</th>
                                @php $total_deduction = ((int)$salary['absent_deduction'] * ($workingDays - $presentCount)); @endphp
                                <td>{{$total_deduction}}</td>
                            </tr>
                            </tbody>
                        </table>

                        <table class="table">
                            <tbody>
                            <tr>
                                <th>মোট মজুরী</th>
                                <td> @php $gross_salary = (int)$salary['basic_salary'] + (int)$salary['house_rent'] + (int)$salary['medical_allowance'] + (int)$salary['food_allowance'] + (int)$salary['convayence'] + (int)$salary['increment_amount'] + (int)$bonus + (int)$overtime_money; @endphp
                                    {{ $gross_salary }}</td>
                            </tr>
                            <tr>
                                <th>মোট কর্তন</th>
                                <td>{{$total_deduction}}</td>
                            </tr>

                            <tr>
                                <th>সর্বমোট</th>
                                <td>{{ $gross_salary - $total_deduction }}</td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>


                </div>
                <!-- Start Button -->
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <button type="button" class="tip btn btn-primary btn-flat" title="Print"
                                data-original-title="Label Printer" onclick="printDiv('printable_area')">
                            <i class="fa fa-print"></i>
                            <span class="hidden-sm hidden-xs"> {{ __('Print') }}</span>
                        </button>
                    </div>
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