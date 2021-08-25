@extends('layouts.app')

@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="center-block w-xxl w-auto-xs p-y-md">
    
    <div class="p-a-md box-color r box-shadow-z1 text-color m-a">
        <div class="m-b text-sm">
            <!-- Sign up to your Flatkit Account -->
            {{ __('Register') }}
        </div>
        <form name="form">
            <div class="md-form-group">
                <input type="text" class="md-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                <label>{{ __('Name') }}</label>
            </div>
            <div class="md-form-group">
                <input type="email" class="md-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                <label>{{ __('E-Mail Address') }}</label>
            </div>
            <div class="md-form-group">
                <input type="password" class="md-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                <label>{{ __('Password') }}</label>
            </div>
            <div class="md-form-group">
                <input type="password" class="md-input" name="password_confirmation" required autocomplete="new-password">
                <label>{{ __('Confirm Password') }}</label>
            </div>
            <button type="submit" class="btn primary btn-block p-x-md"> {{ __('Register') }}</button>
        </form>
    </div>

    <div class="p-v-lg text-center">
        <div>{{__('Already have an account? ') }}
            <a href="{{ route('login') }}" class="text-primary _600">{{__('Login')}}</a>
        </div> 
    </div>
  </div>

@endsection
