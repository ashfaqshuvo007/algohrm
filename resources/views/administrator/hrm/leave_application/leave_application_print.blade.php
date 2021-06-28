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
                    <div class="text-center">
                        <h5><strong>{{ __('APPLICATION FOR LEAVE') }}</strong></h5>
                      </div>
                    <div id="printable_area">
                        
                        <table  class="table">
                            <tbody id="myTable">
                              <tr>
                                <td>{{ __('Name of Applicant') }}</td>
                                <td>{{ $leave_application['name'] }}</td>
                              </tr>
                              <tr>
                                <td>{{ __('ID No.') }}</td>
                                <td>{{ $leave_application['employee_id'] }}</td>
                              </tr>
                              <tr>
                                <td>{{ __('Designation') }}</td>
                                <td>{{ $leave_application['designation'] }}</td>
                              </tr>
                              <tr>
                                <td>{{ __('Leave Category') }}</td>
                                <td>{{ $leave_application['leave_category'] }}</td>
                              </tr>
                              <tr>
                                <td>{{ __('Start Date') }}</td>
                                <td>{{ date("d F Y", strtotime( $leave_application['start_date'] )) }}</td>
                              </tr>
                              <tr>
                                <td>{{ __('End date') }}</td>
                                <td>{{ date("d F Y", strtotime($leave_application['end_date'])) }}</td>
                              </tr>
                              <tr>
                                <td>{{ __('Leave Days') }}</td>
                                <td>
                                  @php($leave_days = \Carbon\Carbon::parse($leave_application['start_date'])->diffInDays(\Carbon\Carbon::parse($leave_application['end_date']))+1)
                                  {{ $leave_days }}
                                </td>
                              </tr>
                              <tr>
                                <td>{{ __('Reason for Leave') }}</td>
                                <td>{{ $leave_application['reason'] }}</td>
                              </tr>
                               <tr>
                                <td>{{ __('Date of return from Last Leave') }}</td>
                                <td>{{ date("d F Y", strtotime($leave_application['last_leave_date'])) }}</td>
                              </tr>
                              <tr>
                                <td>{{ __('Period of Last Leave') }}</td>
                                <td>{{ $leave_application['last_leave_period'] }} Days</td>
                              </tr>
                              <tr>
                                <td>{{ __('Category of Last Leave') }}</td>
                                <td>{{ $leave_application['leave_category'] }}</td>
                              </tr>
                              <tr>
                                <td>{{ __('Leave Address') }}</td>
                                <td>{{ $leave_application['leave_address'] }}</td>
                              </tr>
                              <tr>
                                <td>{{ __('Performing person during leave') }}</td>
                                <td>{{ $leave_application['during_leave'] }}</td>
                              </tr>
                       
                              <tr>
                                <td>{{ __('Apply date') }}</td>
                                <td>{{ date("D d F Y h:ia", strtotime($leave_application['created_at'])) }}</td>
                              </tr>
                            </tbody>
                          </table>


                          <div class="signatur">
                            <strong class="signleft">{{ __('Signature of Applicant') }}</strong>
                          </div>
                    
                          <div class="oficsign"> 
                            <h4><strong>{{ __('For Office Use only') }}</strong></h4>
                          </div>
                         
                          <table class="table ">
                            <tbody>
                              <tr>
                                <td colspan="3"><strong>{{ __('ACTION ON APPLICATION') }}</strong></td>
                              </tr>
                    
                                <tr>
                                    <td>
                                        <div>
                                            <h4> {{ __('APPROVED FOR') }}</h4>
                                            <p> ...........{{ __('Days With Pay') }}</p>              
                                            <p> ...........{{ __('Days without pay') }}</p>              
                                            <p> ...........{{ __('others') }}</p>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="dueappr">
                                            <h4> {{ __('DISAPPROVED DUE TO') }} </h4>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="remark">
                                            <h4> {{ __('Remarks') }} </h4>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                          </table>
                          <div>
                            <strong>{{ __('Head of Department') }}</strong>
                          </div>
                    </div>
                </div>
            </div>
                    
        </section>

        <!-- /.content -->
    </div>
</body>
</html>