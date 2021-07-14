@extends('administrator.master')
@section('title', __('Leave Report'))

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           {{ __('Leave Report') }} 
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a></li>
            <li><a>{{ __('Leave') }}</a></li>
            <li class="active">{{ __('Leave Report') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Leave Report') }}</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                {{-- <div  class="col-md-6">
                    <a href="{{ url('/hrm/payroll') }}" class="btn btn-primary btn-flat"><i class="fa fa-edit"></i> {{ __('Manage Salary') }}</a>
                </div> --}}
                
                {{-- <div  class="col-md-6">
                    <input type="text" id="myInput" class="form-control" placeholder="{{ __('Search..') }}">
                </div> --}}
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
                                <th>{{ __('Applicant') }}</th>
                                <th>{{ __('Leave Category') }}</th>
                                <th>{{ __('Reason') }}</th>
                                <th>{{ __('Start Date') }}</th>
                                <th>{{ __('Start Date') }}</th>
                                <th>{{ __('No of Days') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created date') }}</th>
                            </tr>
                        </thead>
                       
                        <tbody id="myTable">
                            @php $sl = 1; @endphp
                            @foreach($leave_applications as $leave)
                            <tr>
                                <td>{{ $sl++}}</td>
                                @php
                                    $holiday_for = \App\User::where('id',$leave->holiday_for)->pluck('name');
                                @endphp
                                <td>{{$holiday_for[0]}}</td>
                                <td>{{$leave->category}}</td>
                                <td>{{$leave->reason}}</td>
                                <td>{{ date('d/m/Y', strtotime($leave->start_date)) }}</td>
                                <td>{{ date('d/m/Y', strtotime($leave->end_date)) }}</td>
                                <td class="text-center">
                                    @php($leave_days = \Carbon\Carbon::parse($leave->start_date)->diffInDays(\Carbon\Carbon::parse($leave->end_date))+1)
                                    {{ $leave_days }}
                                </td>
                                @php($created = \App\User::where('id',$leave->created_by)->pluck('name'))
                                <td>{{ $created[0]}}</td>
                                
                                <td class="text-center">
                                    @if($leave->publication_status == 0)
                                    <a href="#" class="btn btn-warning btn-xs btn-flat btn-block" data-toggle="tooltip" data-original-title="Pending"><i class="icon fa fa-hourglass-2"></i>{{ __('Pending') }} </a>
                                    @elseif($leave->publication_status == 1)
                                    <a href="#" class="btn btn-success btn-xs btn-flat btn-block" data-toggle="tooltip" data-original-title="Accepted"><i class="icon fa fa-smile-o"> {{ __('Accepted') }}</i></a>
                                    @else
                                    <a href="#" class="btn btn-danger btn-xs btn-flat btn-block" data-toggle="tooltip" data-original-title="Not Accepted"><i class="icon fa fa-flag"></i> {{ __('Not Accepted') }}</a>
                                    @endif
                                </td>
                                <td>{{$leave->created_at}}</td>
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
        
        var month = "{{ $month }}";
        let table = document.getElementsByTagName("table");
        TableToExcel.convert(table[0], { // html code may contain multiple tables so here we are refering to 1st table tag
           name: `LeaveReport-${month}.xlsx`, // fileName you could use any name
           sheet: {
              name: 'Sheet 1' // sheetName
           }
        });
    });
});
</script>
@endsection