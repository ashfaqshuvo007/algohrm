<?php
use Carbon\Carbon;
?>
@extends('administrator.master')
@section('title', __( 'Show Leave Application'))

@section('main_content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header no-printme">
    <h1>
     {{ __('Show Leave Application') }} 
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i>{{ __('Dashboard') }} </a></li>
      <li><a>{{ __('Leave') }}</a></li>
      <li><a href="{{ url('/hrm/leave_application') }}">{{ __('Manage Leave Application') }}</a></li>
      <li class="active">{{ __('Details') }}</li>
    </ol>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border no-printme">
      <h3 class="box-title"> {{ __('Leave Application') }}</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
      <a href="{{ url('/hrm/leave_application') }}" class="btn btn-primary btn-flat no-printme"><i class="fa fa-arrow-left"></i>{{ __('Back') }} </a>
      <a href="{{ url('/hrm/leave_application/print/'.$leave_application['id']) }}" class="btn btn-default btn-flat pull-right no-printme"><i class="fa fa-print"></i>{{ __('Print') }} </a>
      <hr>
      
      <div id="printable_area printme" class="table-responsive">
        <div class="text-center">
          <h4><strong>{{ __('APPLICATION FOR LEAVE') }}</strong></h4>
        </div>
      <table  class="table table-bordered table-striped">
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
              @php($leave_days = Carbon::parse($leave_application['start_date'])->diffInDays(Carbon::parse($leave_application['end_date']))+1)
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
     
      <table class="table table-bordered table-striped">

        <tbody>
        
          <tr>
            <td colspan="3"><strong>{{ __('ACTION ON APPLICATION') }}</strong></td>
            
          </tr>

          <tr>
            <td>
              <div>
              <h4> {{ __('APPROVED FOR') }}</h4>
              <p>...........{{ __('Days With Pay') }}</p>              
              <p>...........{{ __('Days without pay') }}</p>              
              <p>...........{{ __('others') }}</p>
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
      <br>
      <hr>
      <div>
        <strong>{{ __('Head of Department') }}</strong>
      </div>
    </div><!--pintable-->
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
</section>
<!-- /.content -->
</div>
@endsection
<script type="text/javascript">
  function printmyDiv(id){
       
    var is_chrome = function () { return Boolean(window.chrome); }
        if(is_chrome) {
            var printContents = document.getElementById(id).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            setTimeout(function(){window.close();}, 10000); 
            //give them 10 seconds to print, then close
        }else{
            var printContents = document.getElementById(id).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            window.close();
        }
}
</script>
