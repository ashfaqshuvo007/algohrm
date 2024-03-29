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
    

    <!-- Google Font -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
    <style>
        .name{
            font-size: 9px;
            font-align: left;
        }
        th,td{
            font-size: 10px;
        }
        th{
            text-align:left;
        }
        td{
            text-align: right;
        }
        table{
            margin: 5px 0px;
        }
        .main-section{
            /* border:1px solid #138496; */
            background-color: #fff;
        }
        .profile-header{
            height:120px;
        }
        .address{
            font-size: 10px;
            color: #ff4500;
        }
        .address p {
            margin: 0;
            padding: 0;
        }
        .profile-header img{
            max-width:200px;
            margin: 0;
            padding: 0;
        }
        .user-detail{
            margin:-50px 0px 20px 0px;
        }
        .user-detail img{
            max-width:100px;
            border-radius: 50%;
        }

        .user-social-detail{
            background-color: #17a2b8;
            min-height: 150px;
        }
        .user-social-detail a i{
            color:#fff;
            font-size:14px;
            padding: 0px 5px;
        }


    </style>

</head>
<body>
<div class="content-wrapper">


    <!-- Main content -->
    <section class="content">
        
        <div class="box">
            @php
                if ($employee->employee_type == 'executive')
                    {
                        $profileHeaderBackgroundColor = "#03949c";
                        $userSocialDetailsBackgroundColor = "#03949c";
                    }
                elseif ($employee->employee_type == 'staff')
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
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 main-section text-center" id="front-part" style="width: 205px; max-height: 328px; max-width: 205px; height: 328px">
                                <div class="row">
                                    <div class="col-sm-12 profile-header"style="background-color: {{$profileHeaderBackgroundColor}}">
                                        <h4 style="color: white">MAVEN DESIGN LTD.</h4>
                                    </div>
                                </div>
                                <div class="row user-detail" style="">
                                    <div class="col-sm-12 ">
                                        @if(!empty($employee->avatar))
                                            <img src="{{ url('public/profile_picture/' . $employee->avatar) }}"
                                                 style="border-radius: 50%" class="" width="100" height="100">
                                        @else
                                            <img src="{{ url('public/profile_picture/blank_profile_picture.png') }}"
                                                 alt="blank_profile_picture"
                                                 style="border-radius: 50%" class="" width="100" height="100">

                                        @endif

                                        <table style="text-align: left;width: 100%;border: none !important; margin-bottom: 0px;">
                                            <tbody>
                                            <tr>
                                                <th>Employee ID</th>
                                                <td style="color: red;">{{ $employee->employee_id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Name</th>
                                                <td class="name">{{ ucwords($employee->name) }}</td>
                                            </tr>

                                            <tr>
                                                <th>Designation</th>
                                                <td>{{ ucfirst($employee->designation) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Department</th>
                                                <td>
                                                    {{ ucfirst($employee->department) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Employee Type</th>
                                                <td>{{ ucfirst($employee->employee_type )}}</td>
                                            </tr>
                                            <tr>
                                                <th>Joining Date</th>
                                                <td>{{ date("d-m-Y", strtotime($employee->joining_date)) }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row user-social-detail" style="background-color: {{$userSocialDetailsBackgroundColor}};">
                                    <div class="col-sm-4" style="color: white">
                                        <h6 style="color: white;font-weight:bold;">Contact Address</h6>
                                        <h6 style="color: white;font-weight:bold;">22/A, Fatullah, Narayanganj</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br><br>
                        <div class="row">
                            <div class="col-md-4  main-section text-center" id="back-part" style="width: 205px; max-height: 328px; max-width: 205px; height: 328px">
                                <div class="row profile-header">
                                    <div style="background-color: {{$profileHeaderBackgroundColor}}">
                                        <img src="{{url('public/backend/img/mavenDesignTransparentLogo.png')}}"
                                            alt="MAVEN DESIGN LTD. LOGO" class="img-responsive">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4" style="margin-bottom: 10px;">
                                        <p style="font-size: 9px; margin:30px 0px 0px 0px;"><b>If found, please return to the following address</b>
                                        </p>
                                        <h5 style="color: #ff4600; margin: 9.25px 0px">MAVEN DESIGN LTD.</h5>
                                        <div class="text-center address">
                                            <p>PRODHAN TOWER, 22/A DN ROAD</p>
                                            <p>LALPUR FATULLAH, NARAYANGANJ, BANGLADESH</p>
                                            <p>TEL: +880 1714900206</p>
                                            <p>EMAIL: info@mavendesignltd.com</p>
                                            <p>WEBSITE: www.mavendesignltd.com</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row user-social-detail"style="background-color: {{$userSocialDetailsBackgroundColor}};">
                                    <div class="col-lg-4" style="color: white">
                                        <h6 style="color: white;font-weight:bold;">Contact Address</h6>
                                        <h6 style="color: white;font-weight:bold;">22/A, Fatullah, Narayanganj</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<script>
   var frontPart = document.querySelector('#front-part').offsetHeight;
   var backPart = document.querySelector('#back-part');
   backPart.style.offsetHeight = frontPart;
</script>

</body>
</html>