@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="dashboard-table">
                @if (!blank($refills))
                    <table class="table table--responsive--md">
                        <thead>
                            <tr>
                                <th>@lang('Order ID')</th>
                                <th>@lang('Service')</th>
                                <th>@lang('Link')</th>
                                <th>@lang('Quantity')</th>
                                <th>@lang('Status')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($refills as $refill)
                                <tr>
                                    <td>{{ $refill->order->id }}</td>
                                    <td class="break_line">
                                        {{ __($refill->order->service->name) }}
                                    </td>
                                    <td class="break_line">
                                        <a href="{{ empty(parse_url($refill->order->link, PHP_URL_SCHEME)) ? 'https://' : null }}{{ $refill->order->link }}"
                                            target="_blank">
                                            {{ $refill->order->link }}
                                        </a>
                                    </td>
                                    <td>{{ $refill->order->quantity }}</td>
                                    <td>@php echo $refill->statusBadge; @endphp </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if ($refills->hasPages())
                        {{ paginateLinks($refills) }}
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
    </style>
@endpush
