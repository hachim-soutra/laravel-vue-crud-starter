@extends('layouts.app')

@section('content')

<!-- ############ LAYOUT START-->
    <div class="center-block w-xxl w-auto-xs p-y-md h-100">
        <div class="p-a-md box-color r box-shadow-z1 text-color m-a">
            <div class="m-b text-sm">
                <!-- Sign in with your Flatkit Account -->
                {{ __('Login') }}
            </div>
            <form  method="POST" action="{{ route('login') }}">
                @csrf
                <div class="md-form-group float-label">
                    <input name="email" type="email" class="md-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus >
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <label>{{ __('E-Mail Address') }}</label>
                </div>
                <div class="md-form-group float-label">
                    <input type="password" class="md-input  @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <label>Password</label>

                </div>
                <div class="m-b-md">
                    <label class="md-check">
                        <input type="checkbox"><i class="primary"></i>  {{ __('Remember Me') }}
                    </label>
                </div>
                <button type="submit" class="btn primary btn-block p-x-md">{{ __('Login') }}</button>
            </form>
        </div>

        <div class="p-v-lg text-center">
            <div class="m-b">
                <a href="{{ route('password.request') }}" class="text-primary _600">{{ __('Forgot Your Password?') }}</a>
            </div>
            <div>{{ __('Do not have an account?') }}
                <a  class="text-primary _600" href="{{ route('register') }}">
                    {{ __('Register') }}
                </a>
            </div>
        </div>
    </div>

<!-- ############ LAYOUT END-->
@endsection
