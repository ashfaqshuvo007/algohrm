@extends('administrator.master')
@section('title', __('Manage Salary'))

@section('main_content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
     {{ __('PAYROLL') }} 
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i>{{ __('Dashboard') }} </a></li>
      <li><a>{{ __('Payroll') }}</a></li>
      <li class="active">{{ __('Manage Salary') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <!-- Default box -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">{{ __('Manage Salary') }}</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
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
            <div class="col-md-12">
              <form class="form-horizontal" name="employee_select_form" action="{{ url('/hrm/payroll/go') }}" method="post">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                  <label for="user_id" class="col-sm-3 control-label">{{ __('Employee Name') }}</label>
                  <div class="col-sm-6">
                    <select name="user_id" class="form-control" id="user_id">
                      <option selected disabled>{{ __('Select One') }}</option>
                      @foreach($employees as $employee)
                      <option value="{{ $employee['id'] }}">{{ $employee['name'] }}</option>
                      @endforeach
                    </select>
                    @if ($errors->has('user_id'))
                    <span class="help-block">
                      <strong>{{ $errors->first('user_id') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
                <div class="form-group{{ $errors->has('basic_salary') ? ' has-error' : '' }}">
                  <div class=" col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-info btn-flat"><i class="icon fa fa-arrow-right"></i> {{ __('Go') }}</button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /. end col -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer clearfix"></div>
          <!-- /.box-footer -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.end.col -->

      <form name="employee_salary_form" id="employee_salary_form" action="{{ url('/hrm/payroll/store') }}" method="post">
        {{ csrf_field() }}

        <input type="hidden" name="user_id" value="{{ $employee_id }}">

        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('Salary Details') }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="form-horizontal">
              <div class="box-body">
                <div class="form-group{{ $errors->has('employee_type') ? ' has-error' : '' }}">
                  <label for="employee_type" class="col-sm-3 control-label">{{ __('Employee Type') }}</label>
                  <div class="col-sm-6">
                    <select name="employee_type" class="form-control" id="employee_type">
                      <option selected disabled>{{ __('Select One') }}</option>
                      <option value="1">{{ __('Provision') }}</option>
                      <option value="2">{{ __('Permanent') }}</option>
                      <option value="3">{{ __('Full Time') }}</option>
                      <option value="4">{{ __('Part Time') }}</option>
                      <option value="5">{{ __('Adhoc') }}</option>
                    </select>
                    @if ($errors->has('employee_type'))
                    <span class="help-block">
                      <strong>{{ $errors->first('employee_type') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
                <div class="form-group{{ $errors->has('basic_salary') ? ' has-error' : '' }}">
                  <label for="basic_salary" class="col-sm-3 control-label">{{ __('Basic Salary') }}</label>
                  <div class="col-sm-6">
                    {{-- <input type="number" name="basic_salary" class="form-control" id="basic_salary" value="{{ old('basic_salary') }}" placeholder="{{ __('Enter basic salary..') }}"> --}}
                    <input type="number" name="basic_salary" class="form-control" id="basic_salary" value="{{ $employees[0]['basic_salary'] }}" placeholder="{{ __('Enter basic salary..') }}">
                    @if ($errors->has('basic_salary'))
                    <span class="help-block">
                      <strong>{{ $errors->first('basic_salary') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
          </div>
        </div>
        <!-- /.end.col -->
        <div class="col-md-6">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('Allowances') }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group{{ $errors->has('house_rent') ? ' has-error' : '' }}">
                <label for="house_rent">{{ __('House Rent Allowance') }}</label>
                {{-- <input type="number" name="house_rent_allowance" value="{{ old('house_rent_allowance') }}" class="form-control" id="house_rent_allowance" placeholder="{{ __('Enter house rent allowance..') }}"> --}}
                <input type="number" name="house_rent" value="{{ $employees[0]['house_rent']}}" class="form-control" id="house_rent" placeholder="{{ __('Enter house rent allowance..') }}">
                @if ($errors->has('house_rent'))
                <span class="help-block">
                  <strong>{{ $errors->first('house_rent') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('medical_allowance') ? ' has-error' : '' }}">
                <label for="medical_allowance">{{ __('Medical Allowance') }}</label>
                {{-- <input type="number" name="medical_allowance" value="{{ old('medical_allowance') }}" class="form-control" id="medical_allowance" placeholder="{{ __('Enter medical allowance..') }}"> --}}
                <input type="number" name="medical_allowance" value="{{ $employees[0]['medical_allowance']}}" class="form-control" id="medical_allowance" placeholder="{{ __('Enter medical allowance..') }}">
                @if ($errors->has('medical_allowance'))
                <span class="help-block">
                  <strong>{{ $errors->first('medical_allowance') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('convayence') ? ' has-error' : '' }}">
                <label for="convayence">{{ __('Convayence') }}</label>
                {{-- <input type="number" name="special_allowance" value="{{ old('special_allowance') }}" class="form-control" id="convayence" placeholder="{{ __('Enter special allowance..') }}"> --}}
                <input type="number" name="convayence" value="{{ $employees[0]['convayence'] }}" class="form-control" id="convayence" placeholder="{{ __('Enter travel allowance..') }}">
                @if ($errors->has('convayence'))
                <span class="help-block">
                  <strong>{{ $errors->first('convayence') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('food_allowance') ? ' has-error' : '' }}">
                <label for="food_allowance">{{ __('Food Allowance') }}</label>
                {{-- <input type="number" name="provident_fund_contribution" value="{{ old('provident_fund_contribution') }}" class="form-control" id="provident_fund_contribution" placeholder="{{ __('Enter provident fund contribution..') }}"> --}}
                <input type="number" name="food_allowance" value="{{ $employees[0]['food_allowance']  }}" class="form-control" id="food_allowance" placeholder="{{ __('Enter food allowance..') }}">
                @if ($errors->has('food_allowance'))
                <span class="help-block">
                  <strong>{{ $errors->first('food_allowance') }}</strong>
                </span>
                @endif
              </div>
              {{-- <div class="form-group{{ $errors->has('other_allowance') ? ' has-error' : '' }}">
                <label for="other_allowance">{{ __('Other Allowance') }}</label>
                <input type="number" name="other_allowance" value="{{ old('other_allowance') }}" class="form-control" id="other_allowance" placeholder="{{ __('Enter other allowance..') }}">
                @if ($errors->has('other_allowance'))
                <span class="help-block">
                  <strong>{{ $errors->first('other_allowance') }}</strong>
                </span>
                @endif
              </div> --}}
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.end.col -->
        <div class="col-md-6"> 
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('Deductions') }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {{-- <div class="form-group{{ $errors->has('tax_deduction') ? ' has-error' : '' }}">
                <label for="tax_deduction">{{ __('Tax Deduction') }}</label>
                <input type="number" name="tax_deduction" value="{{ old('tax_deduction') }}" class="form-control" id="tax_deduction" placeholder="{{ __('Enter tax deduction..') }}">
                @if ($errors->has('tax_deduction'))
                <span class="help-block">
                  <strong>{{ $errors->first('tax_deduction') }}</strong>
                </span>
                @endif
              </div> --}}
              <div class="form-group{{ $errors->has('absent_deduction') ? ' has-error' : '' }}">
                <label for="absent_deduction">{{ __('Absent Deduction amount') }}</label>
                <input type="number" name="absent_deduction" value="{{ old('absent_deduction') }}" class="form-control" id="absent_deduction" placeholder="{{ __('Enter deduction amount in absence') }}">
                @if ($errors->has('absent_deduction'))
                <span class="help-block">
                  <strong>{{ $errors->first('absent_deduction') }}</strong>
                </span>
                @endif
              </div>
              {{-- <div class="form-group{{ $errors->has('other_deduction') ? ' has-error' : '' }}">
                <label for="other_deduction">{{ __('Other Deduction') }}</label>
                <input type="number" name="other_deduction" value="{{ old('other_deduction') }}" class="form-control" id="other_deduction" placeholder="{{ __('Enter other deduction..') }}">
                @if ($errors->has('other_deduction'))
                <span class="help-block">
                  <strong>{{ $errors->first('other_deduction') }}</strong>
                </span>
                @endif
              </div> --}}
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.end.col -->

        <div class="col-md-6">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('Aditional Amount Details') }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {{-- <div class="form-group{{ $errors->has('overtime_hours') ? ' has-error' : '' }}">
                <label for="overtime_hours">{{ __('Overtime Hours ') }}</label>
                <input type="number" name="overtime_hours" value="{{ old('overtime_hours')}}" class="form-control" id="overtime_hours" placeholder="{{ __('Enter Overtime Hours') }}">
                @if ($errors->has('overtime_hours'))
                <span class="help-block">
                  <strong>{{ $errors->first('overtime_hours') }}</strong>
                </span>
                @endif
              </div> --}}
              <div class="form-group{{ $errors->has('increment_amount') ? ' has-error' : '' }}">
                <label for="increment_amount">{{ __('Increment Amount') }}</label>
                <input type="number" name="increment_amount" value="{{ old('increment_amount') }}" class="form-control" id="increment_amount" placeholder="{{ __('Enter Increment Amount when due..') }}">
                @if ($errors->has('increment_amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('increment_amount') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group{{ $errors->has('overtime_rate') ? ' has-error' : '' }}">
                <label for="overtime_rate">{{ __('Overtime Rate') }}</label>
                <input type="number" name="overtime_rate" value="{{ old('overtime_rate') }}" class="form-control" id="overtime_rate" placeholder="{{ __('Enter Overtime Rate..') }}">
                @if ($errors->has('overtime_rate'))
                <span class="help-block">
                  <strong>{{ $errors->first('overtime_rate') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('att_bonus') ? ' has-error' : '' }}">
                <label for="att_bonus">{{ __('Attendance Bonus amount') }}</label>
                <input type="number" name="att_bonus" value="{{ $salary['att_bonus'] }}" class="form-control" id="att_bonus" placeholder="{{ __('Enter amount for 100% attendance ..') }}">
                @if ($errors->has('att_bonus'))
                <span class="help-block">
                  <strong>{{ $errors->first('att_bonus') }}</strong>
                </span>
                @endif
              </div>

              {{-- <div class="form-group{{ $errors->has('overtime_taka') ? ' has-error' : '' }}">
                <label for="overtime_taka">{{ __('Overtime Toatal Amount (BDT)') }}</label>
                <input type="number" name="overtime_taka" value="{{ old('overtime_taka') }}" class="form-control" id="overtime_taka" placeholder="{{ __('Enter Overtime Amount in tk..') }}" readonly>
                @if ($errors->has('overtime_taka'))
                <span class="help-block">
                  <strong>{{ $errors->first('overtime_taka') }}</strong>
                </span>
                @endif
              </div> --}}
          </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.end.col -->
        

        {{-- <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('Total Salary Details') }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <label for="gross_salary">{{ __('Gross Salary') }}</label>
                <input type="number" disabled class="form-control" id="gross_salary">
              </div>
              <div class="form-group{{ $errors->has('total_deduction') ? ' has-error' : '' }}">
                <label for="total_deduction">{{ __('Total Deduction') }}</label>
                <input type="number" disabled class="form-control" id="total_deduction">
              </div>
              <div class="form-group">
                <label for="net_salary">{{ __('Net Salary') }}</label>
                <input type="number" disabled class="form-control" id="net_salary">
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-flat pull-right"><i class="fa fa-save"></i> {{ __('Save Details') }}</button>
            </div>
          </div>
        </div> --}}
        <!-- /.end.col -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary btn-flat pull-right"><i class="fa fa-save"></i> {{ __('Save Details') }}</button>
        </div>
      </form>

    </div>
  </section>
  <!-- /.content -->
</div>
<script type="text/javascript">
  // For Kepp Data After Reload
  document.forms['employee_select_form'].elements['user_id'].value = "{{ $employee_id }}";

  @if(!empty(old('employee_type')))
  document.forms['employee_salary_form'].elements['employee_type'].value = "{{ old('employee_type') }}";
  @endif

  $(document).ready(function(){
    calculation();
  });


  //For Calculation
  $(document).on("keyup", "#employee_salary_form", function() {
    calculation();
  });

  function calculation() {
    var sum = 0;
    var basic_salary = $("#basic_salary").val();
    // var house_rent_allowance = $("#house_rent_allowance").val();
    var house_rent = $("#house_rent").val();

    // var medical_allowance = $("#medical_allowance").val();
    var medical_allowance = $("#medical_allowance").val();
    
    // var special_allowance = $("#special_allowance").val();
    var food_allowance = $("#food_allowance").val();

    var conveyance = $("#convayence").val();

    var overtime_hours = $("#overtime_hours").val();
    var overtime_rate = $("#overtime_rate").val();

    // var provident_fund_contribution = $("#provident_fund_contribution").val();
    // var other_allowance = $("#other_allowance").val();
    // var tax_deduction = $("#tax_deduction").val();
    // var provident_fund_deduction = $("#provident_fund_deduction").val();
    // var other_deduction = $("#other_deduction").val();

    // var gross_salary = (+basic_salary + +house_rent_allowance + +medical_allowance + +special_allowance + +other_allowance);
    var gross_salary = (+basic_salary + +house_rent + +medical_allowance + +food_allowance + +conveyance);

    // var total_deduction = (+tax_deduction + +provident_fund_deduction + +other_deduction);

    // $("#total_provident_fund").val(+provident_fund_contribution + +provident_fund_deduction);

    var overtime_taka = (overtime_hours * overtime_rate);

    $("#gross_salary").val(gross_salary);
    $("#overtime_taka").val(overtime_taka);
    $("#total_deduction").val(total_deduction);
    // $("#net_salary").val(+gross_salary - +total_deduction);
  }
</script>
@endsection