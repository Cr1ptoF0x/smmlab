@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
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
                                <input type="search" name="search" value="{{ request()->search }}" class="form-control"
                                       placeholder="@Lang('Search by name')">
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
                                <label>@lang('Dripfeed')</label>
                                <select class="form-control select2" data-minimum-results-for-search="-1" name="dripfeed">
                                    <option value="" @selected(request()->dripfeed === null)>@lang('All')</option>
                                    <option value="1" @selected(request()->dripfeed == 1)>@lang('Yes')</option>
                                    <option value="0" @selected(request()->dripfeed === '0')>@lang('No')</option>
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

            <div id="bulkActionContainer" class="d-none mb-3 text-end d-flex justify-content-end gap-2 align-items-end flex-wrap">
                <span class="bulk-count">
                    <span class="count-number" id="selectedCount">0</span> @lang('item selected')
                </span>

                <button class="btn btn-sm btn-outline--warning" id="bulkAction" data-bs-toggle="dropdown">
                    <i class="las la-ellipsis-v"></i>
                    @lang('Bulk Action')
                </button>
                <div class="dropdown-menu p-0">
                    <button class="dropdown-item bulkBtn" data-type="enable" data-question="@lang('Are you sure to enable all the selected services?')">
                        <i class="lar la-check-square"></i>
                        @lang('Enable')
                    </button>
                    <button class="dropdown-item bulkBtn" data-type="disable" data-question="@lang('Are you sure to disable all the selected services?')">
                        <i class="lar la-times-circle"></i>
                        @lang('Disable')
                    </button>
                    <button class="dropdown-item bulkBtn" data-type="price" data-question="@lang('Are you sure to increase price of all the selected services according to below percentage?')">
                        <i class="las la-dollar-sign"></i>
                        @lang('Price Update')
                    </button>
                </div>
            </div>

            <div class="card">
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
                                    <th class="second-child">@lang('Name')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Price Per 1k')</th>
                                    <th>@lang('Min / Max')</th>
                                    <th>@lang('API Service ID')</th>
                                    <th>@lang('Dripfeed')</th>
                                    <th>@lang('Refill')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($services as $service)
                                    <tr>
                                        <td>
                                            <input class="childCheckBox" name="checkbox_id" data-id="{{ $service->id }}"
                                                   type="checkbox">
                                        </td>
                                        <td class="break_line second-child"
                                            @if (@$service->provider->short_name) data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Service Provider: {{ __(@$service->provider->short_name) }}" @endif>
                                            {{ __(@$service->name) }}
                                        </td>
                                        <td class="break_line">{{ __(@$service->category->name) }}</td>
                                        <td>
                                            <strong>{{ showAmount(@$service->price_per_k) }}</strong>
                                            <br>
                                            @if ($service->provider)
                                                {{ showAmount(@$service->original_price) }} (@lang('Provider'))
                                            @else
                                                @lang('N/A')
                                            @endif
                                        </td>
                                        <td>{{ @$service->min }} / {{ @$service->max }}</td>
                                        <td>
                                            @if ($service->api_service_id)
                                                {{ @$service->api_service_id }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if (@$service->dripfeed == Status::YES)
                                                <span class="badge badge--success"> @lang('Yes')</span>
                                            @else
                                                <span class="badge badge--warning">@lang('No')</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (@$service->refill == Status::YES)
                                                <span class="badge badge--success"> @lang('Yes')</span>
                                            @else
                                                <span class="badge badge--warning">@lang('No')</span>
                                            @endif
                                        </td>
                                        <td> @php echo $service->statusBadge; @endphp </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline--info" id="bulkAction"
                                                    data-bs-toggle="dropdown">
                                                <i class="las la-ellipsis-v"></i>
                                                @lang('Action')
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                   href="{{ route('admin.service.edit', $service->id) }}">
                                                    <i class="la la-pen"></i> @lang('Edit')
                                                </a>
                                                @if ($service->status == Status::DISABLE)
                                                    <button class="dropdown-item confirmationBtn"
                                                            data-action="{{ route('admin.service.status', $service->id) }}"
                                                            data-question="@lang('Are you sure to enable this service?')">
                                                        <i class="la la-eye"></i> @lang('Enable')
                                                    </button>
                                                @else
                                                    <button class="dropdown-item confirmationBtn"
                                                            data-action="{{ route('admin.service.status', $service->id) }}"
                                                            data-question="@lang('Are you sure to disable this service?')">
                                                        <i class="la la-eye-slash"></i> @lang('Disable')
                                                    </button>
                                                @endif
                                            </div>
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
                @if ($services->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($services) }}
                    </div>
                @endif
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
                <form action="{{ route('admin.service.bulk.action') }}" method="POST">
                    @csrf
                    <input type="hidden" name="ids">
                    <input type="hidden" name="type">
                    <div class="modal-body">
                        <p class="question"></p>
                        <div class="form-group d-none price mt-2">
                            <label>@lang('Increase Price')</label>
                            <div class="input-group mb-3">
                                <input type="number" name="price_increase" step="any" class="form-control" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addNewModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle">@lang('Add New')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="la la-times" aria-hidden="true"></i>
                    </button>
                </div>

                <div class="modal-body p-4" id="mainModalContent">
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-4 col-sm-6">
                            <a href="{{ route('admin.service.add') }}" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                                    <div class="card-body text-center p-4">
                                        <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle mx-auto mb-3 p-3">
                                            <i class="las la-briefcase text-primary fs-3"></i>
                                        </div>
                                        <h6 class="card-title mb-0 text-dark">@lang('Add New Service')</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="dropdown h-100">
                                <div class="card h-100 border-0 shadow-sm hover-shadow transition-all dropdown-toggle"
                                     role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="card-body text-center p-4">
                                        <div class="icon-wrapper bg-info bg-opacity-10 rounded-circle mx-auto mb-3 p-3">
                                            <i class="las la-cloud-download-alt text-info fs-3"></i>
                                        </div>
                                        <h6 class="card-title mb-0 text-dark">@lang('API Services')</h6>
                                    </div>
                                </div>

                                <ul class="dropdown-menu modal-dropdown">
                                    @foreach ($apiLists as $apiList)
                                        <li>
                                            <a class="dropdown-item py-2 px-3 border-bottom"
                                               href="{{ route('admin.service.api', $apiList->id) }}">
                                                <i class="las la-server me-2"></i>{{ __($apiList->name) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm hover-shadow transition-all" id="importBtn"
                                 role="button">
                                <div class="card-body text-center p-4">
                                    <div class="icon-wrapper bg-success bg-opacity-10 rounded-circle mx-auto mb-3 p-3">
                                        <i class="las la-file-import text-success fs-3"></i>
                                    </div>
                                    <h6 class="card-title mb-0 text-dark">@lang('Import')</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-body p-4 d-none" id="importModalContent">
                    <form method="post" action="{{ route('admin.service.import') }}" id="importForm"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="alert alert-warning p-3" role="alert">
                                <p>
                                    @lang('The file you wish to upload has to be formatted as we provided template files. Any changes to these files will be considered as an invalid file format. Download links are provided below.')
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
                                    <b class="fw-bold">@lang('csv, excel')</b>
                                </small>
                                <small>
                                    @lang('Download all of the template files from here')
                                    <a href="{{ asset('/assets/admin/file_template/sample.csv') }}" title=""
                                       class="text--primary" download="" data-bs-original-title="Download csv file"
                                       target="_blank">
                                        <b>@lang('csv'),</b>
                                    </a>
                                    <a href="{{ asset('/assets/admin/file_template/sample.xlsx') }}" title=""
                                       class="text--primary" download="" data-bs-original-title="Download excel file"
                                       target="_blank">
                                        <b>@lang('excel')</b>
                                    </a>
                                </small>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary" id="backBtn">
                                <i class="las la-arrow-left me-1"></i>@lang('Back')
                            </button>
                            <button type="submit" class="btn btn--primary">@lang('Upload')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-outline--primary btn-sm addModalBtn">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush

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

            $('.addModalBtn').on('click', function() {
                $('#addNewModal').modal('show');
            });

            $('#importBtn').on('click', function() {
                $('#modalTitle').text('@lang('Import New Services')');
                $('#mainModalContent').addClass('d-none');
                $('#importModalContent').removeClass('d-none');
            });

            $('#backBtn').on('click', function() {
                $('#modalTitle').text('@lang('Add New')');
                $('#mainModalContent').removeClass('d-none');
                $('#importModalContent').addClass('d-none');
            });

            $('#addNewModal').on('hidden.bs.modal', function() {
                $('#modalTitle').text('@lang('Add New')');
                $('#mainModalContent').removeClass('d-none');
                $('#importModalContent').addClass('d-none');
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
                if ($(this).data('type') == 'price') {
                    $('.price').removeClass('d-none');
                    bulkModal.find('.question').html(`<div class="card bl--5 border--primary mb-3 modal--card">
                        <div class="card-body">
                            <p class="text--primary">
                                ${question} You have selected a total of ${checkBox.length} services for the price update.
                            </p>
                        </div>
                    </div>`);
                } else {
                    $('.price').addClass('d-none');
                    bulkModal.find('.question').text(question);
                }
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

@push('style')
    <style>
        .modal--card {
            background: #4634ff14 !important;
        }

        .second-child {
            text-align: left !important;
        }

        .dropdown-toggle::after {
            border-top: none;
        }

        .icon-wrapper {
            width: 100px;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @media (max-width: 991px) {
            .icon-wrapper {
                width: 70px;
                height: 70px;
            }
        }

        .modal-dropdown {
            background: #fff;
            max-height: 200px;
            overflow-y: scroll;
            box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.1);
            padding: 0;
        }

        .modal-dropdown::-webkit-scrollbar {
            width: 8px;
        }

        .modal-dropdown::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .modal-dropdown::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 4px;
            border: 2px solid #f1f1f1;
        }

        @media (min-width:1200px) {
            .table-responsive--lg.table-responsive .table {
                min-width: 1400px;
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
    </style>
@endpush
