@extends('administrator.master')
@section('title', __('Add Device'))

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          {{ __('  Device') }} 
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i>{{ __(' Dashboard') }} </a></li>
            <li><a href="{{ url('/hrm/device/manage') }}">{{ __(' Manage Devices') }}</a></li>
            <li class="active">{{ __(' Add Device') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">{{ __('Device Information') }}</h3>
          
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
                      <!-- /.Notification Box /device/create -->
                      <div class="col-md-12">
                        <form class="form-horizontal" name="device_get_form" id="device_get_form" >
                          {{ csrf_field() }}
          
                          <div class="form-group{{ $errors->has('device_ip') ? ' has-error' : '' }}">
                            <label for="device_ip" class="col-sm-3 control-label">{{ __('Device Public Ip Address') }}<span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                              <div class="form-group{{ $errors->has('device_ip') ? ' has-error' : '' }} has-feedback">
                                  <input type="text" name="device_ip" id="device_ip" class="form-control" value="{{ old('device_ip') }}" placeholder="{{ __('Enter device IP address..') }}">
                                  @if ($errors->has('device_ip'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('device_ip') }}</strong>
                                  </span>
                                  @endif
                                </div>
                            </div>
                          </div>
                          <div class="form-group{{ $errors->has('device_port_public') ? ' has-error' : '' }}">
                            <label for="device_port_public" class="col-sm-3 control-label">{{ __('Device Public port') }}<span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                              <div class="form-group{{ $errors->has('device_port_public') ? ' has-error' : '' }} has-feedback">
                                  <input type="text" name="device_port_public" id="device_port_public" class="form-control" value="{{ old('device_port_public') }}" placeholder="{{ __('Enter device port number..') }}">
                                  @if ($errors->has('device_port_public'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('device_port_public') }}</strong>
                                  </span>
                                  @endif
                                </div>
                            </div>
                          </div>
                          
                            <div class="form-group{{ $errors->has('device_ip') ? ' has-error' : '' }}">
                            <div class="form-group{{ $errors->has('device_port_public') ? ' has-error' : '' }}">
                            <div class=" col-sm-offset-3 col-sm-6">
                              <button type="submit" class="btn btn-info btn-flat" id="get_device_btn" ><i class="icon fa fa-arrow-right"></i> {{ __('Get Info') }}</button>
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
            </div>
       
            <!-- SELECT2 EXAMPLE -->
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ __(' Add Device') }}</h3>
        
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->           
                    <form action="{{ url('/device/create') }}" method="post" name="device_add_form">
                        {{ csrf_field() }}
                        <input type="hidden" name="device_ip_hidden" id="device_ip_hidden" value="" >
                        <input type="hidden" name="device_port_public_h" id="device_port_public_h" value="" >

                        <div class="box-body">
                            <div class="row">
                                <!-- Notification Box -->
                                <div class="col-md-12">
                                    <p class="text-yellow">{{ __('Enter Device details. All fields are required. ') }}</p>
                                </div>
                                <!-- /.Notification Box -->
                                <div class="col-md-6">
                                    <label for="device_ip_internal">{{ __('Device Internal Ip') }} <span class="text-danger">*</span></label>
                                    <div class="form-group{{ $errors->has('device_ip_internal') ? ' has-error' : '' }} has-feedback">
                                        <input type="text" name="device_ip_internal" id="device_ip_internal" class="form-control" value="{{ old('device_ip_internal') }}" placeholder="{{ __('Enter device internal IP..') }}">
                                        @if ($errors->has('device_ip_internal'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('device_ip_internal') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <!-- /.form-group -->
        
                                    <label for="device_name">{{ __('Device Name') }} <span class="text-danger">*</span></label>
                                    <div class="form-group{{ $errors->has('device_name') ? ' has-error' : '' }} has-feedback">
                                        <input type="text" name="device_name" id="device_name" class="form-control" value="{{ old('device_name') }}" placeholder="{{ __('Enter device name..') }}">
                                        @if ($errors->has('device_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('device_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <!-- /.form-group -->
        
                                    <label for="serial_number">{{ __('Device Serial Number') }} <span class="text-danger">*</span></label>
                                    <div class="form-group{{ $errors->has('serial_number') ? ' has-error' : '' }} has-feedback">
                                        <input type="text" name="serial_number" id="serial_number" class="form-control" value="{{ old('serial_number') }}" placeholder="{{ __('Enter device serial number..') }}">
                                        @if ($errors->has('serial_number'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('serial_number') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <!-- /.form-group -->
        
                                    <label for="device_version">{{ __('Device Version Number') }} <span class="text-danger">*</span></label>
                                    <div class="form-group{{ $errors->has('device_version') ? ' has-error' : '' }} has-feedback">
                                        <input type="text" name="device_version" id="device_version" class="form-control" value="{{ old('device_version') }}" placeholder="{{ __('Enter device version number..') }}">
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
                            <button type="submit" class="btn btn-primary btn-flat"><i class="icon fa fa-plus"></i> {{ __('Add Device') }}</button>
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
