@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row mb-none-30 justify-content-center">

        @if (!auth()->user()->ts)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Add Your Account')</h5>
                    </div>

                    <div class="card-body">
                        <h6 class="mb-3">
                            @lang('Use the QR code or setup key on your Google Authenticator app to add your account.')
                        </h6>

                        <div class="form-group mx-auto text-center">
                            <img class="mx-auto" src="{{ $qrCodeUrl }}" alt="">
                        </div>

                        <div class="form-group">
                            <label>@lang('Setup Key')</label>
                            <div class="copy-link">
                                <input class="copyURL" id="key" name="key" type="text" value="{{ $secret }}" readonly="">
                                <span class="copy" data-id="key">
                                    <i class="las la-copy"></i> <strong class="copyText">@lang('Copy')</strong>
                                </span>
                            </div>
                        </div>

                        <label><i class="fa fa-info-circle"></i> @lang('Help')</label>
                        <p>@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.') <a class="text--base" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('Download')</a></p>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-6">

            @if (auth()->user()->ts)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Disable 2FA Security')</h5>
                    </div>
                    <form class="dashboard-form" action="{{ route('user.twofactor.disable') }}" method="POST">
                        <div class="card-body">
                            @csrf
                            <input name="key" type="hidden" value="{{ $secret }}">
                            <div class="form-group">
                                <label class="form--label">@lang('Google Authenticatior OTP')</label>
                                <input class="form-control form--control" name="code" type="text" required>
                            </div>
                            <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            @else
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Enable 2FA Security')</h5>
                    </div>
                    <form class="dashboard-form" action="{{ route('user.twofactor.enable') }}" method="POST">
                        <div class="card-body">
                            @csrf
                            <input name="key" type="hidden" value="{{ $secret }}">
                            <div class="form-group">
                                <label class="form-label">@lang('Google Authenticatior OTP')</label>
                                <input class="form-control form--control" name="code" type="text" required>
                            </div>
                            <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('style')
    <style>
        .copy-link {
            position: relative;
        }

        .copy-link input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d7d7d7;
            border-radius: 4px;
            transition: all .3s;
            padding-right: 70px;
        }

        .copy-link span {
            text-align: center;
            position: absolute;
            top: 12px;
            right: 10px;
            cursor: pointer;
        }

        .form-check-input:focus {
            box-shadow: none;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.copy').on('click', function() {
                var copyText = document.getElementById($(this).data('id'));
                copyText.select();
                copyText.setSelectionRange(0, 99999);

                document.execCommand("copy");
                $(this).find('.copyText').text('Copied');

                setTimeout(() => {
                    $(this).find('.copyText').text('Copy');
                }, 2000);
            });

        })(jQuery);
    </script>
@endpush
