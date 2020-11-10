@extends('administrator.master')
@section('title', __('Set Past Attendance'))

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          {{ __('PAST ATTENDANCE') }}    
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
                <h3 class="box-title btn-success">{{ __('Past Attendance') }}</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="col-md-12">                    
                    <div class=" col-sm-3">
                        <p class="">Set Attendance For : <span class="h4">{{ $date }}</span></p>
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
            
                <table class="table table-bordered table-striped" id="printable_area">
                    <thead>
                        <tr>
                            <th>{{ __('SL#') }}</th>
                            <th>{{ __('Employee ID') }}</th>
                            <th>{{ __('Employee Name') }}</th>
                            <th>{{ __('In Time') }} </a></th>
                            <th>{{ __('Out Time') }}</a></th>
                            <th>{{ __('Action') }}</a></th>
                        </tr>
                    </thead>
                    <tbody id="search_area">
                        
                       
                        @php $sl = 1; @endphp
                        @foreach($past_att as $employee)
                        <tr>
                            <td>{{ $sl++ }}</td>
                            <td>{{ $employee->employee_id}}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->check_in }}</td>
                            <td>{{ $employee->check_out }}</td>
                            <td class="text-center">
                                {{-- <a href="{{ url('hrm/attendance/past/'.$employee->id.'/edit') }}"><i class="icon fa fa-edit"></i></a> --}}
                                <a href="#" data-toggle="modal" data-target="#editAttendance"><i class="icon fa fa-edit"></i></a>
                            </td>
                        </tr>
                        <!-- Modal -->
                <div class="modal fade" id="editAttendance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <form action="{{ url('/hrm/attendance/storePastAttendance') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="row_id" id="row_id" class="form-control" value="{{ $employee->id }}">

                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <label for="date">{{ __('Date') }}</label>
                                        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }} has-feedback">
                                            <input type="date" name="date" id="date" class="form-control" value="{{ $date }}" disabled>
                                            @if ($errors->has('date'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('date') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <!-- /.form-group -->
                    
                                        <label for="check_in">{{ __('Check In Time') }} </label>
                                        <div class="form-group{{ $errors->has('check_in') ? ' has-error' : '' }} has-feedback">
                                        <input type="text" name="check_in" id="check_in" class="form-control" value="{{$employee->check_in}}" >
                                            @if ($errors->has('check_in'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('check_in') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <!-- /.form-group -->
                    
                                        <label for="check_out">{{ __('Check Out Time') }} </label>
                                        <div class="form-group{{ $errors->has('check_out') ? ' has-error' : '' }} has-feedback">
                                            <input type="text" name="check_out" id="check_out" class="form-control" value="{{$employee->check_out}}">
                                            @if ($errors->has('check_out'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('check_out') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <!-- /.form-group -->
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
        </div>
        </form>
    </div>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
    <!-- /.box-body -->
        </div>
<!-- /.box -->
    </section>
<!-- /.content -->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $.datetimepicker.setDateFormatter('moment');
         // /In Time picker
         $('#check_in').datetimepicker();

        // Out Time picker
        $('#check_out').datetimepicker();

       
    });
</script>
@endsection