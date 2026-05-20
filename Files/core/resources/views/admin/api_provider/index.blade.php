@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light tabstyle--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('API Name')</th>
                                    <th>@lang('Services')</th>
                                    <th>@lang('Balance')</th>
                                    <th>@lang('API Url')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($apiProviders as $apiProvider)
                                    <tr data-id="{{ $apiProvider->id }}">
                                        <td>
                                            {{ __($apiProvider->name) }} | <span
                                                  class="fw-bold" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Short Name') }}">{{ __($apiProvider->short_name) }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <a href="{{ route('admin.service.index') }}?api_provider_id={{ $apiProvider->id }}" class="fw-bold view-service" data-bs-toggle="tooltip"
                                                   data-bs-placement="top" title="{{ __('View services') }}">
                                                    {{ $apiProvider->services_count }}
                                                </a>

                                                <button class="syncServiceBtn text--primary"
                                                        data-action="{{ route('admin.api.provider.service.sync', $apiProvider->id) }}"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="{{ __('Sync services') }}">
                                                    <i class="fas fa-sync"></i>
                                                </button>
                                            </div>

                                        </td>
                                        <td>
                                            <span class="balance-text" data-bs-toggle="tooltip"
                                                  data-bs-placement="top" title="{{ __('Current balance') }}">
                                                {{ showAmount($apiProvider->balance, currencyFormat: false) }}
                                                {{ __($apiProvider->currency) }}
                                            </span>

                                            <button class="updateBalanceBtn text--primary fw-bold"
                                                    data-action="{{ route('admin.api.provider.balance.update', $apiProvider->id) }}"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="{{ __('Update balance') }}">
                                                <i class="fas fa-redo"></i>
                                            </button>
                                        </td>
                                        <td>{{ $apiProvider->api_url }}</td>
                                        <td> @php  echo $apiProvider->statusBadge; @endphp</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline--info" id="bulkAction"
                                                    data-bs-toggle="dropdown">
                                                <i class="las la-ellipsis-v"></i>
                                                @lang('Action')
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item updateApiSetting"
                                                        data-id="{{ $apiProvider->id }}"
                                                        data-api_key="{{ $apiProvider->api_key }}"
                                                        data-short_name="{{ $apiProvider->short_name }}"
                                                        data-price="{{ $apiProvider->price }}"
                                                        data-name="{{ $apiProvider->name }}"
                                                        data-api_url="{{ $apiProvider->api_url }}" type="button">
                                                    <i class="las la-pen"></i> @lang('Edit')
                                                </button>
                                                @if ($apiProvider->status == Status::DISABLE)
                                                    <button class="dropdown-item confirmationBtn"
                                                            data-action="{{ route('admin.api.provider.status', $apiProvider->id) }}"
                                                            data-question="@lang('Are you sure to enable this API?')" type="button">
                                                        <i class="la la-eye"></i> @lang('Enable')
                                                    </button>
                                                @else
                                                    <button class="dropdown-item confirmationBtn"
                                                            data-action="{{ route('admin.api.provider.status', $apiProvider->id) }}"
                                                            data-question="@lang('Are you sure to disable this API?')" type="button">
                                                        <i class="la la-eye-slash"></i> @lang('Disable')
                                                    </button>
                                                @endif
                                                <a href="{{ route('admin.service.index') }}?api_provider_id={{ $apiProvider->id }}"
                                                   class="dropdown-item" type="button">
                                                    <i class="las la-list"></i> @lang('Services')
                                                </a>
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
                @if ($apiProviders->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($apiProviders) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="addApiModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle"></h4>
                    <button class="close" data-bs-dismiss="modal" type="button"><i class="las la-times"></i></button>
                </div>
                <form class="form-horizontal resetForm" method="post" action="{{ route('admin.api.provider.store') }}">
                    @csrf
                    <div class="modal-body">
                        <input name="id" type="hidden">
                        <div class="form-group">
                            <label>@lang('API Name')</label>
                            <input class="form-control" name="name" type="text" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Short Name')</label>
                            <input class="form-control" name="short_name" type="text" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('API Url')</label>
                            <input class="form-control" name="api_url" type="url" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('API Key')</label>
                            <input class="form-control" name="api_key" type="text" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--primary h-45 w-100" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <div class="d-inline">
        <div class="input-group justify-content-end">
            <input class="form-control bg--white" name="search_table" type="text"
                   placeholder="@lang('Search')...">
            <button class="btn btn--primary input-group-text"><i class="fa fa-search"></i></button>
        </div>
    </div>
    <button class="btn btn-outline--primary h-45 btn-sm addApi"><i class="las la-plus"></i> @lang('Add New')</button>
@endpush

@push('style')
    <style>
        .syncServiceBtn,
        .updateBalanceBtn {
            background: transparent;
        }

        .view-service {
            font-size: 20px;
        }
    </style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            $('.updateApiSetting').on('click', function() {

                let modal = $('#addApiModal');
                let title = "@lang('Edit Api')";
                let id = $(this).data('id');
                let api_key = $(this).data('api_key');
                let short_name = $(this).data('short_name')
                let price = $(this).data('price');
                let api_url = $(this).data('api_url');
                let name = $(this).data('name');

                modal.find('input[name=api_key]').val(api_key);
                modal.find('input[name=id]').val(id);
                modal.find('input[name=api_url]').val(api_url);
                modal.find('input[name=name]').val(name);
                modal.find('input[name=price]').val(price);
                modal.find('input[name=short_name]').val(short_name);
                modal.find('.modal-title').text(title)
                modal.modal('show');

            });

            $('.addApi').on('click', function() {
                let modal = $('#addApiModal');
                let title = "@lang('Add New Api')";

                $('.resetForm').trigger('reset');
                modal.find('input[name=id]').val('');
                modal.modal('show');
                modal.find('.modal-title').text(title)
            });

            let actionUrl = '';
            let $clickedBtn = null;

            $('.syncServiceBtn, .updateBalanceBtn').on('click', function() {
                actionUrl = $(this).data('action');
                $clickedBtn = $(this);
                $clickedBtn.tooltip('hide');
                if (!actionUrl) return;

                $.ajax({
                    type: 'POST',
                    url: actionUrl,
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('#customConfirmationModal').modal('hide');
                        $clickedBtn.find('i').addClass('fa-spin');
                    },
                    success: function(res) {
                        notify('success', res.success || 'Action completed.');

                        if (actionUrl.includes('balance-update')) {
                            const $row = $clickedBtn.closest('tr');

                            $.get(window.location.href, function(html) {
                                const newDoc = new DOMParser().parseFromString(html,'text/html');
                                const updatedRow = newDoc.querySelector(`tr[data-id="${$row.data('id')}"]`);
                                const updatedBalance = updatedRow.querySelector('.balance-text').innerText;
                                $row.find('.balance-text').text(updatedBalance);
                            });
                        }
                    },
                    error: function(xhr) {
                        notify('error', xhr.responseJSON?.error || 'Something went wrong.');
                    },
                    complete: function() {
                        $clickedBtn.find('i').removeClass('fa-spin');
                        $clickedBtn = null;
                        actionUrl = '';
                    }
                });
            });

        })(jQuery);
    </script>
@endpush
