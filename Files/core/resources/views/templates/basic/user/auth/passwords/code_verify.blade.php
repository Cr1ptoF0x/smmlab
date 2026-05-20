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
            <div class="d-flex justify-content-center">
                <div class="verification-code-wrapper verify-form">
                    <div class="verification-area">
                        <form class="submit-form" action="{{ route('user.password.verify.code') }}" method="POST">
                            @csrf
                            <p class="py-3 mb-0">@lang('A 6 digit verification code sent to your email address') : {{ showEmailAddress($email) }}</p>
                            <input name="email" type="hidden" value="{{ $email }}">

                            @include($activeTemplate . 'partials.verification_code')

                            <button class="btn btn--base w-100 h-45" type="submit">@lang('Submit')</button>

                            <div class="mt-3">
                                @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                <a class="text--base" href="{{ route('user.password.request') }}">@lang('Try to send again')</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .verification-code-wrapper {
            z-index: 100
        }

        .verification-code span {
            background: transparent;
            border: solid 1px #{{ gs('base_color') }}59 !important;
            color: #{{ gs('base_color') }} !important;
        }
    </style>
@endpush
