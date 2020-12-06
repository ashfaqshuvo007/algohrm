@extends('administrator.master')
@section('title', __('Employee Payslip'))
@section('page_css')
    <link href="{{ asset('backend/custom_css/custom.css') }}" rel="stylesheet">
@endsection

@section('main_content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ __(' PAYSLIP') }}
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i>{{ __('Dashboard') }} </a></li>
                <li><a>{{ __('People') }}</a></li>
                <li><a href="{{ url('/people/employees') }}">{{ __('Team') }}</a></li>
                <li class="active">{{ __('Details') }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('Employee ID CARD') }}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>

                @php
                    if ($employee->employee_type == 'Executive')
                        {
                            $profileHeaderBackgroundColor = "#03949c";
                            $userSocialDetailsBackgroundColor = "#03949c";
                        }
                    elseif ($employee->employee_type == 'Staff')
                        {
                            $profileHeaderBackgroundColor = "#ff4500";
                            $userSocialDetailsBackgroundColor = "#ff4500";
                        }
                    else{
                            $profileHeaderBackgroundColor = "#0096dd";
                            $userSocialDetailsBackgroundColor = "#0096dd";
                    }
                @endphp

                <div class="box-body">
                    <a href="{{ url('/people/employees') }}" class="btn btn-primary btn-flat"><i
                                class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                    <hr>
                    <div id="printable_area">

                        <div class="container">
                            <div class="row">
                                <div class="offset-lg-4 col-lg-4 col-sm-6 col-12 main-section text-center">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12 profile-header"
                                             style="background-color: {{$profileHeaderBackgroundColor}}">
                                            <h4 style="color: white">MAVEN DESIGN LTD.</h4>
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

                                            <table class="table" style="text-align: left">
                                                <tbody>
                                                <tr>
                                                    <th>Employee ID</th>
                                                    <td>{{ $employee->employee_id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Name</th>
                                                    <td>{{ $employee->name }}</td>
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
                                    <div class="row user-social-detail"
                                         style="background-color: {{$userSocialDetailsBackgroundColor}}">
                                        <div class="col-lg-12 col-sm-12 col-12" style="color: white">
                                            <h4>Contact Address</h4>
                                            <h5>22/A, Fatullah, Narayanganj</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="offset-lg-4 col-lg-4 col-sm-6 col-12 main-section text-center"
                                     style="margin-left: 10px" style="width: 218.88px">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12 profile-header"
                                             style="background-color: {{$profileHeaderBackgroundColor}}">
                                            <img src="{{url('public/backend/img/mavenDesignTransparentLogo.png')}}"
                                                 alt="MAVEN DESIGN LTD. LOGO" class="img-responsive rounded-circle">
                                        </div>
                                    </div>
                                    <div class="row user-detail">
                                        <div class="col-lg-12 col-sm-12 col-12">
                                            <h3 style="padding-bottom: 10px; color: #ff4500;">MAVEN DESIGN LTD.</h3>
                                            <h4><b>If you found this card please return to the following address</b>
                                            </h4>
                                            <h3 style="color: #ff4500; padding-top: 6px"><b>CONTACT US</b></h3>
                                            <div class="text-left" style="color: #ff4500">
                                                <p>PRODHAN TOWER, 22/A DN ROAD</p>
                                                <p>LALPUR FATULLAH, NARAYANGANJ, BANGLADESH</p>
                                                <p>TEL : +880-1714900206, +880-19105039448</p>
                                                <p>EMAIL : info@mavendesignltd.com</p>
                                                <p>WEBSITE : www.mavendesignltd.com</p>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row user-social-detail"
                                         style="background-color: {{$userSocialDetailsBackgroundColor}}">
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