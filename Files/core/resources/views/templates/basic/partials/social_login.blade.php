@php
    $credentials = gs('socialite_credentials');
@endphp
@if ($credentials->google->status == Status::ENABLE || $credentials->facebook->status == Status::ENABLE || $credentials->linkedin->status == Status::ENABLE)
    <div class="col-12">
        <span class="social-or">
            @lang('Or')
            @if (request()->route()->getName() == 'user.login')
                @lang('Login')
            @else
                @lang('Register')
            @endif
            @lang('With')
        </span>
    </div>
    <div class="col-12">
        <ul class="social-login">
            @if ($credentials->facebook->status == Status::ENABLE)
                <li class="login-item facebook">
                    <a class="login-link flex-center w-100" class="flex-align gap-5" href="{{ route('user.social.login', 'facebook') }}">
                        <span class="icon_facebook"><i class="fab fa-facebook-f"></i></span>
                        <span class="text">@lang('Facebook')</span>
                    </a>
                </li>
            @endif
            @if ($credentials->google->status == Status::ENABLE)
                <li class="login-item google">
                    <a class="login-link flex-center w-100" class="flex-align gap-5" href="{{ route('user.social.login', 'google') }}">
                        <span class="icon_google"><i class="fab fa-google"></i></span>
                        <span class="text">@lang('Google')</span>
                    </a>
                </li>
            @endif
            @if ($credentials->linkedin->status == Status::ENABLE)
                <li class="login-item linkedin">
                    <a class="login-link flex-center w-100" class="flex-align gap-5" href="{{ route('user.social.login', 'linkedin') }}">
                        <span class="icon_linkedin"><i class="fab fa-linkedin-in"></i></span>
                        <span class="text">@lang('Linkedin')</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif

@push('style')
    <style>
        .social-or {
            display: block;
            text-align: center;
            width: 30px;
            position: relative;
            width: 100%;
            z-index: 1;
            margin: 20px 0;
        }

        .social-or::before,
        .social-or::after {
            position: absolute;
            content: "";
            left: -10px;
            top: 50%;
            width: 40%;
            height: 1px;
            background-color: rgb(77, 74, 74);
        }

        .social-or::after {
            left: auto;
            right: -10px;
        }

        .social-login {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }

        .social-login .login-item {
            flex: 1 0 calc(33% - 15px);
        }

        @media screen and (max-width: 424px) {
            .social-login .login-item {
                flex: 1 0 100%;
            }
        }

        .social-login .login-link {
            justify-content: center;
            gap: 10px;
            padding-block: 10px;
            border-radius: 30px;
            transition: 0.3s;
            display: flex !important;
            justify-content: center;
        }

        .icon_facebook {
            background-color: transparent;
            color: #3B5998;
            transition: .3s;
        }

        .icon_google {
            background-color: transparent;
            color: #CB2027;
            transition: .3s;
        }

        .icon_linkedin {
            background-color: transparent;
            color: #0077B5;
            transition: .3s;
        }

        .login-item.facebook .login-link {
            border: 2px solid #3B5998;
        }

        .login-item.facebook .login-link:hover {
            background-color: #3B5998;
            color: #fff !important;
        }

        .login-item.facebook .login-link:hover .icon_facebook {
            color: #fff !important;
        }

        .login-item.google .login-link {
            border: 2px solid #CB2027;
        }

        .login-item.google .login-link:hover {
            background-color: #CB2027;
            color: #fff !important;
        }

        .login-item.google .login-link:hover .icon_google {
            color: #fff !important;
        }

        .login-item.linkedin .login-link {
            border: 2px solid #0077B5;
        }

        .login-item.linkedin .login-link:hover {
            background-color: #0077B5;
            color: #fff !important;
        }

        .login-item.linkedin .login-link:hover .icon_linkedin {
            color: #fff !important;
        }

        @media screen and (max-width: 1199px) {

            .social-or::before,
            .social-or::after {
                width: 30%;
            }
        }

        @media screen and (max-width: 767px) {

            .social-or::before,
            .social-or::after {
                width: 28%;
            }
        }
    </style>
@endpush
