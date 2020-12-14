@extends('administrator.master')
@section('title', __('Generate ID Cards'))

@section('main_content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ __('Generate ID Cards') }}
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('Generate ID Cards') }}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                title="Remove"><i class="fa fa-times"></i></button>
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
{{--                        @php--}}
{{--                            dd($departments);--}}
{{--                        @endphp--}}


{{--                        <form class="form-horizontal" action="{{ url('/hrm/payroll/generate-payslip') }}" method="post">--}}
                        <form class="form-horizontal" action="{{ url('/people/employees/download-deapartmentwise-bulk-emplpoyee-id-card-pdf') }}" method="post">
                        {{ csrf_field() }}


                            <div class="form-group{{ $errors->has('department_id') ? ' has-error' : '' }}">
                                <label for="salary_month"
                                       class="col-sm-3 control-label">{{ __('Employee Department') }}</label>
                                <div class="col-sm-6">
                                    <div class="input-group ">
                                        <select name="department_id" id="department_id" class="form-control">
                                            <option value="0" selected>{{ __('All Department') }}</option>
                                            @foreach($departments as $department)
                                                <option value="{{$department->id}}">{{ $department->department }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('department_id'))
                                            <span class="help-block">
                        <strong>{{ $errors->first('department_id') }}</strong>
                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-10">
                                    <button type="submit" class="btn btn-primary btn-flat"><i
                                                class="fa fa-arrow-right"></i> {{ __('GO') }}</button>
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