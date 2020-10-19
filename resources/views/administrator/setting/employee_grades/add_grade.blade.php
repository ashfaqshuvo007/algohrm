@extends('administrator.master')
@section('title', __('Add Employee Grade'))

@section('main_content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{ __('Employee Grades') }}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a></li>
      <li><a>{{ __('Setting') }}</a></li>
      <li><a href="{{ url('/setting/employee_grades') }}">{{ __('Employee Grade Lists') }}</a></li>
      <li class="active">{{ __('Add Employee Grade') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">{{ __('Add Employee Grade') }}</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <form action="{{ url('/setting/employee_grades/store') }}" method="post" name="grade_add_form">
        {{-- {{ csrf_field() }} --}}
        @csrf
        <div class="box-body">
          <div class="row">
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
              @else
              <p class="text-yellow">{{ __('Enter Employee Grades. All field are required.') }} </p>
              @endif
            </div>
            <!-- /.Notification Box -->

            <div class="col-md-6">
              <label for="grade">{{ __('Grade') }} <span class="text-danger">*</span></label>
              <div class="form-group{{ $errors->has('grade') ? ' has-error' : '' }} has-feedback">
                <input type="text" name="grade" id="grade" class="form-control" value="{{ old('grade') }}" placeholder="{{ __('Enter Grade') }}">
                @if ($errors->has('grade'))
                <span class="help-block">
                  <strong>{{ $errors->first('grade') }}</strong>
                </span>
                @endif
              </div>
              <!-- /.form-group -->

              <label for="basic_salary">{{ __('Basic Salary') }} <span class="text-danger">*</span></label>
              <div class="form-group{{ $errors->has('basic_salary') ? ' has-error' : '' }} has-feedback">
                <input type="text" name="basic_salary" id="basic_salary" class="form-control" value="{{ old('basic_salary') }}" placeholder="{{ __('Enter Basic Salary') }}">
                @if ($errors->has('basic_salary'))
                <span class="help-block">
                  <strong>{{ $errors->first('basic_salary') }}</strong>
                </span>      
                @endif
              </div>
              <!-- /.form-group -->


              <label for="yearly_increment_rate">{{ __('Yearly Increment Rate (in %)') }} <span class="text-danger">*</span></label>
              <div class="form-group{{ $errors->has('yearly_increment_rate') ? ' has-error' : '' }} has-feedback">
                <input type="text" name="yearly_increment_rate" id="yearly_increment_rate" class="form-control" value="{{ old('yearly_increment_rate') }}" placeholder="{{ __('Enter Yearly Increment Rate') }}">
                @if ($errors->has('yearly_increment_rate'))
                <span class="help-block">
                  <strong>{{ $errors->first('yearly_increment_rate') }}</strong>
                </span>      
                @endif
              </div>
              <!-- /.form-group -->

              <label for="house_rent">{{ __('House Rent (50% of basic salary)') }} <span class="text-danger">*</span></label>
              <div class="form-group{{ $errors->has('house_rent') ? ' has-error' : '' }} has-feedback">
                <input type="text" name="house_rent" id="house_rent" class="form-control" readonly>
                @if ($errors->has('house_rent'))
                <span class="help-block">
                  <strong>{{ $errors->first('house_rent') }}</strong>
                </span>      
                @endif
              </div>
              <!-- /.form-group -->

              <label for="medical_allowance">{{ __('Medical Allowance') }} <span class="text-danger">*</span></label>
              <div class="form-group{{ $errors->has('medical_allowance') ? ' has-error' : '' }} has-feedback">
                <input type="text" name="medical_allowance" id="medical_allowance" class="form-control" value="{{ old('medical_allowance') }}" placeholder="{{ __('Medical Allowance') }}">
                @if ($errors->has('medical_allowance'))
                <span class="help-block">
                  <strong>{{ $errors->first('medical_allowance') }}</strong>
                </span>      
                @endif
              </div>
              <!-- /.form-group -->


               <label for="conveyence">{{ __('Conveyence') }} <span class="text-danger">*</span></label>
              <div class="form-group{{ $errors->has('conveyence') ? ' has-error' : '' }} has-feedback">
                <input type="text" name="conveyence" id="conveyence" class="form-control" value="{{ old('conveyence') }}" placeholder="{{ __('Enter Conveyence') }}">
                @if ($errors->has('conveyence'))
                <span class="help-block">
                  <strong>{{ $errors->first('conveyence') }}</strong>
                </span>      
                @endif
              </div>
              <!-- /.form-group -->

               <label for="food_allowance">{{ __('Food Allowance') }} <span class="text-danger">*</span></label>
              <div class="form-group{{ $errors->has('food_allowance') ? ' has-error' : '' }} has-feedback">
                <input type="text" name="food_allowance" id="food_allowance" class="form-control" value="{{ old('food_allowance') }}" placeholder="{{ __('Enter Food Allowance') }}">
                @if ($errors->has('food_allowance'))
                <span class="help-block">
                  <strong>{{ $errors->first('food_allowance') }}</strong>
                </span>      
                @endif
              </div>
              <!-- /.form-group -->

            </div>
            <!-- /.col -->

            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{ url('/setting/employee_grades') }}" class="btn btn-danger btn-flat"><i class="icon fa fa-close"></i> {{ __('Cancel') }}</a>
          <button type="submit" class="btn btn-primary btn-flat"><i class="icon fa fa-plus"></i> {{ __('Add Employee Grade') }}</button>
        </div>
      </form>
    </div>
    <!-- /.box -->


  </section>
  <!-- /.content -->
</div>
<script>
   $(document).ready(function(){
    calculation();
  });

  //For Calculation
  $(document).on("keyup", "#basic_salary", function() {
    calculation();
  });

  function calculation() {
    var basic_salary = $("#basic_salary").val();

    var house_rent = basic_salary * 0.4;
    // console.log();
    $("#house_rent").val(house_rent.toFixed(2));
  }


</script>

@endsection
