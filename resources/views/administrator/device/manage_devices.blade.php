@extends('administrator.master')
@section('title', __('Devices'))

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ __('Devices') }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a></li>
            <li><a>{{ __('Devices') }}</a></li>
            <li class="active">{{ __('Devices') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Manage Devices') }}</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div  class="col-md-3">
                <a href="{{ url('/device/add') }}" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i>{{ __(' Add Device') }} </a>
            </div>
            <div  class="col-md-3">
              <button type="button" class="tip btn btn-primary btn-flat" title="Print" data-original-title="Label Printer" onclick="printDiv('printable_area')">
                    <i class="fa fa-print"></i>
                    <span class="hidden-sm hidden-xs"> {{ __('Print') }}</span>
                </button>
            </div>
                
                <div  class="col-md-6">
                    <input type="text" id="myInput" class="form-control" placeholder="{{ __('Search..') }}">
                </div>

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
        <div id="printable_area" class="col-md-12 table-responsive">
               <table  class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{{ __(' SL#') }}</th>
                            <th>{{ __(' ID') }}</th>
                            <th>{{ __(' Device Name') }}</th>
                            <th>{{ __(' Device Serial Number') }}</th>
                            <th>{{ __(' Device Version') }}</th>
                            <th>{{ __(' Public IP Address') }}</th>
                            <th>{{ __(' Internal IP Address') }}</th>
                            <th>{{ __(' Public Port') }}</th>
                            <th>{{ __(' Created By') }}</th>
                            <th class="text-center">{{ __('Added') }}</th>
                            <th class="text-center">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        @php $sl = 1; @endphp
                        @foreach($devices as $device)
                        @php $userName = \App\User::where('id',$device->created_by)->pluck('name');@endphp
                        <tr>
                            <td>{{ $sl++ }}</td>
                            <td>{{ $device['id'] }}</td>
                            <td>{{ $device['device_name'] }}</td>
                            <td>{{ $device['serial_number'] }}</td>
                            <td>{{ $device['device_version'] }}</td>
                            <td>{{ $device['device_ip_hidden'] }}</td>
                            <td>{{ $device['device_ip_internal'] }}</td>
                            <td>{{ $device['device_port_public_h'] }}</td>
                            <td>{{ $userName[0] }}</td>
                            <td class="text-center">{{ date("d F Y", strtotime($device['created_at'])) }}</td>
                            <td class="text-center">
                                <a href="{{ url('/device/'.$device['id'].'/edit') }}"><i class="icon fa fa-edit"></i></a>
                                <a href="{{ url('/device/'.$device['id'].'/clearAttData') }}"><i class="icon fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
@endsection