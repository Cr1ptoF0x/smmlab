@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="filter-area mb-3">
                <form class="form" action="">
                    <div class="d-flex flex-wrap gap-4">
                        <div class="flex-grow-1">
                            <div class="custom-input-box trx-search">
                                <label class="form--label">@lang('Service Name')</label>
                                <input name="search" type="search" value="{{ request()->search }}"
                                    placeholder="@lang('Service')">
                                <button class="icon-area" type="submit">
                                    <i class="las la-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="custom-input-box trx-search">
                                <label class="form--label">@lang('Date')</label>
                                <input class="datepicker-here" name="date" data-range="true"
                                    data-multiple-dates-separator=" - " data-language="en" data-format="Y-m-d"
                                    data-position='bottom right' type="search" value="{{ request()->date }}"
                                    placeholder="@lang('Start Date - End Date')" autocomplete="off">
                                <button class="icon-area" type="submit">
                                    <i class="las la-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="custom-input-box">
                                <label class="form--label">@lang('Category')</label>
                                <select name="category_id" class="select2">
                                    <option value="">@lang('All')</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(request()->category_id == $category->id)>
                                            {{ strLimit(__($category->name), 46) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="col-12">
            <div class="dashboard-table">
                @if (!blank($orders))
                    @include(@$activeTemplate . 'partials.order_list')

                    @if ($orders->hasPages())
                        {{ paginateLinks($orders) }}
                    @endif
                @else
                    @include($activeTemplate . 'partials.empty', [
                        'message' => ucfirst(strtolower($pageTitle)) . ' not found!',
                    ])
                @endif
            </div>

        </div>
    </div>

@endsection

@push('style')
    <style>
        .break_line {
            white-space: initial !important;
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
        $(document).ready(function() {
            'use strict';

            $('.select2').select2();

            if (!$('.datepicker-here').val()) {
                $('.datepicker-here').datepicker();
            }

            $('[name=category_id], [name=status]').on('change', function() {
                $('.form').submit();
            })
        });
    </script>
@endpush
