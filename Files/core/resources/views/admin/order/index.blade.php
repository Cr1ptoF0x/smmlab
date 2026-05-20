@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            @if (request()->routeIs('admin.orders.index'))
                <div class="show-filter mb-3 text-end">
                    <button type="button" class="btn btn-outline--primary showFilterBtn btn-sm"><i class="las la-filter"></i>
                        @lang('Filter')</button>
                </div>
                <div class="card responsive-filter-card mb-4">
                    <div class="card-body">
                        <form>
                            <div class="d-flex flex-wrap gap-4">
                                <div class="flex-grow-1">
                                    <label>@lang('Search')</label>
                                    <input type="search" name="search" value="{{ request()->search }}"
                                        class="form-control" placeholder="@Lang('Username / Order Id')">
                                </div>
                                <div class="flex-grow-1">
                                    <label>@lang('Category')</label>
                                    <select name="category_id" class="form-control select2">
                                        <option value="">@lang('All')</option>
                                        @foreach ($categories ?? [] as $category)
                                            <option value="{{ $category->id }}" @selected(request()->category_id == $category->id)>
                                                {{ __($category->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex-grow-1">
                                    <label>@lang('Api Provider')</label>
                                    <select class="form-control select2" name="api_provider_id">
                                        <option value="">@lang('All')</option>
                                        @foreach ($apiLists ?? [] as $provider)
                                            <option value="{{ $provider->id }}" @selected(request()->api_provider_id == $provider->id)>
                                                {{ __($provider->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex-grow-1">
                                    <label>@lang('Refill')</label>
                                    <select class="form-control select2" data-minimum-results-for-search="-1"
                                        name="refill">
                                        <option value="" @selected(request()->refill === null)>@lang('All')</option>
                                        <option value="1" @selected(request()->refill == 1)>@lang('Yes')</option>
                                        <option value="0" @selected(request()->refill === '0')>@lang('No')</option>
                                    </select>
                                </div>
                                <div class="flex-grow-1">
                                    <label>@lang('Date')</label>
                                    <input name="date" type="search"
                                        class="datepicker-here form-control bg--white pe-2 date-range"
                                        placeholder="@lang('Start Date - End Date')" autocomplete="off" value="{{ request()->date }}">
                                </div>
                                <div class="flex-grow-1 align-self-end">
                                    <button class="btn btn--primary w-100 h-45"><i class="fas fa-filter"></i>
                                        @lang('Filter')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <div id="bulkActionContainer"
                class="d-none mb-3 text-end d-flex justify-content-end gap-2 align-items-end flex-wrap">
                <span class="bulk-count">
                    <span class="count-number" id="selectedCount">0</span> @lang('item selected')
                </span>


                <button class="btn btn-sm btn-outline--warning" id="bulkAction" data-bs-toggle="dropdown">
                    <i class="las la-ellipsis-v"></i>
                    @lang('Change Status')
                </button>
                <div class="dropdown-menu p-0">
                    <button class="dropdown-item bulkBtn" data-type="processing" data-question="@lang('Are you sure to processing all the selected orders?')">
                        <i class="las la-spinner"></i>
                        @lang('Processing')
                    </button>
                    <button class="dropdown-item bulkBtn" data-type="completed" data-question="@lang('Are you sure to completed all the selected orders?')">
                        <i class="las la-check-circle"></i>
                        @lang('Completed')
                    </button>
                    <button class="dropdown-item bulkBtn" data-type="cancel" data-question="@lang('Are you sure to cancel all the selected orders?')">
                        <i class="las la-times-circle"></i>
                        @lang('Cancel')
                    </button>
                </div>
            </div>

            <div class="card b-radius--10 mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive--lg table-responsive">
                        <table class="table table--light tabstyle--two">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="m-0 selectAll">
                                            <i class="th-check-all fa fa-stop"></i>
                                        </label>
                                    </th>
                                    <th>@lang('Order ID')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Service')</th>
                                    <th>@lang('Quantity')</th>
                                    <th>@lang('Start Counter')</th>
                                    <th>@lang('Remains')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('API Order')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>
                                            <input class="childCheckBox" name="checkbox_id" data-id="{{ $order->id }}"
                                                type="checkbox">
                                        </td>
                                        <td>{{ $order->id }}</td>
                                        <td>
                                            <span class="d-block">{{ __(@$order->user->fullname) }}</span>
                                            <a href="{{ route('admin.users.detail', $order->user_id) }}">
                                                <span>@</span>{{ __(@$order->user->username) }}
                                            </a>
                                        </td>
                                        <td class="break_line">{{ __(@$order->category->name) }}</td>
                                        <td class="break_line">
                                            {{ __(@$order->service->name) }}
                                            @if (@$order->service->provider->short_name)
                                                <span class="badge badge--primary">
                                                    {{ __(@$order->service->provider->short_name) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $order->quantity }}</td>
                                        <td>{{ $order->start_counter }}</td>
                                        <td>{{ $order->remain }}</td>
                                        <td>
                                            @if ($order->status == Status::ORDER_PENDING)
                                                <span class="badge badge--warning">@lang('Pending')</span>
                                            @elseif($order->status == Status::ORDER_PROCESSING)
                                                <span class="badge badge--primary">@lang('Processing')</span>
                                            @elseif($order->status == Status::ORDER_COMPLETED)
                                                <span class="badge badge--success">@lang('Completed')</span>
                                            @elseif($order->status == Status::ORDER_CANCELLED)
                                                <span class="badge badge--danger">@lang('Cancelled')</span>
                                            @else
                                                <span class="badge badge--dark">@lang('Refunded')</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($order->api_order)
                                                <span class="badge  badge--primary">@lang('Yes')</span>
                                            @else
                                                <span class="badge  badge--warning">@lang('No')</span>
                                            @endif
                                        </td>
                                        <td>{{ showDateTime($order->created_at) }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-outline--primary"
                                                href="{{ route('admin.orders.details', $order->id) }}">
                                                <i class="la la-desktop"></i>
                                                @lang('Details')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($orders->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($orders) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if (request()->routeIs('admin.orders.processing'))
        <x-confirmation-modal />
    @endif

    <div class="modal fade" id="importModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Import Modified Orders')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="la la-times" aria-hidden="true"></i>
                    </button>
                </div>
                <form method="post" action="{{ route('admin.orders.import') }}" id="importForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="alert alert-warning p-3" role="alert">
                                <p>
                                    @lang('Adjusting the Start Counter in the Excel sheet will auto-calculate the Remain value based on the quantity. Make sure your file matches the exported template exactly—any changes to its structure may cause an import error.')
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="fw-bold required" for="file">@lang('Select File')</label>
                            <input type="file" class="form-control" name="file" accept=".txt,.csv,.xlsx"
                                id="file">
                            <div class="mt-1">
                                <small class="d-block">
                                    @lang('Supported files:')
                                    <b class="fw-bold">@lang('.xlsx')</b>
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn--primary w-100 h-45">@lang('Upload')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exportModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Export Orders')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="la la-times" aria-hidden="true"></i>
                    </button>
                </div>
                <form method="post" action="{{ route('admin.orders.export', @$scope) }}" id="exportForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <div class="radio-btn-wrapper">
                                <label class="radio-btn-card p-3 flex-fill text-center border form-check position-relative"
                                    style="cursor: pointer;">
                                    <input class="form-check-input position-absolute top-0 end-0 m-2" type="radio"
                                        name="export_type" id="exportAll" value="all" checked>
                                    <div class="radio-icon">
                                        <i class="fas fa-database"></i>
                                    </div>
                                    <div class="form-check-label fw-semibold">
                                        @lang('Export All Data')
                                    </div>
                                </label>

                                <label class="radio-btn-card p-3 flex-fill text-center border form-check position-relative"
                                    style="cursor: pointer;">
                                    <input class="form-check-input position-absolute top-0 end-0 m-2" type="radio"
                                        name="export_type" id="exportLimit" value="limit">
                                    <div class="radio-icon">
                                        <i class="fas fa-filter"></i>
                                    </div>
                                    <div class="form-check-label fw-semibold">
                                        @lang('Export Limited Data')
                                    </div>
                                </label>
                            </div>
                            <div class="form-group my-3 limit-input d-none">
                                <label for="limitCount">@lang('Number of Orders')</label>
                                <input type="number" class="form-control" id="limitCount" name="limit"
                                    min="1">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="Submit" class="btn btn--primary w-100 h-45"
                            id="submitExport">@lang('Export')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="bulkModal" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation Alert!')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.orders.bulk.action') }}" method="POST">
                    @csrf
                    <input type="hidden" name="ids">
                    <input type="hidden" name="type">
                    <div class="modal-body">
                        <p class="question"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark btn-sm"
                            data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn-primary btn-sm">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('breadcrumb-plugins')
    @if (!request()->routeIs('admin.orders.index'))
        <x-search-form placeholder="Search here..." />
    @endif
    @if (request()->routeIs('admin.orders.processing'))
        <button class="btn btn-outline--primary confirmationBtn" data-question="@lang('Are you sure to update orders information from Provider?')"
            data-action="{{ route('admin.orders.provider.information.update') }}">
            <i class="far fa-edit"></i> @lang('Update Provider Information')
        </button>
    @endif

    <div class="d-flex justify-content-end gap-2">
        <button class="btn btn-sm btn-outline--primary exportBtn" type="button"><i
                class="las la-arrow-down"></i>@lang('Export')</button>

        <button type="button" class="btn btn-outline--info btn-sm importBtn" type="button">
            <i class="las la-cloud-upload-alt"></i> @lang('Import')
        </button>
    </div>
@endpush

@if (request()->routeIs('admin.orders.index'))
    @push('script-lib')
        <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
        <script src="{{ asset('assets/admin/js/daterangepicker.min.js') }}"></script>
    @endpush

    @push('style-lib')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/daterangepicker.css') }}">
    @endpush

    @push('script')
        <script>
            (function($) {
                "use strict"

                const datePicker = $('.date-range').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear'
                    },
                    showDropdowns: true,
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 15 Days': [moment().subtract(14, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                            .endOf('month')
                        ],
                        'Last 6 Months': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')],
                        'This Year': [moment().startOf('year'), moment().endOf('year')],
                    },
                    maxDate: moment()
                });
                const changeDatePickerText = (event, startDate, endDate) => {
                    $(event.target).val(startDate.format('MMMM DD, YYYY') + ' - ' + endDate.format('MMMM DD, YYYY'));
                }

                $('.date-range').on('apply.daterangepicker', (event, picker) => changeDatePickerText(event, picker
                    .startDate, picker.endDate));

                if ($('.date-range').val()) {
                    let dateRange = $('.date-range').val().split(' - ');
                    $('.date-range').data('daterangepicker').setStartDate(new Date(dateRange[0]));
                    $('.date-range').data('daterangepicker').setEndDate(new Date(dateRange[1]));
                }
            })(jQuery)
        </script>
    @endpush
@endif

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.importBtn').on('click', function() {
                var modal = $('#importModal');
                $('#importModal').modal('show');
            });


            $('.exportBtn').on('click', function() {
                var modal = $('#exportModal');
                const form = $('#exportForm')[0];
                form.reset();
                $('.limit-input').addClass('d-none');
                $('#exportModal').modal('show');
            });

            $('input[name="export_type"]').on('change', function() {
                if ($(this).val() === 'limit') {
                    $('.limit-input').removeClass('d-none');
                } else {
                    $('.limit-input').addClass('d-none');
                }
            });

            $('#submitExport').on('click', function() {
                const form = $('#exportForm');
                const exportType = $('input[name="export_type"]:checked').val();

                if (exportType === 'all') {
                    form.find('input[name="limit"]').val('');
                }

                $('#exportModal').modal('hide');

                form.submit();
            });


            let ids = [];
            let checkBox = [];

            let selectedCount = $('#selectedCount');
            let bulkContainer = $('#bulkActionContainer');

            function updateBulkUI() {
                let totalSelected = $('input:checkbox[name=checkbox_id]:checked').length;
                selectedCount.text(totalSelected);

                if (totalSelected > 0) {
                    bulkContainer.removeClass('d-none');
                } else {
                    bulkContainer.addClass('d-none');
                }
            }

            $('.selectAll').on('click', function() {
                var isChecked = $(this).find('.th-check-all').hasClass('fa-stop');
                $('.childCheckBox').prop('checked', isChecked);
                $(this).find('.th-check-all').toggleClass('fa-stop fa-check');
                updateBulkUI();
            });

            $('.childCheckBox').on('change', function() {
                updateBulkUI();
            });

            let bulkModal = $('#bulkModal');

            $('.bulkBtn').on('click', function() {
                checkBox = $('input:checkbox[name=checkbox_id]:checked');
                let question = $(this).data('question');

                if (checkBoxData()) {
                    bulkModal.find('[name=ids]').val(ids);
                    bulkModal.find('[name=type]').val($(this).data('type'));
                } else {
                    ids = [];
                    notify('error', `@lang('Before submitting select minimum one item.')`);
                    return false;
                }

                $('.price').addClass('d-none');
                bulkModal.find('.question').text(question);

                bulkModal.modal('show');
            });

            $('.childCheckBox').on('click', function() {
                if (!$('.selectAll').find('.th-check-all').hasClass('fa-stop')) {
                    $('.selectAll').find('.th-check-all').toggleClass('fa-stop fa-check');
                }
            });

            function checkBoxData() {
                checkBox = $('input:checkbox[name=checkbox_id]:checked');
                if (checkBox.length) {
                    checkBox.each(function() {
                        ids.push($(this).data('id'));
                    })
                    return true;
                } else {
                    return false;
                }
            }

        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        @media (min-width:1200px) {
            .table-responsive--lg.table-responsive .table {
                min-width: 1400px;
            }

            .break_line {
                min-width: 200px;
            }
        }

        .bulk-count {
            background: #1e9ff24d !important;
            padding: 4px 8px;
            border-radius: 4px;
            color: #0093f1 !important;
            position: relative;
            padding-left: 35px;
        }

        .bulk-count::after {
            position: absolute;
            content: '\f00c';
            font-family: 'Font Awesome 5 Free';
            font-weight: 700;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);

            border-radius: 50%;
            color: #0093f1;
        }

        .count-number {
            color: #0093f1 !important;
        }



        .radio-btn-card {
            position: relative !important;
            z-index: 1;
            border-radius: 4px;
            padding: 15px !important;
        }

        @media (max-width: 373px) {
            .radio-btn-card {
                padding: 8px !important;
            }
        }

        .radio-btn-wrapper {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(118px, 1fr));
            gap: 10px;
        }

        .radio-btn-card .form-check-input {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: none;
            border: 0;
            border-radius: 0;
            top: 0 !important;
            left: 0;
            float: unset;
            background-size: cover;
            margin: 0 !important;
            z-index: -1;
            border-radius: 4px;
        }

        .radio-icon {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .radio-btn-card .form-check-input:checked[type=radio] {
            --color: #4634ff;
            background-image: none;
            background-color: var(--color) !important;
            border: 1px solid var(--color) !important;
            color: var(--btn-color) !important;
        }

        .radio-btn-card .form-check-input:focus {
            box-shadow: none !important;
        }


        .radio-btn-card:has(.form-check-input:checked[type=radio]) .form-check-label {
            color: #fff !important;
        }

        .radio-btn-card:has(.form-check-input:checked[type=radio]) .radio-icon {
            color: #fff !important;
        }
    </style>
@endpush
