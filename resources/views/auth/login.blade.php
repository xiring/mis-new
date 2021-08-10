@extends('layouts.app')

@section('content')
    <div class="card-header text-center" style="background: #000000">
        <a href="{{ url('/') }}">
            <img class="logo-img" src="{{ asset('assets/uploads/logo.png') }}" width="200px" alt="logo">
        </a><span class="splash-description">Please enter your user information.</span>
    </div>
    <div class="card-body">
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-group">
                <input name="email" class="form-control form-control-lg" id="email" type="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="off">
                @if ($errors->has('email'))
                    <ul class="parsley-errors-list filled">
                        {{ $errors->first('email') }}
                    </ul>
                @endif

            </div>
            <div class="form-group">
                <input name="password" class="form-control form-control-lg" id="password" type="password" placeholder="Password" required>
                @if ($errors->has('password'))
                    <ul class="parsley-errors-list filled">
                        {{ $errors->first('password') }}
                    </ul>
                @endif

            </div>
            <div class="form-group">
                <label class="custom-control custom-checkbox">
                    <input class="custom-control-input" name="remember" {{ old('remember') ? 'checked' : '' }} type="checkbox"><span class="custom-control-label">Remember Me</span>
                </label>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
        </form>
    </div>
    <div class="card-footer bg-white p-0  ">
        <div class="card-footer-item card-footer-item-bordered">
            <a href="{{ route('password.request') }}" class="footer-link">Forgot Password</a>
        </div>
    </div>
@endsection
