@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="filter-area mb-3">
                <form class="form" action="">
                    <div class="d-flex flex-wrap gap-4">
                        <div class="flex-grow-1">
                            <div class="custom-input-box trx-search">
                                <label>@lang('Trx Number')</label>
                                <input name="search" type="text" value="{{ request()->search }}"
                                    placeholder="@lang('Trx Number')">
                                <button class="icon-area" type="submit">
                                    <i class="las la-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="custom-input-box trx-search">
                                <label>@lang('Date')</label>
                                <input class="datepicker-here " name="date" data-range="true"
                                    data-multiple-dates-separator=" - " data-language="en" data-format="Y-m-d"
                                    data-position='bottom right' value="{{ request()->date }}"
                                    placeholder="@lang('Start Date - End Date')" autocomplete="off">
                                <button class="icon-area" type="submit">
                                    <i class="las la-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="custom-input-box">
                                <label>@lang('Currency')</label>
                                <select name="method_currency" class="select2">
                                    <option value="">@lang('All')</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency }}" @selected(request()->method_currency == $currency)>
                                            {{ __($currency) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="custom-input-box">
                                <label>@lang('Gateway')</label>
                                <select name="method_code" class="select2">
                                    <option value="">@lang('All')</option>
                                    @foreach ($gateways as $data)
                                        <option value="{{ @$data->method_code }}" @selected(request()->method_code == @$data->method_code)>
                                            {{ __(@$data->gateway->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="custom-input-box">
                                <label>@lang('Status')</label>
                                <select name="status" class="select2">
                                    <option value="">@lang('All')</option>
                                    <option value="initiated" @selected(request()->status == 'initiated')>@lang('Initiated')</option>
                                    <option value="successful" @selected(request()->status == 'successful')>@lang('Succeed')</option>
                                    <option value="rejected" @selected(request()->status == 'rejected')>@lang('Canceled')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12">
            @if (!blank($deposits))
                <div class="dashboard-accordion-table mt-5">
                    <div class="accordion table--acordion" id="transactionAccordion">
                        @forelse($deposits as $deposit)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="h-{{ $loop->index }}">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#c-{{ $loop->index }}" type="button" aria-expanded="false"
                                        aria-controls="c-{{ $loop->index }}">
                                        <div class="col-xl-4 col-sm-5 col-8 order-1">
                                            <div class="left">
                                                <div
                                                    class="icon
                                                 @if ($deposit->status == Status::PAYMENT_PENDING) warning
                                                 @elseif($deposit->status == Status::PAYMENT_SUCCESS && $deposit->method_code >= 1000) success
                                                 @elseif($deposit->status == Status::PAYMENT_SUCCESS && $deposit->method_code < 1000) success
                                                 @elseif($deposit->status == Status::PAYMENT_REJECT) danger
                                                 @else dark @endif">
                                                    @if ($deposit->status == Status::PAYMENT_PENDING)
                                                        <i class="las la-spinner"></i>
                                                    @elseif($deposit->status == Status::PAYMENT_SUCCESS && $deposit->method_code >= 1000)
                                                        <i class="las la-check"></i>
                                                    @elseif($deposit->status == Status::PAYMENT_SUCCESS && $deposit->method_code < 1000)
                                                        <i class="las la-check"></i>
                                                    @elseif($deposit->status == Status::PAYMENT_REJECT)
                                                        <i class="las la-times"></i>
                                                    @else
                                                        <i class="las la-exchange-alt"></i>
                                                    @endif
                                                </div>
                                                <div class="content">
                                                    <h6 class="title mb-0">{{ __($deposit->gateway?->name) }}</h6>
                                                    <span class="date-time">
                                                        {{ showDateTime($deposit->created_at) }}<br>{{ diffForHumans($deposit->created_at) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-sm-4 col-12 order-sm-2 order-3 transaction-wrapper">
                                            <p class="transaction-id">{{ $deposit->trx }}</p>
                                        </div>
                                        <div class="col-xl-4 col-sm-3 col-4 order-sm-3 order-2 text-end amount-wrapper">
                                            <p class="amount">{{ showAmount($deposit->amount) }}</p>
                                        </div>
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" id="c-{{ $loop->index }}"
                                    data-bs-parent="#transactionAccordion" aria-labelledby="h-{{ $loop->index }}">
                                    <div class="accordion-body">
                                        <ul class="caption-list">
                                            <li class="caption-list__item">
                                                <span class="caption">@lang('Conversion')</span>
                                                <span class="value">1 {{ __(gs('cur_text')) }} =
                                                    {{ showAmount($deposit->rate) }}
                                                    {{ __($deposit->method_currency) }}
                                                    <br>
                                                    <strong>{{ showAmount($deposit->final_amount) }}
                                                        {{ __($deposit->method_currency) }}</strong></span>
                                            </li>
                                            <li class="caption-list__item">
                                                <span class="caption">@lang('Status')</span>
                                                <span class="value"> @php echo $deposit->statusBadge @endphp</span>
                                            </li>
                                            <li class="caption-list__item">
                                                <span class="caption">@lang('Action')</span>
                                                @php
                                                    $details =
                                                        $deposit->detail != null ? json_encode($deposit->detail) : null;
                                                @endphp
                                                <span class="value" title="@lang('Details')">
                                                    <button
                                                        class="action-btn edit-btn @if ($deposit->method_code >= 1000) detailBtn @else disabled @endif"
                                                        @if ($deposit->method_code >= 1000) data-info="{{ $details }}" @endif
                                                        @if ($deposit->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $deposit->admin_feedback }}" @endif>
                                                        <span class="icon"><i class="las la-desktop"></i></span>
                                                    </button>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($deposits->hasPages())
                        <div class="mt-5">
                            {{ paginateLinks($deposits) }}
                        </div>
                    @endif
                </div>
            @else
                @include($activeTemplate . 'partials.empty', ['message' => 'Deposit not found!'])
            @endif

        </div>
    </div>

    {{-- Details MODAL --}}
    <div class="dashboard-modal modal" id="detailModal" aria-labelledby="exampleModalLabel" aria-hidden="true"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Details')</h5>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group userData mb-2"> </ul>
                    <p class="feedback"></p>
                </div>
                <div class="modal-footer text-end">
                    <button class="btn btn--dark" data-bs-dismiss="modal" type="button">@lang('Close')</button>
                </div>
            </div>
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

            $('[name=method_currency], [name=method_code], [name=status]').on('change', function() {
                $('.form').submit();
            })

            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');

                var userData = $(this).data('info');
                var html = '';
                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                        }
                    });
                }

                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                    `;
                } else {
                    var adminFeedback = '';
                }
                modal.find('.feedback').html(adminFeedback);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .deposit-header {
            column-gap: 15px;
            row-gap: 10px;
        }

        .deposit-header button.btn {
            background: hsl(var(--base)) !important;
        }

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
