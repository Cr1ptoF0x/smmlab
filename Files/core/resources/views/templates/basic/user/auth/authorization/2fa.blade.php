@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="verification-code-wrapper">
                <div class="verification-area">
                    <h5 class="pb-3 text-center border-bottom">@lang('2FA Verification')</h5>
                    <form action="{{ route('user.go2fa.verify') }}" method="POST" class="submit-form">
                        @csrf

                        @include($activeTemplate . 'partials.verification_code')

                        <div class="form--group">
                            <button type="submit" class="submit-btn btn-block  btn-lg w-100">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
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
