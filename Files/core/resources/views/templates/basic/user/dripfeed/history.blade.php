@extends($activeTemplate . 'layouts.master')
@php
    $request = request();
@endphp
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="filter-area mb-3">
                <form class="form" action="">
                    <div class="d-flex flex-wrap gap-4">
                        <div class="flex-grow-1">
                            <div class="custom-input-box trx-search">
                                <label class="form--label">@lang('Service Name')</label>
                                <input name="search" type="search" value="{{ $request->search }}" placeholder="@lang('Service')">
                                <button class="icon-area" type="submit">
                                    <i class="las la-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="custom-input-box trx-search">
                                <label class="form--label">@lang('Date')</label>
                                <input class="datepicker-here" name="date" data-range="true" data-multiple-dates-separator=" - " data-language="en" data-format="Y-m-d" data-position='bottom right' type="search" value="{{ $request->date }}" placeholder="@lang('Start Date - End Date')" autocomplete="off">
                                <button class="icon-area" type="submit">
                                    <i class="las la-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="custom-input-box">
                                <label class="form--label">@lang('Category')</label>
                                <select name="category_id">
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
                    @include($activeTemplate . 'partials.empty', ['message' => ucfirst(strtolower($pageTitle)) . ' not found!'])
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
    </style>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/global/css/vendor/datepicker.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/vendor/datepicker.en.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict';
        $(document).ready(function() {

            if (!$('.datepicker-here').val()) {
                $('.datepicker-here').datepicker();
            }

            $('[name=category_id], [name=status]').on('change', function() {
                $('.form').submit();
            })
        });
    </script>
@endpush
