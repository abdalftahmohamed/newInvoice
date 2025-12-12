@extends('layouts.dashboard.auth')
@section('title')
    @lang('dashboard.login')
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
                                        <span>@lang('dashboard.login_to_adminpanel')</span>
                                    </h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('dashboard.register.post') }}"
                                              class="form-horizontal" novalidate>
                                            @csrf
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <select name="role_id" class="form-control input-lg" required>
                                                    <option value="">{{__('Select Role')}}</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->role }}</option>
                                                    @endforeach
                                                </select>
                                                @error('role_id')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="help-block font-small-3"></div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input name="name" type="text" class="form-control input-lg"
                                                       id="user-name" placeholder="{{__('name')}}" tabindex="1">
                                                @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                                <div class="help-block font-small-3"></div>
                                            </fieldset>

                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input name="email" type="email" class="form-control input-lg"
                                                       id="user-email" placeholder="{{__('email')}}" tabindex="1">
                                                @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="form-control-position">
                                                    <i class="ft-mail"></i>
                                                </div>
                                                <div class="help-block font-small-3"></div>
                                            </fieldset>

                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input name="password" type="password" class="form-control input-lg"
                                                       id="password" placeholder="@lang('dashboard.password')"
                                                       tabindex="2">
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
                                                       class="form-control input-lg"
                                                       id="password"
                                                       placeholder="@lang('dashboard.password_confirmation')"
                                                       tabindex="2">
                                                @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                                <div class="form-control-position">
                                                    <i class="la la-key"></i>
                                                </div>

                                                <div class="help-block font-small-3"></div>
                                            </fieldset>

                                            <div class="form-group row">
                                                {{--                                                <div class="col-md-6 col-12 text-center text-md-left">--}}
                                                {{--                                                    <fieldset>--}}
                                                {{--                                                        <input name="remember" type="checkbox" id="remember-me"--}}
                                                {{--                                                            class="chk-remember">--}}
                                                {{--                                                        <label for="remember-me"> @lang('dashboard.remember_me')</label>--}}
                                                {{--                                                    </fieldset>--}}
                                                {{--                                                </div>--}}
                                                <div class="col-md-12 col-12 text-center "><a
                                                        href="{{route('dashboard.login.showLoginForm')}}"
                                                        class="card-link">@lang('auth.login')</a>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-danger btn-block btn-lg"><i
                                                    class="ft-unlock"></i> @lang('dashboard.register')</button>
                                        </form>
                                    </div>
                                </div>
                                {{-- <div class="card-footer border-0">
                                    <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                        <span>New to Modern ?</span>
                                    </p>
                                    <a href="register-advanced.html" class="btn btn-info btn-block btn-lg mt-3"><i
                                            class="ft-user"></i> Register</a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
