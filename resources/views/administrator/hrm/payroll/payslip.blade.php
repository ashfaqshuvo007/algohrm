<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html"/>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('public/backend/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/backend/bower_components/font-awesome/css/font-awesome.min.css') }}">

    <!-- My Stylesheet -->
    @yield('page_css')
    <link rel="stylesheet" href="{{ asset('public/backend/mystyle.css') }}">
    <!-- /My Stylesheet -->
    <!-- Google Font -->

   <style>
       body{
           margin: 0;
           padding: 0;
       }
       .bangla{
           font-family: DejaVu Sans;
       }
       .table{
           font-size: 20px;
           text-align:left;"
       }
       tr,td{
           font-size:9px;
       }
 </style>
<!-- jQuery 3 -->
    <script src="{{ asset('public/backend/bower_components/jquery/dist/jquery.min.js') }}"></script>
</head>

<body>
@php $sl = 1; @endphp
@foreach($salaries as $salary)
    @php
        $present = \App\Attendance::where('employee_id',$salary['employee_id'])->where(DB::raw('MONTH(attendance_date)'), $salryMonth)->get()->toArray();
        $presentCount = count($present);
        $workingDays = $numDays - $totalHolidays;
        $absent_days = (int)$workingDays - (int)$presentCount;
        $absent_days = (int)$absent_days;
       
        $hours_overtime = array_column($present,'overtime_hours');
        $total_overtime = array_sum($hours_overtime);
    @endphp
    <div class="content-wrapper">

        <section class="content">
            <!-- Default box -->

            <div class="box">
                <div class="box-body">
                    <div id="printable_area">

                        <div>
                            <div class="row col-md-12" style="text-align:center;font-size: 10px">
                                <p style="margin-bottom: 0px;">MAVEN DESIGN LTD</p>
                                <p style="margin-bottom: 0px;">Prodhan Tower, 22/A DN, Lalpur, Fatullah, Narayangonj</p>
                                <p style="margin-bottom: 0px;">PAYSLIP -- &nbsp;<b>{{$salaryMonthAndYear}}</b></p>
                                <p style="margin-bottom: 0px;"> For : &nbsp;<b>{{ $salary['name']  }}</p>
                            </div>
                            <br>
                            
                        </div>
                        <div class="row col-md-12" >
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>EMPLOYEE ID : </td>
                                    <td style="text-align:right">{{ $salary['employee_id'] }}</td>
                                </tr>
                                <tr>
                                    <td>DESIGNATION : </td>
                                    <td style="text-align:right">{{ $salary['designation'] }}</td>
                                </tr>

                                <tr>
                                    <td>GRADE : </td>
                                    <td style="text-align:right">{{ $salary['grade_id'] }}</td>
                                </tr>
                                <tr>
                                    <td>JOINING DATE: </td>
                                    <td style="text-align:right">{{ $salary['joining_date'] }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="row col-md-12">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>BASIC SALARY : </td>
                                    <td style="text-align:right">{{$salary['basic_salary']}} </td>
                                </tr>
                                <tr>
                                    <td>HOUSE RENT : </td>
                                    <td style="text-align:right">{{$salary['house_rent']}}</td>
                                </tr>
                                <tr>
                                    <td>MEDICAL ALLOWANCE : </td>
                                    <td style="text-align:right">{{$salary['medical_allowance']}}</td>
                                </tr>
                                <tr>
                                    <td>CONVAYENCE : </td>
                                    <td style="text-align:right">{{$salary['convayence']}}</td>
                                </tr>
                                <tr>
                                    <td>FOOD ALLOWANCE : </td>
                                    <td style="text-align:right">{{$salary['food_allowance']}}</td>
                                </tr>
                                <tr>
                                    <td>OVERTIME (HOURS) : </td>
                                    <td style="text-align:right">
                                        @php
                                        if($salary['employee_type'] == 'worker'){
                                            if($total_overtime < 0 ){
                                                $actual_overtime = 0;
                                            }else{
                                                $actual_overtime = $total_overtime ;
                                            }
                                        }else{
                                            $actual_overtime = "N/A";
                                        }
                                        @endphp
                                        {{ $actual_overtime  }}
                                    </td>
                                </tr>
                                @php
                                    if($salary['employee_type'] == 'worker'){
                                       
                                        $overtime_rate = (int)$salary['overtime_rate'];
                                        $overtime_taka = (int)$actual_overtime * $overtime_rate;
                                    }else{
                                        $overtime_rate = "N/A";
                                        $overtime_taka = "N/A";
                                    }
                                @endphp
                                <tr>
                                    <td>OVERTIME RATE : </td>
                                    <td style="text-align:right">{{$overtime_rate}}</td>
                                </tr>
                                <tr>
                                    <td>OVERTIME TAKA : </td>
                                    <td style="text-align:right">{{ $overtime_taka }}</td>
                                </tr>
                                <tr>
                                    <td>ATTENDANCE BONUS : </td>
                                    <td style="text-align:right">
                                        @php
                                            if($absent_days > 0){
                                                $bonus = 0;
                                            }else{
                                              $bonus = $salary['att_bonus'];

                                            }
                                        @endphp
                                        {{$bonus}}
                                    </td>
                                </tr>

                                <tr>
                                    <td>INCREMENT AMOUNT (added per year)</td>
                                    @php
                                    $increment = ($salary['increment_amount'] == null) ? 0 : $salary['increment_amount'];

                                    $join = strtotime($salary['joining_date']);
                                    $today = strtotime(date("Y-m-d"));
                                    $days = (int)(($join - $today)/86400);

                                    $factor = $days/365;
                                    if (($factor) > 0){
                                        $act_increment_amount = $increment * $factor;
                                    }else{
                                        $act_increment_amount = $increment * 0;
                                    }

                                    @endphp
                                    <td style="text-align:right">{{ $act_increment_amount }}</td>
                                </tr>

                                <tr>
                                    <td>ABSENT DEDUCTION : </td>
                                    @php
                                    $gross_salary = (int)$salary['basic_salary'] + (int)$salary['house_rent'] + (int)$salary['medical_allowance'] + (int)$salary['food_allowance'] + (int)$salary['convayence'] + (int)$act_increment_amount + (int)$bonus + (int)$overtime_taka; 
                                    $total_additional = $bonus + $act_increment_amount + $overtime_taka;
                                    $amount_to_deduct = intval($gross_salary / $numDays);
                                    $tot_absent_deduction = $amount_to_deduct * $absent_days;
                                    $net_payable = $gross_salary + $total_additional - $tot_absent_deduction; 

                                    @endphp
                                    <td style="text-align:right">{{$tot_absent_deduction}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        @php
                            $gross_salary = (int)$salary['basic_salary'] + (int)$salary['house_rent'] + (int)$salary['medical_allowance'] + (int)$salary['food_allowance'] + (int)$salary['convayence'] + (int)$act_increment_amount + (int)$bonus + (int)$overtime_taka; 
                            $total_additional = $bonus + $act_increment_amount + $overtime_taka;
                            $net_payable = $gross_salary + $total_additional - $tot_absent_deduction;
                        @endphp
                        <div class="row col-md-12">
                            <table class="table" >
                                <tbody>
                                <tr>
                                    <td>GROSS SALARY : </td>
                                    <td style="text-align:right"> @php @endphp
                                        {{ $gross_salary }}</td>
                                </tr>
                                <tr>
                                    <td>TOTAL DEDUCTION : </td>
                                    <td style="text-align:right"> - {{$tot_absent_deduction}}</td>
                                </tr>
                                <tr>
                                    <td><b>TOTAL PAYABLE : </b></td>
                                    <td style="text-align:right"><b>{{ $net_payable }}</b></td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
            <!-- /.box-body -->
            <!-- /.box -->
            <p style="font-size:5px; text-align:center;page-break-after:always;">Developed by <b>Algodevs</b></p>
        </section>

        <!-- /.content -->
    </div >


@endforeach
</body>
</html>