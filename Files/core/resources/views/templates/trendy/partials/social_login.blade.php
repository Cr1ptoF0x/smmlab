@php
    $credentials = gs('socialite_credentials');
@endphp
@if (
    $credentials->google->status == Status::ENABLE ||
        $credentials->facebook->status == Status::ENABLE ||
        $credentials->linkedin->status == Status::ENABLE)
    <div class="col-12 mt-3">
        <p class="text-center sm-text">
            @lang('or')
        </p>
        <div class="social-logins d-flex flex-wrap justify-content-center">
            @if ($credentials->facebook->status == Status::ENABLE)
                <a class="facebook " href="{{ route('user.social.login', 'facebook') }}">
                    <span class="icon"><i class="la la-facebook"></i></span></a>
            @endif
            @if ($credentials->google->status == Status::ENABLE)
                <a class="google " href="{{ route('user.social.login', 'google') }}">
                    <span class="icon"><i class="la la-google"></i></span></a>
            @endif
            @if ($credentials->linkedin->status == Status::ENABLE)
                <a class="linkedin" href="{{ route('user.social.login', 'linkedin') }}">
                    <span class="icon"><i class="la la-linkedin"></i></span></a>
            @endif
        </div>
    </div>
@endif

@push('style')
    <style>
        .social-logins a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff !important;
        }


        .social-logins {
            margin: 15px 0 30px;
            gap: 18px;
        }

        .social-logins .btn {
            font-size: 16px;
        }

        .social-logins .google {
            background: #df6156 !important;
        }

        .social-logins .google:hover {
            background: #f61d09 !important;
        }

        .social-logins .facebook {
            background: rgb(76, 120, 212) !important;
        }

        .social-logins .facebook:hover {
            background: #316FF6 !important;
        }

        .social-logins .linkedin {
            background: #1b658e !important;
        }

        .social-logins .linkedin:hover {
            background: #0077b5 !important;
        }

        .social-logins .icon {
            margin-right: 0;
        }

        @media (max-width: 1499px) {
            .social-logins {
                gap: 40px
            }
        }

        @media (max-width: 991px) {
            .account-form {
                padding: 35px 20px;
            }

            .social-logins {
                font-size: 14px;
            }

            .social-logins {
                gap: 30px
            }
        }

        @media (max-width: 424px) {
            .social-logins {
                gap: 30px
            }
        }
    </style>
@endpush
