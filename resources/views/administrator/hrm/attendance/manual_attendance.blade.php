@extends('administrator.master')
@section('title', __('Add Manual Attendance'))

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           {{ __('Manual Attendance') }} 
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i>{{ __('Dashboard') }}  </a></li>
            <li><a>{{ __('Manual Attendance') }} </a></li>
            <li class="active">{{ __('Add Manual Attendance') }} </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title ">{{ __('Manual Attendance') }}  </h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
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

            <h5>Setting Attendance For: <span class="text-primary"><b>{{ $employee->name}}</b></span></h5>
            </div>
            <!-- /.Notification Box -->
            <div class="col-md-6">
                <form action="{{ url('/hrm/attendance/manualAttendance/update') }}" name="attendance_update_form" method="post">
                <input type="hidden" name="employee_id" value="{{ $employee->employee_id }}">
                    {{ csrf_field() }}
                    <label for="date">{{ __('Date') }}</label>
                        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }} has-feedback">
                            <input type="date" name="date" id="date" class="form-control" value="{{ $date }}" >
                            @if ($errors->has('date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('date') }}</strong>
                            </span>
                            @endif
                        </div>
                        <!-- /.form-group -->
    
                        <label for="in_time">{{ __('In Time') }} </label>
                        <div class="form-group{{ $errors->has('in_time') ? ' has-error' : '' }} has-feedback">
                            <input type="text" name="in_time" id="manual_in_time" class="form-control" value="" >
                            @if ($errors->has('in_time'))
                            <span class="help-block">
                                <strong>{{ $errors->first('in_time') }}</strong>
                            </span>
                            @endif
                        </div>
                        <!-- /.form-group -->
    
                        <label for="out_time">{{ __('Out Time') }} </label>
                        <div class="form-group{{ $errors->has('out_time') ? ' has-error' : '' }} has-feedback">
                            <input type="text" name="out_time" id="manual_out_time" class="form-control" value="">
                            @if ($errors->has('out_time'))
                            <span class="help-block">
                                <strong>{{ $errors->first('out_time') }}</strong>
                            </span>
                            @endif
                        </div>
                        <!-- /.form-group -->

                    <button class="btn btn-primary" type="submit">Submit Attendance</button>
                </form>
            </div>
            
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->
</div>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js" type="text/javascript"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $.datetimepicker.setDateFormatter('moment');
         // /In Time picker
         $('#manual_in_time').datetimepicker();

        // Out Time picker
        $('#manual_out_time').datetimepicker();

       
    });
</script>
@endsection