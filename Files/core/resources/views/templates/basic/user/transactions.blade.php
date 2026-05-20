@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row mb-none-30">
        <div class="col-12">
            <div class="filter-area mb-3">
                <form class="form" action="">
                    <div class="d-flex flex-wrap gap-4">
                        <div class="flex-grow-1">
                            <div class="custom-input-box trx-search">
                                <label>@lang('Trx Number')</label>
                                <input name="search" type="search" value="{{ request()->search }}" placeholder="@lang('Trx Number')">
                                <button class="icon-area" type="submit">
                                    <i class="las la-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="custom-input-box trx-search">
                                <label>@lang('Date')</label>
                                <input class="datepicker-here" name="date" data-range="true" data-multiple-dates-separator=" - " data-language="en" data-format="Y-m-d" data-position='bottom right' type="search" value="{{ request()->date }}" placeholder="@lang('Start Date - End Date')" autocomplete="off">
                                <button class="icon-area" type="submit">
                                    <i class="las la-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="custom-input-box">
                                <label>@lang('Type')</label>
                                <select name="trx_type" class="select2">
                                    <option value="">@lang('All')</option>
                                    <option value="+" @selected(request()->trx_type == '+')>@lang('Plus')</option>
                                    <option value="-" @selected(request()->trx_type == '-')>@lang('Minus')</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="custom-input-box">
                                <label>@lang('Remark')</label>
                                <select name="remark" class="select2">
                                    <option value="">@lang('Any')</option>
                                    @foreach ($remarks as $remark)
                                        <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>
                                            {{ __(keyToTitle($remark->remark)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12">
            @if (!blank($transactions))
                <div class="dashboard-accordion-table mt-5">
                    <div class="accordion table--acordion" id="transactionAccordion">
                        @forelse($transactions as $trx)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="h-{{ $loop->index }}">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#c-{{ $loop->index }}" type="button" aria-expanded="false" aria-controls="c-{{ $loop->index }}">
                                        <div class="col-xl-4 col-sm-5 col-8 order-1">
                                            <div class="left">
                                                <div class="icon @if ($trx->trx_type == '+') rcv-item success @else sent-item danger @endif">
                                                    @if ($trx->trx_type == '+')
                                                        <i class="las la-long-arrow-alt-right"></i>
                                                    @else
                                                        <i class="las la-long-arrow-alt-left"></i>
                                                    @endif
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb-0"> {{ __(keyToTitle($trx->remark)) }}</h6>
                                                    <span class="date-time"> {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-4 col-12 order-sm-2 order-3 transaction-wrapper">
                                            <p class="transaction-id">{{ $trx->trx }}</p>
                                        </div>
                                        <div class="col-xl-4 col-sm-3 col-4 order-sm-3 order-2 text-end amount-wrapper">
                                            <p class="amount">{{ showAmount($trx->amount) }}</p>
                                        </div>
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" id="c-{{ $loop->index }}" data-bs-parent="#transactionAccordion" aria-labelledby="h-{{ $loop->index }}">
                                    <div class="accordion-body">
                                        <ul class="caption-list">
                                            <li class="caption-list__item">
                                                <span class="caption">@lang('Post Balance')</span>
                                                <span class="value"> {{ showAmount($trx->post_balance) }}</span>
                                            </li>
                                            <li class="caption-list__item">
                                                <span class="caption">@lang('Details')</span>
                                                <span class="value">{{ __($trx->details) }}</span>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($transactions->hasPages())
                        <div class="mt-5">
                            {{ paginateLinks($transactions) }}
                        </div>
                    @endif
                </div>
            @else
                @include($activeTemplate . 'partials.empty', ['message' => 'Transaction not found!'])
            @endif
        </div>
    </div>
@endsection

@push('style-lib')
    <link href="{{ asset('assets/global/css/datepicker.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/datepicker.en.js') }}"></script>
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.select2').select2();

            if (!$('.datepicker-here').val()) {
                $('.datepicker-here').datepicker();
            }

            $('[name=trx_type], [name=remark]').on('change', function() {
                $('.form').submit();
            })
        })(jQuery)
    </script>
@endpush

@push('style')
    <style>
        .select2-container .select2-selection--single .select2-selection__rendered {
            font-size: 14px !important;
            padding-left: 0 !important;
            line-height: 1 !important;
        }

        .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            padding: 0 !important;
            height: auto !important;
            border: 0;
        }

        .select2-container:has(.select2-selection--single, .select2-selection--multiple) {
            height: 21px;
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 0px !important;
            width: auto !important;
            ;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow:after {
            right: 0 !important;
            top: -3px !important;
        }
    </style>
@endpush
