@extends('administrator.master')
@section('title', __('Team member details'))
@section('page_css')
    <link href="{{ asset('backend/custom_css/custom.css') }}" rel="stylesheet">
@endsection

@section('main_content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ __(' TEAM') }}
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i>{{ __('Dashboard') }} </a></li>
                <li><a>{{ __('People') }}</a></li>
                <li><a href="{{ url('/people/employees') }}">{{ __('Team') }}</a></li>
                <li class="active">{{ __('Details') }}</li>
            </ol>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('Team member details') }}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <a href="{{ url('/people/employees') }}" class="btn btn-primary btn-flat"><i
                                class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    <hr>
                    <div id="printable_area">

                        <div class="row col-lg-12 text-center">
                            <h2>FAKIR KNITWEARS LTD</h2>
                            <h4>Kayempur, Fatullah, Narayanganj</h4>
                            <h5>PAYSLIP</h5>
                            <p>(Mobile Banking)</p>
                        </div>
                        <div class="row col-md-2 text-center">
                        </div>

                        <div class="row col-md-4 text-center">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>NAME</th>
                                    <td>{{ $employee->name }}</td>
                                </tr>
                                <tr>
                                    <th>EMPLOYEE ID</th>
                                    <td>{{ $employee->employee_id }}</td>
                                </tr>
                                <tr>
                                    <th>DEPARTMENT</th>
                                    <td>@foreach($departments as $department)
                                            @if($employee->joining_position == $department->id)
                                                {{ $department->department }}
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>DESIGNATION</th>
                                    <td>{{ $employee->designation }}</td>
                                </tr>

                                <tr>
                                    <th>TYPE</th>
                                    <td>{{ $employee->employee_type }}</td>
                                </tr>
                                <tr>
                                    <th>JOINING DATE</th>
                                    <td>{{ date("D d F Y", strtotime($employee->joining_date)) }}</td>
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
                                    <td>{{ $employee->employee_id }}</td>
                                </tr>
                                <tr>
                                    <th>মূল মজুরী</th>
                                    <td>{{$salary['basic_salary']}}</td>
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
                                    <th>উপস্থিতি বোনাস</th>
                                    <td>{{$salary['att_bonus']}}</td>
                                </tr>

                                <tr>
                                    <th>বর্ধিত পরিমাণ</th>
                                    <td>{{$salary['increment_amount']}}</td>
                                </tr>

                                <tr>
                                    <th>অনুপস্থিতি কর্তন</th>
                                    <td>{{$salary['absent_deduction']}}</td>
                                </tr>
                                </tbody>
                            </table>

                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>মোট মজুরী</th>
                                    <td>{{$salary['basic_salary'] + $salary['house_rent']+ $salary['medical_allowance']+ $salary['convayence']+ $salary['food_allowance']+ $salary['att_bonus']+$salary['increment_amount']}}</td>
                                </tr>
                                <tr>
                                    <th>মোট কর্তন</th>
                                    <td>{{$salary['absent_deduction']}}</td>
                                </tr>
                                <tr>
                                    <th>সর্বমোট</th>
                                    <td>{{$salary['basic_salary'] + $salary['house_rent']+ $salary['medical_allowance']+ $salary['convayence']+ $salary['food_allowance']+ $salary['att_bonus']+$salary['increment_amount'] - $salary['absent_deduction']}}</td>
                                </tr>
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
                    <!-- /.End Button -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
@endsection