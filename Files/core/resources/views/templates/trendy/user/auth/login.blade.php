@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @php
        $loginContent = getContent('login.content', true);
    @endphp

    <section class="account">
        <div class="account-content">
            <div class="account-logo">
                <div class="container">
                    <a href="{{ route('home') }}">
                        <img src="{{ siteLogo() }}" alt="site-logo">
                    </a>
                </div>
            </div>
            <div class="account-form">
                <div class="row justify-content-center">
                    <div class="col-xxl-7 col-xl-9 col-lg-11 col-md-12">
                        <div class="account-form__content text-center">
                            <h2 class="account-form__title mb-2"> {{ __(@$loginContent->data_values->heading) }} </h2>
                            <p class="account-form__desc"> {{ __(@$loginContent->data_values->sub_heading) }} </p>
                        </div>
                        <form class="verify-gcaptcha" method="POST" action="{{ route('user.login') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <div class="form--group">
                                        <label class="form--label" for="email">@lang('Username or Email')</label>
                                        <input class="form--control" name="username" type="text" value="{{ old('username') }}" required>
                                    </div>
                                </div>
                                <div class="col-12 form-group">
                                    <label class="form--label" for="your-password">@lang('Password')</label>
                                    <div class="position-relative">
                                        <input class="form--control form--control" id="your-password" name="password" type="password" required>
                                        <span class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#your-password"></span>
                                    </div>
                                </div>

                                <x-captcha />

                                <div class="col-sm-12">
                                    <div class="flex flex-wrap align-items-center justify-content-between g-1 mb-3">
                                        <div class="form-group form--check mb-0">
                                            <input class="form-check-input" id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                @lang('Remember Me')
                                            </label>
                                        </div>
                                        <a class="fs-14 forgot-password" href="{{ route('user.password.request') }}">
                                            @lang('Forgot your password?')
                                        </a>
                                    </div>
                                </div>

                                <div class="col-sm-12 form-group">
                                    <button class="btn btn--base w-100" type="submit"> @lang('Sign In') </button>
                                </div>
                                @if (gs('registration'))
                                    <div class="col-sm-12">
                                        <div class="have-account text-center">
                                            <p class="have-account__text"> @lang('Don\'t have an account?') <a class="have-account__link" href="{{ route('user.register') }}"> @lang('Sign Up') </a></p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </form>
                        @include($activeTemplate . 'partials.social_login')
                    </div>
                </div>
            </div>
            <div class="account-copyright">
                <span class="fs-12 account-copyright__text">
                    @lang('Copyright') &copy; {{ date('Y') }} <a class="t-link" href="{{ route('home') }}">{{ __(gs('site_name')) }}</a> @lang('All Rights Reserved')
                </span>
            </div>
        </div>
        <div class="account-thumb">
            <img src="{{ frontendImage('login', @$loginContent->data_values->image, '960x965') }}" alt="">
        </div>
    </section>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $('[name=captcha]').siblings('label').removeClass('form-label').addClass('form--label');

        })(jQuery)
    </script>
@endpush
