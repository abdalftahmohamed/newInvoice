@extends('layouts.dashboard.auth')
@section('title')
    @lang('dashboard.rest')
@endsection
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-md-4 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <img src="{{ asset('assets/dashboard') }}/images/logo/logo-dark.png"
                                            alt="branding logo">
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                        <span>@lang('dashboard.Change password')</span>
                                    </h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('dashboard.password.rest') }}"
                                            class="form-horizontal" action="index.html" novalidate>
                                            @csrf
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="hidden" value="{{ $email }}" name="email"
                                                    type="text" class="form-control input-lg" id="user-name"
                                                    placeholder="@lang('dashboard.email')" tabindex="1" {{-- required
                                                    data-validation-required-message="Please enter your username." --}}>
                                                @error('email')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror

                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input name="password" type="password" class="form-control input-lg"
                                                    id="password" placeholder="@lang('dashboard.password')" tabindex="2"
                                                    {{-- required
                                                    data-validation-required-message="Please enter valid passwords." --}}>
                                                @error('password')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="form-control-position">
                                                    <i class="la la-key"></i>
                                                </div>

                                                <div class="help-block font-small-3"></div>
                                            </fieldset>

                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input name="password_confirmation" type="password"
                                                    class="form-control input-lg" id="password_confirmation"
                                                    placeholder="@lang('dashboard.password_confirmation')" tabindex="2" {{-- required
                                                    data-validation-required-message="Please enter valid passwords." --}}>
                                                @error('password_confirmation')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="form-control-position">
                                                    <i class="la la-key"></i>
                                                </div>

                                                <div class="help-block font-small-3"></div>
                                            </fieldset>

                                            <div class="form-group row">

                                                <div class="col-md-6 col-12 text-center text-md-right"><a
                                                        href="{{ route('dashboard.login.showLoginForm') }}"
                                                        class="card-link">@lang('dashboard.login')</a>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-danger btn-block btn-lg"><i
                                                    class="ft-unlock"></i> @lang('dashboard.reset')</button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
