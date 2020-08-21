@extends('administrator.master')
@section('title', __('Edit Device'))

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          {{ __('Edit Device') }} 
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i>{{ __(' Dashboard') }} </a></li>
            <li><a href="{{ url('/hrm/device/manage') }}">{{ __(' Manage Devices') }}</a></li>
            <li class="active">{{ __(' Edit Device') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- SELECT2 EXAMPLE -->
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ __(' Edit Device') }}</h3>
        
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->           
                    <form action="{{ url('/device/update') }}" method="post" name="device_update_form">
                        {{ csrf_field() }}

                        <div class="box-body">
                            <div class="row">
                                <!-- Notification Box -->
                                <div class="col-md-12">
                                    <p class="text-yellow">{{ __('Enter Device details. All fields are required. ') }}</p>
                                </div>
                                <!-- /.Notification Box -->
                                <div class="col-md-6">

                                    <label for="device_ip_hidden">{{ __('Device Public Ip') }} <span class="text-danger">*</span></label>
                                    <div class="form-group{{ $errors->has('device_ip_hidden') ? ' has-error' : '' }} has-feedback">
                                        <input type="text" name="device_ip_hidden" id="device_ip_hidden" class="form-control" value="{{ $device['device_ip_hidden'] }}" placeholder="{{ __('Enter device public IP..') }}">
                                        @if ($errors->has('device_ip_hidden'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('device_ip_hidden') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <!-- /.form-group -->

                                    <label for="device_port_public_h">{{ __('Device Public Port') }} <span class="text-danger">*</span></label>
                                    <div class="form-group{{ $errors->has('device_port_public_h') ? ' has-error' : '' }} has-feedback">
                                        <input type="text" name="device_port_public_h" id="device_port_public_h" class="form-control" value="{{ $device['device_port_public_h']}}" placeholder="{{ __('Enter device public port..') }}">
                                        @if ($errors->has('device_port_public_h'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('device_port_public_h') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <!-- /.form-group -->

                                
                                    <label for="device_ip_internal">{{ __('Device Internal Ip') }} <span class="text-danger">*</span></label>
                                    <div class="form-group{{ $errors->has('device_ip_internal') ? ' has-error' : '' }} has-feedback">
                                        <input type="text" name="device_ip_internal" id="device_ip_internal" class="form-control" value="{{ $device['device_ip_internal'] }}" placeholder="{{ __('Enter device internal IP..') }}">
                                        @if ($errors->has('device_ip_internal'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('device_ip_internal') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <!-- /.form-group -->
        
                                    <label for="device_name">{{ __('Device Name') }} <span class="text-danger">*</span></label>
                                    <div class="form-group{{ $errors->has('device_name') ? ' has-error' : '' }} has-feedback">
                                        <input type="text" name="device_name" id="device_name" class="form-control" value="{{ $device['device_name'] }}"placeholder="{{ __('Enter device name..') }}">
                                        @if ($errors->has('device_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('device_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <!-- /.form-group -->
        
                                    <label for="serial_number">{{ __('Device Serial Number') }} <span class="text-danger">*</span></label>
                                    <div class="form-group{{ $errors->has('serial_number') ? ' has-error' : '' }} has-feedback">
                                        <input type="text" name="serial_number" id="serial_number" class="form-control" value="{{ $device['serial_number'] }}" disabled>
                                        @if ($errors->has('serial_number'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('serial_number') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <!-- /.form-group -->
        
                                    <label for="device_version">{{ __('Device Version Number') }} <span class="text-danger">*</span></label>
                                    <div class="form-group{{ $errors->has('device_version') ? ' has-error' : '' }} has-feedback">
                                        <input type="text" name="device_version" id="device_version" class="form-control" value="{{ $device['device_version']}}" disabled>
                                        @if ($errors->has('device_version'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('device_version') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <!-- /.form-group -->
                                    
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{ url('/device/manage') }}" class="btn btn-danger btn-flat"><i class="icon fa fa-close"></i>{{ __('Cancel') }} </a>
                            <button type="submit" class="btn btn-primary btn-flat"><i class="icon fa fa-plus"></i> {{ __('Update Device') }}</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            
        </div>


    </section>
    <!-- /.content -->
</div>

<script>
    $(document).ready( function() { // Wait until document is fully parsed
        $("#device_get_form").on('submit', function(e){
            e.preventDefault();
        });
        
        //On Click Submit button
        $("#get_device_btn").on('click', function(e){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content'); 
            var device_ip = $('#device_ip').val();
            var device_port_public = $('#device_port_public').val();
            //Get info
            $.ajax({
                url: '/device/info/go',
                contentType: "application/json",
                type: 'POST',
                dataType: 'json',
                data: JSON.stringify({
                    _token: CSRF_TOKEN,
                    device_ip: device_ip,
                    device_port_public: device_port_public
                }),
                success: function(res){
                    console.log(res);
                    $('#device_ip').val(res.device_ip);
                    $('#device_ip_hidden').val(res.device_ip);
                    $('#device_port_public_h').val(res.device_port_public);
                    $('#device_name').val(res.device_name);
                    $('#serial_number').val(res.serial_number);
                    $('#device_version').val(res.device_version);
                },
                error: function(e){
                    console.log(e);
                }

            });
        });

    })
</script>
@endsection
