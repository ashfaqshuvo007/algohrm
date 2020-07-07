@extends('administrator.master')
@section('title', __('Add Employee Grade'))

@section('main_content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{ __('Add Employee Grade') }}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a></li>
      <li><a>{{ __('Setting') }}</a></li>
      <li><a href="{{ url('/setting/award_categories') }}">{{ __('Employee Grade Lists') }}</a></li>
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
        {{ csrf_field() }}
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


              <label for="min_overtime_hrs">{{ __('Min. Overtime Hours') }} <span class="text-danger">*</span></label>
              <div class="form-group{{ $errors->has('min_overtime_hrs') ? ' has-error' : '' }} has-feedback">
                <input type="text" name="min_overtime_hrs" id="min_overtime_hrs" class="form-control" value="{{ old('min_overtime_hrs') }}" placeholder="{{ __('Enter Min. Overtime Hours') }}">
                @if ($errors->has('min_overtime_hrs'))
                <span class="help-block">
                  <strong>{{ $errors->first('min_overtime_hrs') }}</strong>
                </span>      
                @endif
              </div>
              <!-- /.form-group -->




              <label for="min_overtime_hrs">{{ __('Overtime Rate') }} <span class="text-danger">*</span></label>
              <div class="form-group{{ $errors->has('overtime_rate') ? ' has-error' : '' }} has-feedback">
                <input type="text" name="overtime_rate" id="overtime_rate" class="form-control" value="{{ old('overtime_rate') }}" placeholder="{{ __('Enter Overtime Rate') }}">
                @if ($errors->has('overtime_rate'))
                <span class="help-block">
                  <strong>{{ $errors->first('overtime_rate') }}</strong>
                </span>      
                @endif
              </div>
              <!-- /.form-group -->



              <label for="publication_status">{{ __('Publication Status') }} <span class="text-danger">*</span></label>
              <div class="form-group{{ $errors->has('publication_status') ? ' has-error' : '' }} has-feedback">
                <select name="publication_status" id="publication_status" class="form-control">
                  <option value="" selected disabled>{{ __('Select one') }}</option>
                  <option value="1">{{ __('Published') }}</option>
                  <option value="0">{{ __('Unpublished') }}</option>
                </select>
                @if ($errors->has('publication_status'))
                <span class="help-block">
                  <strong>{{ $errors->first('publication_status') }}</strong>
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
          <a href="{{ url('/setting/award_categories') }}" class="btn btn-danger btn-flat"><i class="icon fa fa-close"></i> {{ __('Cancel') }}</a>
          <button type="submit" class="btn btn-primary btn-flat"><i class="icon fa fa-plus"></i> {{ __('Add award List') }}</button>
        </div>
      </form>
    </div>
    <!-- /.box -->


  </section>
  <!-- /.content -->
</div>
<script type="text/javascript">
document.forms['award_add_form'].elements['publication_status'].value = "{{ old('publication_status') }}";
</script>
@endsection
