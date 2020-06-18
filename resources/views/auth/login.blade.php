@extends('layouts.app')

@section('content')
<div class="col-md-offset-4 col-md-6 py-5 full_container" style="background:rgba(28, 45, 42,0.7);border-radius:10px; color: #fff; margin:0 auto; margin-top: 100px;">
    <div class="row">
        <div class="col-md-6 panel_container" style="border-right: 2px solid grey;" >
            <div class="panel panel-default">
                {{-- <div class="panel-heading" style="font-size: 30px;margin-left: 16px;">{{ __('Login') }}</div> --}}

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-6 control-label">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-6 control-label">{{ __('Password') }}</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    {{ __('Login') }}
                                </button>
                                <a href="/register" class="btn btn-warning btn-lg">Register</a>
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                   {{ __('Forgot Your Password?') }} 
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="text_container text-white text-center">
                <img src="" alt="LOGO" width="200" class="logo"> 
                
                <h1 class="title">HRMS</h1>
                <p class="text_block">A total Human Resource Management Solution</p>
            </div>
        </div>
    </div>
    
</div>
@endsection
