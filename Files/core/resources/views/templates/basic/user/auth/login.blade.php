@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $loginContent = getContent('login.content', true);
    @endphp
    <!-- register-section start -->
    <section class="register-section ptb-80">
        <div class="register-element-one">
            <img src="{{ asset($activeTemplateTrue . 'images/round.png') }}" alt="@lang('shape')">
        </div>
        <div class="container">
            <figure class="figure highlight-background highlight-background--lean-left">
                <img src="{{ asset($activeTemplateTrue . 'images/svg/animation.svg') }}" alt="">
            </figure>
            <div class="account-wrapper">
                <div class="signup-area account-area change-form">
                    <div class="row gy-3">
                        <div class="col-lg-6 pe-lg-0">
                            <div class="register-form-area common-form-style bg-one create-account">
                                <h4 class="title text-center mb-4">@lang('Login Your Account')</h4>
                                <form class="create-account-form register-form verify-gcaptcha" method="POST" action="{{ route('user.login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">@lang('Username or Email')</label>
                                        <input class="form--control" name="username" type="text" value="{{ old('username') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">@lang('Password')</label>
                                        <input class="form--control" id="password" name="password" type="password" required autocomplete="current-password">
                                    </div>

                                    <x-captcha />

                                    <div class="form-group">
                                        <div class="checkbox-wrapper d-flex flex-wrap justify-content-between">
                                            <div class="checkbox-item">
                                                <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                                <label for="remember">@lang('Remember Me')</label>
                                            </div>
                                            <a class="text--base" href="{{ route('user.password.request') }}">@lang('Forgot Password?')</a>
                                        </div>
                                    </div>
                                    <button class="btn btn--base w-100 h-45" type="submit">@lang('Login')</button>
                                </form>
                                @include($activeTemplate . 'partials.social_login')
                            </div>
                        </div>
                        <div class="col-lg-6 ps-lg-0">
                            <div class="change-catagory-area" style="background-image: url('{{ frontendImage('login',@$loginContent->data_values->image, '636x580') }}')">
                                <h4 class="title">
                                    {{ __(@$loginContent->data_values->heading) }}
                                </h4>
                                <a class="btn--base-active account-control-button" href="{{ route('user.register') }}">@lang('Create Account')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- register-section end -->
@endsection

@push('script')
    <script>
        "use strict";

        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML =
                    '<span style="color:red;">@lang('Captcha field is required.')</span>';
                return false;
            }
            return true;
        }

        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }
        (function($) {
            $('.captcha').remove();
        })(jQuery);
    </script>
@endpush
