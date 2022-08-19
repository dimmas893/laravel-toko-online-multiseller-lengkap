@extends('layouts.blank')

@section('content')

<div class="cls-content-sm panel">
    <div class="panel-body">
        <h1 class="h3">{{ __('Reset Password') }}</h1>
        <p class="pad-btm">{{__('Enter your email address to recover your password.')}} </p>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                    <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Email or Phone">
                @else
                    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ __('Email') }}" name="email">
                @endif

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group text-right">
                <button class="btn btn-danger btn-lg btn-block" type="submit">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>
        </form>
        <div class="pad-top">
            <a href="{{route('user.login')}}" class="btn-link text-bold text-main">{{__('Back to Login')}}</a>
        </div>
    </div>
</div>


@endsection
