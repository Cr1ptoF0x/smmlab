@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <h4 class="order-details-heading">@lang('Thanks') <span class="text--base">{{ auth()->user()->fullname }}</span>, @lang('Your Order has been received.')</h4>

            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="d-flex align-items-center">
                            <div class="order_icon me-2">
                                <i class="lab la-orcid fs-25"></i>
                            </div>
                            <div class="order_details">
                                <div class="fw-bold">@lang('Order Id')</div>
                                <span>{{ $order->id }}</span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="d-flex align-items-center">
                            <div class="order_icon me-2">
                                <i class="las la-mouse-pointer fs-25"></i>
                            </div>
                            <div class="order_details">
                                <div class="fw-bold">@lang('Service')</div>
                                <span>{{ $order->service->name }}</span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="d-flex align-items-center">
                            <div class="order_icon me-2">
                                <i class="las la-link fs-25"></i>
                            </div>
                            <div class="order_details">
                                <div class="fw-bold">@lang('Link')</div>
                                <span>{{ $order->link }}</span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="d-flex align-items-center">
                            <div class="order_icon me-2">
                                <i class="las la-calendar fs-25"></i>
                            </div>
                            <div class="order_details">
                                <div class="fw-bold">@lang('Quantity')</div>
                                <span>{{ $order->quantity }}</span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="d-flex align-items-center">
                            <div class="order_icon me-2">
                                <i class="las la-toggle-off fs-25"></i>
                            </div>
                            <div class="order_details">
                                <div class="fw-bold">@lang('Status')</div>
                                <span>@php echo $order->statusBadge; @endphp</span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="d-flex align-items-center">
                            <div class="order_icon me-2">
                                <i class="las la-calendar fs-25"></i>
                            </div>
                            <div class="order_details">
                                <div class="fw-bold">@lang('Ordered at')</div>
                                <span>{{ showDateTime($order->created_at) }}</span>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="d-flex align-items-center">
                            <div class="order_icon me-2">
                                <i class="lab la-sith fs-25"></i>
                            </div>
                            <div class="order_details">
                                <div class="fw-bold">@lang('Category')</div>
                                <span>{{ __($order->category->name) }}</span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="d-flex align-items-center">
                            <div class="order_icon me-2">
                                <i class="las la-sort-numeric-up fs-25"></i>
                            </div>
                            <div class="order_details">
                                <div class="fw-bold">@lang('Start Counter')</div>
                                <span>{{ $order->start_counter }}</span>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="d-flex align-items-center">
                            <div class="order_icon me-2">
                                <i class="las la-spinner fs-25"></i>
                            </div>
                            <div class="order_details">
                                <div class="fw-bold">@lang('Remains')</div>
                                <span>{{ $order->remain }}</span>
                            </div>
                        </div>
                    </div>
                </li>

                @if ($order->runs && $order->interval)
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="d-flex align-items-center">
                                <div class="order_icon me-2">
                                    <i class="las la-running fs-25"></i>
                                </div>
                                <div class="order_details">
                                    <div class="fw-bold">@lang('Runs')</div>
                                    <span>{{ $order->runs }} @lang('Times')</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="d-flex align-items-center">
                                <div class="order_icon me-2">
                                    <i class="las la-history fs-25"></i>
                                </div>
                                <div class="order_details">
                                    <div class="fw-bold">@lang('Intervals')</div>
                                    <span>{{ $order->interval }} @lang('Minutes')</span>
                                </div>
                            </div>
                        </div>
                    </li>
                @endif

            </ul>

            <div class="d-flex justify-content-end mt-4 gap-3">
                <a class="btn btn-outline--primary btn--sm" type="button" href="{{ $order->runs && $order->interval ? route('user.dripfeed.overview') : route('user.order.overview') }}"> <i class="las la-cart-plus"></i> @lang('New Order')</a>
                <a class="btn btn-outline--success btn--sm" type="button" href="{{ route('services') }}"> <i class="las la-mouse-pointer"></i> @lang('Services')</a>
                <a class="btn btn-outline--secondary btn--sm" type="button" href="{{ route('home') }}"> <i class="las la-home"></i> @lang('Home')</a>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .btn {
            color: hsl(var(--black)) !important
        }
    </style>
@endpush
