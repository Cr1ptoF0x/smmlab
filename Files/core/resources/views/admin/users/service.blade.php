@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg--primary">
                    <h5 class="card-title text--white">@lang('Add Custom Price')</h5>
                </div>
                <form method="POST" action="{{ route('admin.users.service.store') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="card-body">
                        <div class="form-group">
                            <label>@lang('Services')</label>
                            <select name="service" class="form-control select2" required>
                                <option value="">@lang('Select One')</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}" data-service="{{ $service }}">
                                        {{ __($service->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('Service Original Price')</label>
                            <div class="input-group">
                                <input type="number" name="original_price" class="form-control" value="0" disabled>
                                <span class="input-group-text">{{ gs('cur_text') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Service Price')</label>
                            <div class="input-group">
                                <input type="number" name="service_price" class="form-control" value="0" disabled>
                                <span class="input-group-text">{{ gs('cur_text') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Custom Price')</label>
                            <div class="input-group">
                                <input type="number" name="custom_price" step="any" class="form-control" required>
                                <span class="input-group-text">{{ gs('cur_text') }}</span>
                            </div>
                        </div>
                        <div class="service_list"></div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Update Price')</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Service')</th>
                                    <th>@lang('Service Price')</th>
                                    <th>@lang('Custom Price')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($userServices as $userService)
                                    <tr>
                                        <td class="break_line">
                                            {{ __($userService->service->name) }}
                                            @if (@$service->provider->short_name)
                                                <span class="badge badge--primary">{{ __(@$service->provider->short_name) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ showAmount($userService->service->price_per_k) }}</strong>
                                            <br>
                                            {{ showAmount($userService->service->original_price) }}
                                        </td>
                                        <td><strong>{{ showAmount($userService->price) }}</strong></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline--info" id="bulkAction"
                                                data-bs-toggle="dropdown">
                                                <i class="las la-ellipsis-v"></i>
                                                @lang('Action')
                                            </button>
                                            <div class="dropdown-menu">
                                                <button data-user_service="{{ $userService }}"
                                                    class="dropdown-item editBtn">
                                                    <i class="las la-pen"></i> @lang('Edit')
                                                </button>
                                                <button class="dropdown-item confirmationBtn"
                                                    data-question="@lang('Are you sure to delete this custom service?')"
                                                    data-action="{{ route('admin.users.service.delete', $userService->id) }}">
                                                    <i class="las la-trash"></i> @lang('Delete')
                                                </button>
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
                @if ($userServices->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($userServices) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.users.detail', $user->id) }}"/>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';

            $('[name=service]').on('change', function() {
                let service = $(this).find('option:selected').data('service');
                $('[name=original_price]').val(parseFloat(service.original_price).toFixed(2));
                $('[name=service_price]').val(parseFloat(service.price_per_k).toFixed(2));
                $('[name=custom_price]').val('');
            });

            $('.editBtn').on('click', function() {
                let userService = $(this).data('user_service');
                let service = userService.service;
                $('[name=service]').val(service.id).change();
                $('[name=original_price]').val(parseFloat(service.original_price).toFixed(2));
                $('[name=service_price]').val(parseFloat(service.price_per_k).toFixed(2));
                $('[name=custom_price]').val(parseFloat(userService.price).toFixed(2));
            });
        })(jQuery)
    </script>
@endpush
