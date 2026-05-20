@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive--lg table-responsive">
                        <table class="table table--light tabstyle--two">
                            <thead>
                                <tr>
                                    <th>@lang('Order ID')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Service')</th>
                                    <th>@lang('API Order')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($refills as $refill)
                                    <tr>
                                        <td>{{ $refill->order->id }}</td>
                                        <td>
                                            <span class="d-block">{{ __(@$refill->order->user->fullname) }}</span>
                                            <a
                                                href="{{ route('admin.users.detail', $refill->order->user_id) }}">{{ __(@$refill->order->user->username) }}</a>
                                        </td>
                                        <td class="break_line">{{ __(@$refill->order->category->name) }}</td>
                                        <td class="break_line">{{ __(@$refill->order->service->name) }}</td>
                                        <td>
                                            @if ($refill->order->api_order)
                                                <span class="badge  badge--primary">@lang('Yes')</span>
                                            @else
                                                <span class="badge  badge--warning">@lang('No')</span>
                                            @endif
                                        </td>
                                        <td>@php echo $refill->statusBadge @endphp</td>
                                        <td>
                                            @if (!$refill->order->api_order && $refill->status == Status::NO)
                                                <button class="btn btn-sm btn-outline--primary confirmationBtn"
                                                    data-action="{{ route('admin.refill.information.update', $refill->id) }}" data-question="@lang('Are you sure to change refill status Completed?')">
                                                    <i class="la la-pen"></i>
                                                    @lang('Update')
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline--primary" disabled>
                                                    <i class="la la-pen"></i>
                                                    @lang('Update')
                                                </button>
                                            @endif
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
                @if ($refills->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($refills) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    @if (request()->routeIs('admin.refill.index'))
        <button class="btn btn-outline--primary confirmationBtn"
            data-action="{{ route('admin.refill.provider.information.update') }}" data-question="@lang('Are you sure to update provider refill information?')">
            <i class="las la-box-open"></i> @lang('Update Provider Information')
        </button>
    @endif
    @if (request()->routeIs('admin.refill.pending'))
        <button class="btn btn-outline--primary confirmationBtn" data-action="{{ route('admin.refill.provider.request') }}"
            data-question="@lang('Are you sure to send refill request to the provider?')">
            <i class="las la-box-open"></i> @lang('Refill Request To Provider')
        </button>
    @endif
@endpush
