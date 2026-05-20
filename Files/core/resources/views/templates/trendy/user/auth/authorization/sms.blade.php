@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container py-100">
        <div class="d-flex justify-content-center">
            <div class="verification-code-wrapper custom--card border-0">
                <div class="verification-area">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">@lang('Verify Mobile Number')</h5>
                        <a href="{{ route('user.logout') }}"
                           class="btn btn--sm btn-outline--danger btn--logout">@lang('Logout')</a>
                    </div>
                    <form class="submit-form" action="{{ route('user.verify.mobile') }}" method="POST">
                        @csrf

                        <p class="pb-3">@lang('A 6 digit verification code sent to your mobile number') : +{{ showMobileNumber(auth()->user()->mobile) }}</p>
                        @include($activeTemplate . 'partials.verification_code')

                        <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>

                        <div class="mt-3">
                            <p>
                                @lang('If you don\'t get any code'), <span class="countdown-wrapper d-inline">@lang('try again after') <span
                                          id="countdown" class="fw-bold">--</span> @lang('seconds')</span> <a
                                   href="{{ route('user.send.verify.code', 'sms') }}" class="try-again-link d-none text--base">
                                    @lang('Try again')</a>
                            </p>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .verification-area .btn--logout {
            padding: 8px 12px !important;
            border-width: 1px !important;
        }

        .verification-area .btn--logout:hover,
        .verification-area .btn--logout:focus {
            border-color: hsl(var(--danger)) !important;
        }

        .verification-code-wrapper {
            z-index: 100;
        }

        .verify-form {
            background-color: #edeff4;
        }

        .verification-code span {
            background: transparent;
            border: solid 1px #{{ gs('base_color') }}7d;
            color: #{{ gs('base_color') }};
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.verification-code').siblings('label').removeClass('form-label').addClass('form--label');

            var distance = Number("{{ @$user->ver_code_send_at->addMinutes(2)->timestamp - time() }}");
            var x = setInterval(function() {
                distance--;
                document.getElementById("countdown").innerHTML = distance;
                if (distance <= 0) {
                    clearInterval(x);
                    document.querySelector('.countdown-wrapper').classList.add('d-none');
                    document.querySelector('.try-again-link').classList.remove('d-none');
                }
            }, 1000);
        })(jQuery)
    </script>
@endpush
