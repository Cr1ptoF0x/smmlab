@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="register-section ptb-80">
        <div class="register-element-one">
            <img src="{{ asset($activeTemplateTrue . 'images/round.png') }}" alt="@lang('shape')">
        </div>
        <div class="container">
            <figure class="figure highlight-background highlight-background--lean-left">
                <img src="{{ asset($activeTemplateTrue . 'images/svg/animation.svg') }}" alt="">
            </figure>
            <div class="container">
                <div class="d-flex justify-content-center">
                    <div class="verification-code-wrapper">
                        <div class="verification-area">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <h4>@lang('Verify Mobile Number')</h4>
                                <a href="{{ route('user.logout') }}" class="btn btn-outline--danger btn-sm">@lang('Logout')</a>
                            </div>
                            <form action="{{ route('user.verify.mobile') }}" method="POST" class="submit-form">
                                @csrf
                                <p class="py-3">@lang('A 6 digit verification code sent to your mobile number') :
                                    +{{ showMobileNumber(auth()->user()->mobileNumber) }}</p>
                                @include($activeTemplate . 'partials.verification_code')
                                <div class="mb-3">
                                    <button type="submit" class="btn btn--base w-100 h-45">@lang('Submit')</button>
                                </div>
                                <div class="form-group">
                                    <p>
                                        @lang('If you don\'t get any code'), <span class="countdown-wrapper">@lang('try again after') <span
                                                  id="countdown" class="fw-bold">--</span> @lang('seconds')</span> <a
                                           href="{{ route('user.send.verify.code', 'sms') }}"
                                           class="try-again-link d-none"> @lang('Try again')</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
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
    </script>
@endpush
@push('style')
    <style>
        .verification-code-wrapper {
            z-index: 100;
        }

        .verify-form {
            background-color: #edeff4;
        }

        .verification-code span {
            background: transparent;
            border: solid 1px #{{ gs('base_color') }}59 !important;
            color: #{{ gs('base_color') }} !important;
        }
    </style>
@endpush
