@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container py-100">
        <div class="d-flex justify-content-center">
            <div class="verification-code-wrapper custom--card border-0">
                <div class="verification-area">
                    <h5 class="pb-3 text-center border-bottom">@lang('2FA Verification')</h5>
                    <form action="{{ route('user.2fa.verify') }}" method="POST" class="submit-form">
                        @csrf

                        @include($activeTemplate . 'partials.verification_code')

                        <div class="form--group">
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </div>
                    </form>
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
            $('.verification-code').siblings('label').removeClass('form-label').addClass('form--label');
        })(jQuery)
    </script>
@endpush
