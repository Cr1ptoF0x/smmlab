@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row mb-none-30">
        <div class="col-12">
            <div class="show-filter mb-3 text-end">
                <button type="button" class="btn btn--base showFilterBtn btn-sm">
                    <i class="las la-filter"></i>
                    @lang('Filter')
                </button>
            </div>
            <div class="card responsive-filter-card mb-4">
                <div class="card-body">
                    <form>
                        <div class="d-flex flex-wrap gap-4">
                            <div class="flex-grow-1">
                                <label class="form-label">@lang('Transaction Number')</label>
                                <input type="search" name="search" value="{{ request()->search }}"
                                    class="form-control form--control">
                            </div>
                            <div class="flex-grow-1 select2-parent">
                                <label class="form-label d-block">@lang('Type')</label>
                                <select name="trx_type" class="form-select form--control select2"
                                    data-minimum-results-for-search="-1">
                                    <option value="">@lang('All')</option>
                                    <option value="+" @selected(request()->trx_type == '+')>@lang('Plus')</option>
                                    <option value="-" @selected(request()->trx_type == '-')>@lang('Minus')</option>
                                </select>
                            </div>
                            <div class="flex-grow-1 select2-parent">
                                <label class="form-label d-block">@lang('Remark')</label>
                                <select class="form-select form--control select2" data-minimum-results-for-search="-1"
                                    name="remark">
                                    <option value="">@lang('All')</option>
                                    @foreach ($remarks as $remark)
                                        <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>
                                            {{ __(keyToTitle($remark->remark)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--base w-100 filter-btn"><i class="las la-filter"></i>
                                    @lang('Filter')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12">
            @if (!blank($transactions))
                <div class="dashboard-accordion-table mt-5">
                    <div class="accordion table--acordion" id="transactionAccordion">
                        @forelse($transactions as $trx)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="h-{{ $loop->index }}">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#c-{{ $loop->index }}" type="button" aria-expanded="false"
                                        aria-controls="c-{{ $loop->index }}">
                                        <div class="col-xl-4 col-sm-5 col-8 order-1">
                                            <div class="left">
                                                <div
                                                    class="icon @if ($trx->trx_type == '+') rcv-item success @else sent-item danger @endif">
                                                    @if ($trx->trx_type == '+')
                                                        <i class="las la-long-arrow-alt-right"></i>
                                                    @else
                                                        <i class="las la-long-arrow-alt-left"></i>
                                                    @endif
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb-0"> {{ __(keyToTitle($trx->remark)) }}</h6>
                                                    <span class="date-time">
                                                        {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}</span>
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
                                <div class="accordion-collapse collapse" id="c-{{ $loop->index }}"
                                    data-bs-parent="#transactionAccordion" aria-labelledby="h-{{ $loop->index }}">
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
        .filter-btn {
            padding: 12px 25px !important;
            line-height: 1.25;
            background-color: hsl(var(--base));
        }
        .filter-btn:hover, .filter-btn:focus, .filter-btn:active {
            padding: 12px 25px;
            line-height: 1.25;
            background-color: hsl(var(--base));
        }
    </style>
@endpush
