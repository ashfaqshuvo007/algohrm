@extends('administrator.master')
@section('title', __('Update Profile'))

@section('main_content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ __('PROFILE') }}
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i>{{ __('Dashboard') }} </a></li>
                <li class="active">{{ __('Update Profile') }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- SELECT2 EXAMPLE -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('Update Profile') }}</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <form action="{{ url('/people/employees/update-profile-image/'.$user['id']) }}" method="post"
                      name="user_edit_form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                @if(!empty($user['avatar']))
                                    <img src="{{ url('/public/profile_picture/' . $user['avatar']) }}"
                                         alt="$user['avatar']" class="img-responsive img-thumbnail">
                                @else
                                    <img src="{{ url('/public/profile_picture/blank_profile_picture.png') }}"
                                         alt="blank_profile_picture" class="img-responsive img-thumbnail">
                                @endif

                                <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }} has-feedback">
                                    <input type="file" name="avatar" id="avatar" class="form-control">
                                    <input type="hidden" name="previous_avater" value="{{ $user['avatar'] }}">
                                    @if ($errors->has('avatar'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('avatar') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat"><i
                                    class="icon fa fa-edit"></i> {{ __('Update Profile') }}</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>

@endsection
