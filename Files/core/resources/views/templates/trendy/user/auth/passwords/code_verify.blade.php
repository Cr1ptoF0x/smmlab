@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="py-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-5">
                    <div class="d-flex justify-content-center">
                        <div class="verification-code-wrapper">
                            <div class="verification-area">
                                <h5 class="border-bottom pb-3 text-center">@lang('Verify Your Email')</h5>
                                <form class="submit-form" action="{{ route('user.password.verify.code') }}" method="POST">
                                    @csrf
                                    <p class="pb-3">@lang('A 6 digit verification code sent to your email address') : {{ showEmailAddress($email) }}</p>
                                    <input name="email" type="hidden" value="{{ $email }}">

                                    @include($activeTemplate . 'partials.verification_code')

                                    <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>

                                    <div class="mt-3">
                                        @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                        <a href="{{ route('user.password.request') }}" class="text--base">@lang('Try to send again')</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
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

        })(jQuery)
    </script>
@endpush
