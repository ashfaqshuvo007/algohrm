@extends('administrator.master')
@section('title', __('Device Users'))

@section('main_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ __('Device Users') }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a></li>
            <li><a>{{ __('Devices') }}</a></li>
            <li class="active">{{ __('Device Users List') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            {{-- <div class="box-header with-border">
                <h3 class="box-title">{{ __('Device Users List') }}</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div>
            </div> --}}
            <div  class="col-md-3">
              <button type="button" class="tip btn btn-primary btn-flat" title="Print" data-original-title="Label Printer" onclick="printDiv('printable_area')">
                    <i class="fa fa-print"></i>
                    <span class="hidden-sm hidden-xs"> {{ __('Print') }}</span>
                </button>
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
                                    <th>{{ __(' User Name') }}</th>
                                    <th>{{ __(' Device UUID') }}</th>
                                    <th>{{ __(' Device User ID') }}</th>
                                    <th>{{ __(' Device User Role') }}</th>
                                    <th>{{ __(' Device User Password') }}</th>
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                @php $sl = 1; @endphp
                                @foreach($deviceUsers as $key => $user)
                                @php 
                                    $userRole = '';
                                   if($user[2] == '14'){
                                    $userRole = 'SUPERMANAGER';
                                   }elseif($user[2] == '12'){
                                    $userRole = 'MANAGER';
                                   }elseif($user[2] == '2'){
                                    $userRole = 'ENROLLER';
                                   }else{
                                    $userRole = 'USER';
                                   }
                                @endphp
                                <tr>
                                    <td>{{ $sl++ }}</td>
                                    <td>{{ $user[1]}}</td>
                                    <td>{{ $key  }}</td>
                                    <td>{{ $user[0] }}</td>
                                    <td>{{ $userRole }}</td>
                                    <td>{{ $user[3] }}</td>
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