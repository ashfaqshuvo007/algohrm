@extends('administrator.master')
@section('title', __('Set Attendance'))

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          {{ __('NEW ATTENDANCE') }}    
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }} </a></li>
            <li><a>{{ __('Attendance') }} </a></li>
            <li class="active">{{ __('New Attendance') }}  </li>
        </ol>
    </section>
 
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title btn-success">{{ __('New Attendance') }}</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="col-md-12">                    
                    <div class=" col-sm-3">
                        <p class="">Set Attendance For : <span class="text-primary h4">{{ $date }}</span></p>
                    </div>  
                    <div  class="col-md-6">
                        <input type="text" id="myInput2" class="form-control" placeholder="{{ __('Search by name or official employee id..') }}">
                    </div>                 
              </div>
              <!-- /. end col -->
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
            <form action="{{ url('/hrm/attendance/store') }}" method="post">
                {{ csrf_field() }}
                <table class="table table-bordered table-striped" id="printable_area">
                    <thead>
                        <tr>
                            <th>{{ __('SL#') }}</th>
                            <th>{{ __('Employee ID') }}</th>
                            <th>{{ __('Employee Name') }}</th>
                            <th>{{ __('In Time') }} </a></th>
                            <th>{{ __('Out Time') }}</a></th>
                        </tr>
                    </thead>
                    <tbody id="search_area">
                        
                        @php ($sl = 1)
                        @foreach($groupedAttendance as $employee)
                        <tr>
                            <td>{{ $sl++ }}</td>
                            <td>{{ $employee[0]->office_id}}
                                {{-- <a href="{{ url('/hrm/attendance/details/' . $employee['id']) }}">{{ $employee['name'] }}</a>
                                <input type="hidden" name="user_id[]" value="{{ $employee['id'] }}">
                                <input type="hidden" name="attendance_date[]" value="{{ $date }}"> --}}
                            </td>
                            <td>{{ $employee[0]->name }}</td>
                            <td>{{ $employee[0]->date_time }}</td>
                            <td>{{ $employee[1]->date_time }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </form>

    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
</section>
<!-- /.content -->
</div>
@endsection