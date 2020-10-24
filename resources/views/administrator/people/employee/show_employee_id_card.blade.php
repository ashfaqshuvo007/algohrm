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

                        <div class="container">
                            <div class="row">
                                <div class="offset-lg-4 col-lg-4 col-sm-6 col-12 main-section text-center">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12 profile-header">
                                            <h2 style="color: white">MAVEN DESIGN LTD.</h2>
                                        </div>
                                    </div>
                                    <div class="row user-detail">
                                        <div class="col-lg-12 col-sm-12 col-12">
                                            @if(!empty($employee->avatar))
                                                <img src="{{ url('public/profile_picture/' . $employee->avatar) }}"
                                                     class="img-responsive img-thumbnail rounded-circle">
                                            @else
                                                <img src="{{ url('public/profile_picture/blank_profile_picture.png') }}"
                                                     alt="blank_profile_picture" class="img-responsive img-thumbnail"
                                                     style="border-radius: 50%">

                                            @endif
                                            <table class="table" style="text-align: right">
                                                <tbody>
                                                <tr>
                                                    <th>Name</th>
                                                    <td>{{ $employee->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Employee ID</th>
                                                    <td>{{ $employee->employee_id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Designation</th>
                                                    <td>{{ $employee->designation }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Department</th>
                                                    <td>
                                                        @foreach($departments as $department)
                                                            @if($employee->joining_position == $department->id)
                                                                {{ $department->department }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Type</th>
                                                    <td>{{ $employee->employee_type }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Joining Date</th>
                                                    <td>{{ date("D d F Y", strtotime($employee->joining_date)) }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row user-social-detail">
                                        <div class="col-lg-12 col-sm-12 col-12" style="color: white">
                                            <h4>Contact Address</h4>
                                            <h5>22/A, Fatullah, Narayanganj</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="offset-lg-4 col-lg-4 col-sm-6 col-12 main-section text-center" style="margin-left: 10px">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12 profile-header">
                                            <h2 style="color: white">MAVEN DESIGN LTD.</h2>
                                        </div>
                                    </div>
                                    <div class="row user-detail">
                                        <div class="col-lg-12 col-sm-12 col-12">
                                            <h2>MAVEN DESIGN LTD.</h2>
                                            <p>If you found this card please return to the following address</p>
                                            <h2>CONTACT US</h2>
                                            <p>PRODHAN TOWER, 22/A,D,N ROAD</p>
                                            <p>LALPUR FATULLAH, NARAYANGANJ, BANGLADESH</p>
                                            <p>TEL : +88-02-7670608-9</p>
                                            <p>FAX : +88-02-7670646</p>
                                            <p>EMAIL : SABUR@MAVENDESIGNLTD.COM</p>
                                            <p>WEBSITE : WWW.MAVENDESIGNLTD.COM</p>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row user-social-detail">
                                        <div class="col-lg-12 col-sm-12 col-12" style="color: white">
                                            <h4>Contact Address</h4>
                                            <h5>22/A, Fatullah, Narayanganj</h5>
                                        </div>
                                    </div>
                                </div>

                            </div>
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