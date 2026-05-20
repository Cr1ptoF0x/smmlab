@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="mb-1">@lang('Refer & Enjoy the Bonus')</h4>
                    <p class="mb-3">@lang('You\'ll get commission against your referral\'s activities. Level has been decided by the') <strong><i>{{ __(gs('site_name')) }}</i></strong> @lang('authority. If you reach the level, you\'ll get commission.')</p>
                    <div class="form-group">
                        <div class="copy-link">
                            <input class="copyURL" class="form-control form--control" id="key" name="key" type="text" value="{{ route('home') }}?reference={{ auth()->user()->username }}" readonly="">
                            <span class="copy" data-id="key">
                                <i class="las la-copy"></i> <strong class="copyText">@lang('Copy')</strong>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @if ($user->allReferrals)
            @if ($user->allReferrals->count() > 0 && $maxLevel > 0)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="treeview-container">
                                <ul class="treeview">
                                    <li class="items-expanded"> {{ $user->fullname }} ( {{ $user->username }} )
                                        @include($activeTemplate . 'partials.under_tree', ['user' => $user, 'layer' => 0, 'isFirst' => true])
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection

@push('style')
    <link type="text/css" href="{{ asset('assets/global/css/jquery.treeView.css') }}" rel="stylesheet">
@endpush
@push('script')
    <script src="{{ asset('assets/global/js/jquery.treeView.js') }}"></script>

    <script>
        (function($) {
            "use strict";

            $('.treeview').treeView();

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
