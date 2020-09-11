@extends('administrator.master')
@section('title', __('Manage Weekly Night Bill'))

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          {{ __(' Weekly Night Bill') }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a></li>
            <li><a>{{ __('Nightly Bill') }}</a></li>
            <li class="active">{{ __('Nightly Bill List') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Nightly Bill List') }}</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                {{-- <div  class="col-md-3">
                <a href="{{ url('/hrm/payroll/increment/search') }}" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> {{ __('add new increment') }}</a>
                </div> --}}
                <div  class="col-md-3">
                    <button type="button" class="tip btn btn-primary btn-flat" title="Export Excel" data-original-title="Label Export As Excel" id="btnExportNightBill">
                        <i class="fa fa-excel"></i>
                        <span class="hidden-sm hidden-xs"> {{ __('Export As Excel') }}</span>
                  </button>
                </div>
                <div  class="col-md-6">
                    <input type="text" id="myInput" class="form-control" placeholder="{{ __('Search..') }}">
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
                <div id="printable_area" class="col-md-12 table-responsive">
                    @php
                        $now = \Carbon\Carbon::now();
                        $lastweekStartDate = $now->startOfWeek(\Carbon\Carbon::SATURDAY)->subWeek()->format('Y-m-d');
                        $secondDate = $now->startOfWeek(\Carbon\Carbon::SATURDAY)->addDays(1)->format('Y-m-d');
                        $thirdDate = $now->startOfWeek(\Carbon\Carbon::SATURDAY)->addDays(2)->format('Y-m-d');
                        $fouthDate = $now->startOfWeek(\Carbon\Carbon::SATURDAY)->addDays(3)->format('Y-m-d');
                        $fifthDate = $now->startOfWeek(\Carbon\Carbon::SATURDAY)->addDays(4)->format('Y-m-d');
                        $lastweekEndDate = $now->startOfWeek(\Carbon\Carbon::SATURDAY)->addDays(5)->format('Y-m-d');

                    @endphp


                <table  class="table table-bordered table-striped">
                    <thead>
                        <tr style="text-align: center;">
                            <th>{{ __('SL') }}</th>
                            <th>{{ __('Emloyee ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Designation') }}</th>
                            <th>
                                <td>{{ $lastweekStartDate }}</td>
                                <td>{{ $secondDate }}</td>
                                <td>{{ $thirdDate }}</td>
                                <td>{{ $fouthDate }}</td>
                                <td>{{ $fifthDate }}</td>
                                <td>{{ $lastweekEndDate }}</td>
                            </th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody id="myTable" style="text-center">
                        @php $sl = 1 ;@endphp
                        @foreach($employees as $data)
                        <tr>
                            <td>{{ $sl ++ }}</td>
                            <td>{{$data->employee_id}}</td>
                            <td>{{$data->employee_name}}</td>
                            
                            <td>{{$data->employee_designation}}</td>
                            <td>
                                <td>
                                    @php
                                        $nightShift = \App\Attendance::where('employee_id',$data->employee_id)->where('attendance_date',$lastweekStartDate )->where('overtime_hours','>=',4)->pluck('overtime_hours')->toArray();
                                        if(count($nightShift) > 0){
                                            $overtime = ($nightShift[0] == 4) ? 25 : 30;
                                        }else{
                                            $overtime = 0;
                                        }
                                    @endphp
                                    {{ $overtime}}
                                </td>
                                <td>
                                    @php
                                        $nightShift1 = \App\Attendance::where('employee_id',$data->employee_id)->where('attendance_date',$secondDate )->where('overtime_hours','>=',4)->pluck('overtime_hours')->toArray();
                                        
                                        if(count($nightShift1) > 0){
                                            $overtime1 = ($nightShift1[0] == 4) ? 25 : 30;
                                        }else{
                                            $overtime1 = 0;
                                        }
                                    @endphp
                                    {{ $overtime1}}
                                </td>
                                <td>
                                    @php
                                        $nightShift2 = \App\Attendance::where('employee_id',$data->employee_id)->where('attendance_date',$thirdDate )->where('overtime_hours','>=',4)->pluck('overtime_hours')->toArray();
                                        if(count($nightShift2) > 0){
                                            $overtime2 = ($nightShift2[0] == 4) ? 25 : 30;
                                        }else{
                                            $overtime2 = 0;
                                        }
                                    @endphp
                                    {{ $overtime2}}
                                </td>
                                <td>
                                    @php
                                        $nightShift3 = \App\Attendance::where('employee_id',$data->employee_id)->where('attendance_date',$fouthDate )->where('overtime_hours','>=',4)->pluck('overtime_hours')->toArray();
                                        if(count($nightShift3) > 0){
                                            $overtime3 = ($nightShift3[0] == 4) ? 25 : 30;
                                        }else{
                                            $overtime3 = 0;
                                        }
                                    @endphp
                                    {{ $overtime3}}
                                </td>
                                <td>
                                    @php
                                        $nightShift4 = \App\Attendance::where('employee_id',$data->employee_id)->where('attendance_date',$fifthDate)->where('overtime_hours','>=',4)->pluck('overtime_hours')->toArray();
                                        if(count($nightShift4) > 0){
                                            $overtime4 = ($nightShift4[0] == 4) ? 25 : 30;
                                        }else{
                                            $overtime4 = 0;
                                        }
                                    @endphp
                                    {{ $overtime4}}
                                </td>
                                <td>
                                    @php
                                        $nightShift5 = \App\Attendance::where('employee_id',$data->employee_id)->where('attendance_date',$lastweekEndDate)->where('overtime_hours','>=',4)->pluck('overtime_hours')->toArray();
                                        if(count($nightShift5) > 0){
                                            $overtime5 = ($nightShift5[0] == 4) ? 25 : 30;
                                        }else{
                                            $overtime5 = 0;
                                        }
                                    @endphp
                                    {{ $overtime5 }}
                                </td>
                            <td>{{ $overtime + $overtime1 + $overtime2 + $overtime3 + $overtime4 + $overtime5 }}</td>
                            
                           

                        </tr>
                        @endforeach

                    </tbody>
                </table>

  


            </div><!--printable-->
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
    $("#btnExportNightBill").click(function() {
        var d = new Date();
        var from = '{{ $lastweekStartDate}}';
        var to = '{{ $lastweekEndDate}}';
        let table = document.getElementsByTagName("table");
        TableToExcel.convert(table[0], { // html code may contain multiple tables so here we are refering to 1st table tag
           name: `WeeklyNightBillfrom${from}to${to}.xlsx`, // fileName you could use any name
           sheet: {
              name: 'Sheet 1' // sheetName
           }
        });
    });
});
</script>
@endsection
