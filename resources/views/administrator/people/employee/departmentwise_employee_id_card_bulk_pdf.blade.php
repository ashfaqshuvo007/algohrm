<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('public/backend/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/backend/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('public/backend/bower_components/Ionicons/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('public/backend/plugins/iCheck/all.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/dist/css/AdminLTE.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('public/backend/dist/css/skins/_all-skins.min.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    @yield('page_css')
    <link rel="stylesheet" href="{{ asset('public/backend/mystyle.css') }}">
    <link href="{{ asset('backend/custom_css/custom.css') }}" rel="stylesheet">
    <style>

        body {
            position: relative;
            background: #FFFFFF;
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

    </style>

</head>
<body>
<div class="content-wrapper">


    <!-- Main content -->
    <section class="content">
        <div class="box">

            <div class="box-body">
                @foreach($employees as $employee)
                    @php
                        // dd($employee['employee_type']);
                        if ($employee['employee_type'] == 'executive')
                            {
                                $profileHeaderBackgroundColor = "#03949c";
                                $userSocialDetailsBackgroundColor = "#03949c";
                            }
                        elseif ($employee['employee_type'] == 'staff')
                            {
                                $profileHeaderBackgroundColor = "#ff4500";
                                $userSocialDetailsBackgroundColor = "#ff4500";
                            }
                        else{
                                $profileHeaderBackgroundColor = "#0096dd";
                                $userSocialDetailsBackgroundColor = "#0096dd";
                        }
                    @endphp

                <div class="container">
                        <div class="row">
                            <div class="col-md-4   main-section text-center" style="width: 219px; height: 366px">
                                <div class="row">
                                    <div class="col-sm-12 profile-header"
                                         style="background-color: {{$profileHeaderBackgroundColor}}">
                                        <h4 style="color: white">MAVEN DESIGN LTD.</h4>
                                    </div>
                                </div>
                                <div class="row user-detail">
                                    <div class="col-sm-12 ">
                                        @if(!empty($employee['avatar']))
                                            <img src="{{ url('public/profile_picture/' . $employee['avatar']) }}"
                                                 class="img-responsive img-thumbnail rounded-circle"style="border-radius: 50%">
                                        @else
                                            <img src="{{ url('public/profile_picture/blank_profile_picture.png') }}"
                                                 alt="blank_profile_picture" class="img-responsive img-thumbnail"
                                                 style="border-radius: 50%">

                                        @endif

                                        <table class="table" style="text-align: left;width: 100%;border: none !important;">
                                            <tbody>
                                            <tr>
                                                <th style="font-size: 10px">Employee ID</th>
                                                <td style="font-size: 10px">{{ $employee['employee_id'] }}</td>
                                            </tr>
                                            <tr>
                                                <th style="font-size: 10px">Name</th>
                                                <td style="font-size: 10px">{{ ucwords($employee['name'] )}}</td>
                                            </tr>

                                            <tr>

                                                <th style="font-size: 10px">Designation</th>
                                                <td style="font-size: 10px">{{ucfirst($employee['designation'])  }}</td>
                                            </tr>
                                            <tr>
                                                <th style="font-size: 10px">Department</th>
                                                <td style="font-size: 10px">
                                                    {{ucfirst($employee['department'])}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="font-size: 10px">Type</th>
                                                <td style="font-size: 10px">{{ ucfirst($employee['employee_type']) }}</td>
                                            </tr>
                                            <tr>
                                                <th style="font-size: 10px">Joining Date</th>
                                                <td style="font-size: 10px">{{ date("d-m-Y", strtotime($employee['joining_date'])) }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row user-social-detail"
                                     style="background-color: {{$userSocialDetailsBackgroundColor}}">
                                    <div class="col-sm-4" style="color: white">
                                        <h6>Contact Address</h6>
                                        <h6>22/A, Fatullah, Narayanganj</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                        <div class="col-md-4  main-section text-center"
                             style="width: 219px; height: 366px">
                            <div class="row">
                                <div class="col-lg-4 profile-header"
                                     style="background-color: {{$profileHeaderBackgroundColor}}">
                                    <img src="{{url('public/backend/img/mavenDesignTransparentLogo.png')}}"
                                         alt="MAVEN DESIGN LTD. LOGO" class="img-responsive rounded-circle">
                                </div>
                            </div>
                            <div class="row user-detail">
                                <div class="col-lg-4 ">
                                    <h5 style="padding-bottom: 14px; color: #ff4500;">MAVEN DESIGN LTD.</h5>
                                    <p style="font-size: 10px;margin-top: 5px"><b>If you found this card please return to the following address</b>
                                    </p>
                                    <h6 style="color: #ff4500; padding-top: 4px"><b>CONTACT US</b></h6>
                                    <div class="text-left" style="color: #ff4500;font-size: 10px">
                                        <p style="font-size: 10px; margin-bottom: 0">PRODHAN TOWER, 22/A DN ROAD</p>
                                        <p style="font-size: 10px;margin-bottom: 0">LALPUR FATULLAH, NARAYANGANJ, BANGLADESH</p>
                                        <p style="font-size: 10px;margin-bottom: 0">TEL: +880 1714900206</p>
                                        <p style="font-size: 10px;margin-bottom: 0">EMAIL: info@mavendesignltd.com</p>
                                        <p style="font-size: 10px;margin-bottom: 0">WEBSITE: www.mavendesignltd.com</p>
                                    </div>
                                    <img src="#">
                                    <hr>
                                </div>
                            </div>
                            <div class="row user-social-detail"
                                 style="background-color: {{$userSocialDetailsBackgroundColor}}">
                                <div class="col-lg-4" style="color: white">
                                    <h6>Contact Address</h6>
                                    <h6>22/A, Fatullah, Narayanganj</h6>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>

</body>
</html>