@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--lg table-responsive">
                        <table class="table table--light tabstyle--two">
                            <thead>
                                <tr>
                                    <th>@lang('Order ID')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Provider')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Service')</th>
                                    <th>@lang('Quantity')</th>
                                    <th>@lang('Date')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>
                                            <span class="d-block">{{ __(@$order->user->fullname) }}</span>
                                            <a href="{{ route('admin.users.detail', $order->user_id) }}">
                                                {{ __(@$order->user->username) }}
                                            </a>
                                        </td>
                                        <td>{{ __($order->provider->name) }}</td>
                                        <td class="break_line">{{ __(@$order->category->name) }}</td>
                                        <td class="break_line">{{ __(@$order->service->name) }}</td>
                                        <td>{{ $order->quantity }}</td>
                                        <td>{{ showDateTime($order->created_at) }}</td>
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

    <x-confirmation-modal />
@endsection

@if ($orders->count())
    @push('breadcrumb-plugins')
        <button class="btn btn-outline--primary btn-sm confirmationBtn" data-action="{{ route('admin.dripfeed.api.submit') }}"
            data-question="@lang('Are you sure to place order to the provider?')">
            <i class="las la-box-open"></i> @lang('Place Order To Provider')
        </button>
    @endpush
@endif

@push('style')
    <style>
        .modal--card {
            background: #4634ff14 !important;
        }
    </style>
@endpush
