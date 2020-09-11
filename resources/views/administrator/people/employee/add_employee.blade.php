@extends('administrator.master')
@section('title', __('Add Employee'))

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           {{ __(' EMPLOYEE') }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i>{{ __('Dashboard') }} </a></li>
            <li><a href="{{ url('/people/employees') }}">{{ __('Employee') }}</a></li>
            <li class="active">{{ __('Add Employee') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Add Employee') }}</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <form action="{{ url('people/employees/store') }}" method="post" name="employee_add_form">
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
                            <p class="text-yellow">{{ __('Enter team member details. All (*)field are required. (Default password for added user is 12345678)') }}</p>
                            @endif
                        </div>
                        <!-- /.Notification Box -->

                        <div class="col-md-6">
                            <label for="employee_id">{{ __('Employee ID') }} <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('employee_id') ? ' has-error' : '' }} has-feedback">

                                {{-- <input type="hidden" value="{{count($deviceUsers)+1}}"> --}}
                                <input type="text" class="form-control" name="employee_id"  value="" >

                            </div>

                            <label for="att_device_id">{{ __('Attendance Device ID') }} <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('att_device_id') ? ' has-error' : '' }} has-feedback">
                                <select name="att_device_id" id="att_device_id" class="form-control">
                                    <option value="" selected>{{ __('Select one') }}</option>
                                    @foreach($devices as $d)
                                    <option value="{{$d->id}}">{{ $d->device_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('att_device_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('att_device_id') }}</strong>
                                </span>
                                @endif
                            </div>

                            {{-- <!-- /.form-group -->
                            <label for="office_id">{{ __('Official Employee Id') }} <span class="text-danger"></span></label>
                            <div class="form-group{{ $errors->has('office_id') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="office_id" id="office_id" class="form-control" value="{{ old('office_id') }}" placeholder="{{ __('Enter Official Employee ID..') }}">
                                @if ($errors->has('office_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('office_id') }}</strong>
                                </span>
                                @endif
                            </div> --}}

                            <label for="name">{{ __('Name') }} <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="{{ __('Enter name..') }}">
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="father_name">{{ __('Fathers Name') }}</label>
                            <div class="form-group{{ $errors->has('father_name') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="father_name" id="father_name" class="form-control" value="{{ old('father_name') }}" placeholder="{{ __('Enter fathers name..') }}">
                                @if ($errors->has('father_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('father_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="mother_name">{{ __('Mothers Name') }} </label>
                            <div class="form-group{{ $errors->has('mother_name') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="mother_name" id="mother_name" class="form-control" value="{{ old('mother_name') }}" placeholder="{{ __('Enter mothers name..') }}">
                                @if ($errors->has('mother_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="spouse_name">{{ __('Spouse Name') }} </label>
                            <div class="form-group{{ $errors->has('spouse_name') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="spouse_name" id="spouse_name" class="form-control" value="{{ old('spouse_name') }}" placeholder="{{ __('Enter spouse name..') }}">
                                @if ($errors->has('spouse_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('spouse_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="email">{{ __('Email') }} <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="{{ __('Enter email address..') }}" >
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="contact_no_one">{{ __('Contact No') }}<span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('contact_no_one') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="contact_no_one" id="contact_no_one" class="form-control" value="{{ old('contact_no_one') }}" placeholder="{{ __('Enter contact no..') }}">
                                @if ($errors->has('contact_no_one'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_no_one') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="emergency_contact">{{ __('Emergency Contact') }}</label>
                            <div class="form-group{{ $errors->has('emergency_contact') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="emergency_contact" id="emergency_contact" class="form-control" value="{{ old('emergency_contact') }}" placeholder="{{ __('Enter emergency contact no..') }}">
                                @if ($errors->has('emergency_contact'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('emergency_contact') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            {{-- <label for="web">{{ __('Web') }}</label>
                            <div class="form-group{{ $errors->has('web') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="web" id="web" class="form-control" value="{{ old('web') }}" placeholder="{{ __('Enter web..') }}">
                                @if ($errors->has('web'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('web') }}</strong>
                                </span>
                                @endif
                            </div> --}}
                            <!-- /.form-group -->

                            <label for="gender">{{ __('Gender') }} <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }} has-feedback">
                                <select name="gender" id="gender" class="form-control">
                                    <option value="" selected disabled>{{ __('Select one') }}</option>
                                    <option value="m">{{ __('Male') }}</option>
                                    <option value="f">{{ __('Female') }}</option>
                                </select>
                                @if ($errors->has('gender'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="datepicker4">{{ __('Joining Date') }}<span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('joining_date') ? ' has-error' : '' }} has-feedback">
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="joining_date" class="form-control pull-right" id="datepicker4" placeholder="{{ __('yyyy-mm-dd') }}">
                                </div>
                                @if ($errors->has('joining_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('joining_date') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->

                        <div class="col-md-6">
                            <label for="present_address">{{ __('Present Address') }}<span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('present_address') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="present_address" id="present_address" class="form-control" value="{{ old('present_address') }}" placeholder="{{ __('Enter present address..') }}">
                                @if ($errors->has('present_address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('present_address') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="permanent_address">{{ __('Permanent Address') }}</label>
                            <div class="form-group{{ $errors->has('permanent_address') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="permanent_address" id="permanent_address" class="form-control" value="{{ old('permanent_address') }}" placeholder="{{ __('Enter permanent address..') }}">
                                @if ($errors->has('permanent_address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('permanent_address') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <input type="hidden" name="home_district" value="None">

       
                            <!-- /.form-group -->

                            <label for="id_name">{{ __('ID Name') }}</label>
                            <div class="form-group{{ $errors->has('id_name') ? ' has-error' : '' }} has-feedback">
                                <select name="id_name" id="id_name" class="form-control">
                                    <option value="" selected disabled>{{ __('Select one') }}</option>
                                    <option value="1">{{ __('NID') }}</option>
                                    <option value="2">{{ __('Passport') }}</option>
                                    <option value="3">{{ __('Driving License') }}</option>
                                </select>
                                @if ($errors->has('id_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('id_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="id_number">{{ __('ID Number') }}</label>
                            <div class="form-group{{ $errors->has('id_number') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="id_number" id="id_number" class="form-control" value="{{ old('id_number') }}" placeholder="{{ __('Enter id number..') }}">
                                @if ($errors->has('id_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('id_number') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="designation_id">{{ __('Designation') }} <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('designation_id') ? ' has-error' : '' }} has-feedback">
                                <select name="designation_id" id="designation_id" class="form-control">
                                    <option value="" selected disabled>{{ __('Select one') }}</option>
                                    @foreach($designations as $designation)
                                    <option value="{{ $designation['id'] }}">{{ $designation['designation'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('designation_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('designation_id') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="department_id">{{ __('Department') }} <span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('department_id') ? ' has-error' : '' }} has-feedback">
                                <select name="department_id" id="department_id" class="form-control">
                                    <option value="" selected disabled>{{ __('Select one') }}</option>
                                    <?php $departments= \App\Department::all();?>
                                    @foreach($departments as $department)
                                    <option value="{{ $department['id'] }}">{{ $department['department'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('department_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('department_id') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                    <!-- /.form-group -->
                    {{-- <label for="joining_position">{{ __('Reference ') }}<span class="text-danger">*</span></label>
                    <div class="form-group{{ $errors->has('joining_position') ? ' has-error' : '' }} has-feedback">
                        <select name="reference" id="joining_position" class="form-control">
                            <option value="" selected disabled>{{ __('Select one') }}</option>
                             //$references = \App\User::where('access_label', 4)
                            //->where('deletion_status', 0)
                            //->select('id', 'name', 'present_address', 'contact_no_one', 'created_at', 'activation_status')
                            //->orderBy('id', 'DESC')
                            //->get()
                            //->toArray();?
                            @foreach($references as $reference)
                            <option value="{{ $reference['name'] }}">{{ $reference['name'] }}</option>
                            @endforeach
                        </select>
                        
                    </div> --}}
                    <!-- /.form-group -->

                            <label for="marital_status">{{ __('Marital Status') }} </label>
                            <div class="form-group{{ $errors->has('marital_status') ? ' has-error' : '' }} has-feedback">
                                <select name="marital_status" id="marital_status" class="form-control">
                                    <option value="" selected disabled>{{ __('Select one') }}</option>
                                    <option value="1">{{ __('Married') }}</option>
                                    <option value="2">{{ __('Single') }}</option>
                                    <option value="3">{{ __('Divorced') }}</option>
                                    <option value="4">{{ __('Separated') }}</option>
                                    <option value="5">{{ __('Widowed') }}</option>
                                </select>
                                @if ($errors->has('marital_status'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('marital_status') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->
                            <label for="datepicker">{{ __('Date of Birth') }}</label>
                            <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : '' }} has-feedback">
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="date_of_birth" class="form-control pull-right" value="{{ old('date_of_birth') }}" id="datepicker">
                                </div>
                                @if ($errors->has('date_of_birth'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('date_of_birth') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->
                            <label for="physical_ability">{{ __('Physical Ability') }}<span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('physical_ability') ? ' has-error' : '' }} has-feedback">
                                <select name="physical_ability" id="physical_ability" class="form-control">
                                    <option value="" selected>{{ __('Select Employee Ability') }}</option>
                                    <option value="able">{{ __('Able') }}</option>
                                    <option value="disable">{{ __('Disable') }}</option>
                                   
                                </select>
                                @if ($errors->has('physical_ability'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('physical_ability') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="employee_type">{{ __('Employee Type') }}<span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('employee_type') ? ' has-error' : '' }} has-feedback">
                                <select name="employee_type" id="employee_type" class="form-control">
                                    <option value="" selected>{{ __('Select Employee Type') }}</option>
                                    <option value="executive">{{ __('Executive') }}</option>
                                    <option value="stuff">{{ __('Stuff') }}</option>
                                    <option value="worker">{{ __('Worker') }}</option>
                                    
                                </select>
                                @if ($errors->has('employee_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('employee_type') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="role">{{ __('Role') }}<span class="text-danger">*</span></label>
                            <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }} has-feedback">
                                <select name="role" id="role" class="form-control">
                                    <option value="employee">{{ __('Employee') }}</option>
                                </select>
                                @if ($errors->has('role'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('role') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="height">{{ __('Height(in cm)') }}</label>
                            <div class="form-group{{ $errors->has('height') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="height" id="height" class="form-control" value="{{ old('height') }}" placeholder="{{ __('Enter height...') }}">
                                
                                @if ($errors->has('height'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('height') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="insurance">{{ __('Insurance') }}</label>
                            <div class="form-group{{ $errors->has('insurance') ? ' has-error' : '' }} has-feedback">
                                <select name="insurance" id="insurance" class="form-control">
                                    <option value="yes">{{ __('Yes') }}</option>
                                    <option value="no">{{ __('No') }}</option>
                                </select>
                                @if ($errors->has('insurance'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('insurance') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="weight">{{ __('Weight(in kg)') }}</label>
                            <div class="form-group{{ $errors->has('weight') ? ' has-error' : '' }} has-feedback">
                                <input type="text" name="weight" id="weight" class="form-control" value="{{ old('weight') }}" placeholder="{{ __('Enter Weight...') }}">
                                
                                @if ($errors->has('weight'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('weight') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-12">
                            <label for="academic_qualification">{{ __('Academic Qualification') }}</label>
                            <div class="form-group{{ $errors->has('academic_qualification') ? ' has-error' : '' }} has-feedback">
                                <textarea name="academic_qualification" id="academic_qualification" class="form-control textarea" placeholder="{{ __('Enter academic qualification..') }}">{{ old('academic_qualification') }}</textarea>
                                @if ($errors->has('academic_qualification'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('academic_qualification') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="professional_qualification">{{ __('Professional Qualification') }}</label>
                            <div class="form-group{{ $errors->has('professional_qualification') ? ' has-error' : '' }} has-feedback">
                                <textarea name="professional_qualification" id="professional_qualification" class="form-control textarea" placeholder="{{ __('Enter professional qualification..') }}">{{ old('professional_qualification') }}</textarea>
                                @if ($errors->has('professional_qualification'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('professional_qualification') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- /.form-group -->

                            <label for="experience">{{ __('Experience') }}</label>
                            <div class="form-group{{ $errors->has('experience') ? ' has-error' : '' }} has-feedback">
                                <textarea name="experience" id="experience" class="form-control textarea" placeholder="{{ __('Enter experience..') }}">{{ old('experience') }}</textarea>
                                @if ($errors->has('experience'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('experience') }}</strong>
                                </span>
                                @endif
                            </div>
                       
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ url('/people/employees') }}" class="btn btn-danger btn-flat"><i class="icon fa fa-close"></i>{{ __('Cancel') }} </a>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="icon fa fa-plus"></i> {{ __('Add') }}</button>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<script type="text/javascript">
    document.forms['employee_add_form'].elements['gender'].value = "{{ old('gender') }}";
        document.forms['employee_add_form'].elements['id_name'].value = "{{ old('id_name') }}";
    document.forms['employee_add_form'].elements['designation_id'].value = "{{ old('designation_id') }}";
    document.forms['employee_add_form'].elements['role'].value = "{{ old('role') }}";
    document.forms['employee_add_form'].elements['joining_position'].value = "{{ old('joining_position') }}";
    document.forms['employee_add_form'].elements['marital_status'].value = "{{ old('marital_status') }}";
</script>
@endsection
