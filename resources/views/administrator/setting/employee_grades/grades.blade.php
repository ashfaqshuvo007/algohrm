@extends('administrator.master')
@section('title', __('Employee Grades'))

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           {{ __(' Employee Grades') }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a></li>
            <li><a>{{ __('Setting') }}</a></li>
            <li class="active">{{ __('Manage Employee Grades') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Manage Employee Grades') }}</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                
                <div  class="col-md-6">
                    <a href="{{ url('/setting/employee_grades/create') }}" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i>{{ __('Add Grades') }} </a>
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
                <div class="col-md-12 table-responsive">
                    <table  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">{{ __('SL#') }}</th>
                                <th class="text-center">{{ __('Grade') }}</th>
                                <th class="text-center">{{ __('Created By') }}</th>
                                <th class="text-center">{{ __('Basic Salary') }}</th>
                                <th class="text-center">{{ __('Yearly Increment Rate') }}</th>
                                <th class="text-center">{{ __('House Rent') }}</th>
                                <th class="text-center">{{ __('Medical Allowance') }}</th>
                                <th class="text-center">{{ __('Convayence') }}</th>
                                <th class="text-center">{{ __('Food Allowance') }}</th>
                                <th class="text-center">{{ __('Total Salary Payable') }}</th>
                                <th class="text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @php($sl = 1)
                            @foreach($grades as $g)
                            <tr>
                                <td class="text-center">{{ $sl++ }}</td>
                                <td class="text-center">{{ $g['grade'] }}</td>
                                <td class="text-center">{{ $g['name'] }}</td>
                                <td class="text-center">{{ $g['basic_salary'] }}</td>
                                <td class="text-center">{{ $g['yearly_increment_rate'] }}</td>
                                <td class="text-center">{{ $g['house_rent'] }}</td>
                                <td class="text-center">{{ $g['medical_allowance'] }}</td>
                                <td class="text-center">{{ $g['convayence'] }}</td>
                                <td class="text-center">{{ $g['food_allowance'] }}</td>
                                <td class="text-center">{{ $g['basic_salary'] + $g['medical_allowance'] + $g['convayence'] + $g['food_allowance']  + $g['house_rent'] }}</td>
                                <td class="text-center">
                                    <a href="{{ url('/setting/employee_grades/edit/' . $g['id']) }}"><i class="icon fa fa-edit"></i>{{ __('Edit') }} </a>
                                </td>
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
@endsection
