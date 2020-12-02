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
        @font-face
        {
            font-family: 'bangla';
            src: url({{ storage_path('fonts/SolaimanLipi.ttf') }}) format('truetype');
        }
        th{
            background-color: red;
        }

    </style>
    <!-- jQuery 3 -->
    <script src="{{ asset('public/backend/bower_components/jquery/dist/jquery.min.js') }}"></script>
</head>

<body>
<div class="content-wrapper">
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <div id="printable_area">
                    @php $sl = 1; @endphp
                    @foreach($salaries as $salary)
                        @php
                            $present = \App\Attendance::where('employee_id',$salary['employee_id'])->whereMonth('created_at',$salryMonth)->first()->toArray();
                            // dd((int)$present['overtime_hours']);
                            $presentCount = count($present);
                            $workingDays = date("t") - $totalHolidays;
                            $absent_days = $workingDays - $presentCount;
                        @endphp
                        <div>
                            <div class="row col-lg-12 text-center">
                                <h2>MAVEN DESIGN LTD</h2>
                                <h4>Prodhan Tower, 22/A DN, Lalpur, Fatullah, Narayangonj</h4>
                                <h5>PAYSLIP</h5>
                                <p><b>{{$salaryMonthAndYear}}</b></p>
                            </div>
                            <div class="row col-md-2 text-center">
                            </div>
                            <div class="row col-md-4 text-center">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <th>EMPLOYEE ID</th>
                                        <td>{{ $salary['employee_id'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>NAME</th>
                                        <td>{{ $salary['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>DESIGNATION</th>
                                        <td>{{ $salary['designation'] }}</td>
                                    </tr>

                                    <tr>
                                        <th>GRADE</th>
                                        <td>{{ $salary['grade_id'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>JOINING DATE</th>
                                        <td>{{ $salary['joining_date'] }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row col-md-2 text-center">
                            </div>
                            <div class="row col-md-4 text-center">
                                <table class="table" cellspacing="0" cellpadding="0" style="border:none;">
                                    <tbody style="border:none;">
                                    <tr>
                                        <th style="font-family: 'bangla'">মূল মজুরী</th>
                                        <td>{{$salary['basic_salary']}} </td>
                                    </tr>
                                    <tr>
                                        <th >বাড়ি ভাড়া</th>
                                        <td>{{$salary['house_rent']}}</td>
                                    </tr>
                                    <tr>
                                        <th >চিকিৎসা ভাতা</th>
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
                                        <th>{{ __('অতিরিক্ত সময় (ঘন্টা)') }}</th>
                                        <td>
                                            @php
                                                if($present['overtime_hours'] < 0){
                                                    $overtime_hours = 0;
                                                }else{
                                                    $overtime_hours = $present['overtime_hours'];
                                                }
                                                if($overtime_hours > 30 ){

                                                }
                                                $audit_overtime_hours = 30;
                                                $actual_overtime_hours = $overtime_hours > $audit_overtime_hours ? $audit_overtime_hours : $overtime_hours;
                                            @endphp
                                            {{ $actual_overtime_hours  }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('অতিরিক্ত সময় হার') }}</th>
                                        <td>{{$salary['overtime_rate']}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('অতিরিক্ত সময় টাকা') }}</th>
                                        @php
                                            $overtime_money = $overtime_hours * (int)$salary['overtime_rate'];
                                        @endphp
                                        <td>{{ $overtime_money }}</td>
                                    </tr>
                                    <tr>
                                        <th>উপস্থিতি বোনাস</th>
                                        <td>
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
                                        <th>বর্ধিত পরিমাণ</th>
                                        <td>{{($salary['increment_amount'] == null) ? 0 : $salary['increment_amount']}}</td>
                                    </tr>

                                    <tr>
                                        <th>অনুপস্থিতি কর্তন</th>
                                        @php $total_deduction = ((int)$salary['absent_deduction'] * ($workingDays - $presentCount)); @endphp
                                        <td>{{$total_deduction}}</td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <th>মোট মজুরী</th>
                                        <td> @php $gross_salary = (int)$salary['basic_salary'] + (int)$salary['house_rent'] + (int)$salary['medical_allowance'] + (int)$salary['food_allowance'] + (int)$salary['convayence'] + (int)$salary['increment_amount'] + (int)$bonus + (int)$overtime_money; @endphp
                                            {{ $gross_salary }}</td>
                                    </tr>
                                    <tr>
                                        <th>মোট কর্তন</th>
                                        <td>{{$total_deduction}}</td>
                                    </tr>

                                    <tr>
                                        <th>সর্বমোট</th>
                                        <td>{{ $gross_salary - $total_deduction }}</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>

</body>
</html>
