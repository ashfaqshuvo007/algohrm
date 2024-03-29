@extends('administrator.master')
@section('title', __('Genrate Wages list'))

@section('main_content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{ __('Genrate Wages list') }}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a></li>
      <li><a>{{ __('Wages') }}</a></li>
      <li class="active">{{ __('Genrate Wages list') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">{{ __('Genrate Wages list') }}</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
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
        <div class="col-md-12">


          <form class="form-horizontal" action="{{ url('/hrm/payroll/wages-list') }}" method="post">
            {{ csrf_field() }}

              <!-- /.end group -->
              <div class="form-group{{ $errors->has('salary_month') ? ' has-error' : '' }}">
                <label for="salary_month" class="col-sm-3 control-label">{{ __('Select Month') }}</label>
                <div class="col-sm-6">
                  <div class="input-group date">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input type="text" name="salary_month" id="monthpicker" class="form-control pull-right" value="{{ old('salary_month')}}" id="datepicker">
                    @if ($errors->has('salary_month'))
                    <span class="help-block">
                      <strong>{{ $errors->first('salary_month') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
              </div>
              <div class="form-group{{ $errors->has('emp_office_id') ? ' has-error' : '' }}">
                <label for="salary_month" class="col-sm-3 control-label">{{ __('Employees') }}</label>
                <div class="col-sm-6">
                  <div class="input-group ">
                    <select name="emp_office_id" id="emp_office_id" class="form-control">
                      <option value="0" selected>{{ __('All Employees') }}</option>
                      @foreach($employees as $employee)
                      <option value="{{$employee->id}}">{{ $employee->employee_id }}</option>
                      @endforeach
                    </select>
                    @if ($errors->has('emp_office_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('emp_office_id') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
              </div>
              <div class="form-group{{ $errors->has('emp_grade') ? ' has-error' : '' }}">
                <label for="salary_month" class="col-sm-3 control-label">{{ __('Employee Grades') }}</label>
                <div class="col-sm-6">
                  <div class="input-group ">
                    <select name="emp_grade" id="emp_grade" class="form-control">
                      <option value="0" selected>{{ __('All Grades') }}</option>
                      @foreach($grades as $grade)
                      <option value="{{$grade->id}}">{{ $grade->grade }}</option>
                      @endforeach
                    </select>
                    @if ($errors->has('emp_grade'))
                    <span class="help-block">
                        <strong>{{ $errors->first('emp_grade') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
              </div>
              
             
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-10">
                  <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-arrow-right"></i> {{ __('GO') }}</button>
                </div>
              </div>
              <!-- /.end group -->
            </form>
            <!-- /. end form -->
          </div>
          <!-- /. end col -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix"></div>
        <!-- /.box-footer -->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  @endsection