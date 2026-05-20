@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- Dashboard Card -->
    <div class="row g-3 justify-content-center">
        <div class="col-12">
            <div class="row gy-3 justify-content-center dashboard-widget-wrapper">
                <div class="col-xl-4 col-md-4 col-sm-6 col-xsm-6">
                    <a class="dashboard-widget flex-align" href="{{ route('user.transactions') }}">
                        <span class="dashboard-widget__icon flex-center"> <i class="la la-wallet f-size--56"></i></span>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text">@lang('Balance')</span>
                            <h4 class="dashboard-widget__number">{{ showAmount($widget['balance']) }}</h4>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6 col-xsm-6">
                    <a class="dashboard-widget flex-align" href="{{ route('user.transactions') }}?remark=order">
                        <span class="dashboard-widget__icon flex-center"> <i class="la la-money-bill f-size--56"></i></span>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text">@lang('Total Spent')</span>
                            <h4 class="dashboard-widget__number">{{ showAmount($widget['total_spent']) }}</h4>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6 col-xsm-6">
                    <a class="dashboard-widget flex-align" href="{{ route('user.transactions') }}">
                        <span class="dashboard-widget__icon flex-center"><i class="la la-exchange-alt f-size--56"></i></span>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text">@lang('Transactions')</span>
                            <h4 class="dashboard-widget__number">{{ showAmount($widget['total_transaction']) }}</h4>
                        </div>
                    </a>
                </div>

                <div class="col-xl-4 col-md-4 col-sm-6 col-xsm-6">
                    <a class="dashboard-widget flex-align" href="{{ route('user.deposit.history') }}">
                        <span class="dashboard-widget__icon flex-center"> <i class="las la-wallet f-size--56"></i></span>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text">@lang('Total Deposit')</span>
                            <h4 class="dashboard-widget__number">{{ showAmount($widget['deposit']) }}</h4>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6 col-xsm-6">
                    <a class="dashboard-widget flex-align" href="{{ route('ticket.index') }}">
                        <span class="dashboard-widget__icon flex-center"> <i class="las la-ticket-alt f-size--56"></i></span>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text">@lang('Total Ticket')</span>
                            <h4 class="dashboard-widget__number">{{ $widget['total_ticket'] }}</h4>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6 col-xsm-6">
                    <a class="dashboard-widget flex-align" href="{{ route('user.order.history') }}">
                        <span class="dashboard-widget__icon flex-center"><i class="la la-shopping-cart f-size--56"></i></span>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text">@lang('Total Order')</span>
                            <h4 class="dashboard-widget__number">{{ $widget['total_order'] }}</h4>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6 col-xsm-6">
                    <a class="dashboard-widget flex-align" href="{{ route('user.order.pending') }}">
                        <span class="dashboard-widget__icon flex-center"> <i class="la la-spinner f-size--56"></i></span>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text">@lang('Pending Order')</span>
                            <h4 class="dashboard-widget__number">{{ $widget['pending_order'] }}</h4>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6 col-xsm-6">
                    <a class="dashboard-widget flex-align" href="{{ route('user.order.processing') }}">
                        <span class="dashboard-widget__icon flex-center"> <i class="la la-refresh f-size--56"></i></span>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text">@lang('Processing Order')</span>
                            <h4 class="dashboard-widget__number">{{ $widget['processing_order'] }}</h4>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6 col-xsm-6">
                    <a class="dashboard-widget flex-align" href="{{ route('user.order.completed') }}">
                        <span class="dashboard-widget__icon flex-center"><i class="la la-check-circle f-size--56"></i></span>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text">@lang('Completed Order')</span>
                            <h4 class="dashboard-widget__number">{{ $widget['completed_order'] }}</h4>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6 col-xsm-6">
                    <a class="dashboard-widget flex-align" href="{{ route('user.order.refunded') }}">
                        <span class="dashboard-widget__icon flex-center"> <i class="la la-fast-backward f-size--56"></i></span>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text">@lang('Refund Order')</span>
                            <h4 class="dashboard-widget__number">{{ $widget['refunded_order'] }}</h4>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6 col-xsm-6">
                    <a class="dashboard-widget flex-align" href="{{ route('user.order.cancelled') }}">
                        <span class="dashboard-widget__icon flex-center"> <i class="la la-times-circle f-size--56"></i></span>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text">@lang('Cancelled Order')</span>
                            <h4 class="dashboard-widget__number">{{ $widget['cancelled_order'] }}</h4>
                        </div>
                    </a>
                </div>

                <div class="col-xl-4 col-md-4 col-sm-6 col-xsm-6">
                    <a class="dashboard-widget flex-align" href="{{ route('user.dripfeed.history') }}">
                        <span class="dashboard-widget__icon flex-center"><i class="la la-fill-drip f-size--56"></i></span>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text">@lang('Total Dripfeeds')</span>
                            <h4 class="dashboard-widget__number">{{ $widget['total_dripfeed_order'] }}</h4>
                        </div>
                    </a>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6 col-xsm-6">
                    <div class="dashboard-widget flex-align">
                        <a href="{{ route('user.dripfeed.pending') }}">
                            <span class="dashboard-widget__icon flex-center"> <i class="la la-spinner f-size--56"></i></span>
                        </a>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text">@lang('Pending Dripfeed Orders')</span>
                            <h4 class="dashboard-widget__number">{{ $widget['pending_dripfeed_order'] }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6 col-xsm-6">
                    <div class="dashboard-widget flex-align">
                        <a href="{{ route('user.dripfeed.processing') }}">
                            <span class="dashboard-widget__icon flex-center"> <i class="la la-refresh f-size--56"></i></span>
                        </a>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text">@lang('Processing Dripfeed Orders')</span>
                            <h4 class="dashboard-widget__number">{{ $widget['processing_dripfeed_order'] }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6 col-xsm-6">
                    <div class="dashboard-widget flex-align">
                        <a href="{{ route('user.dripfeed.completed') }}">
                            <span class="dashboard-widget__icon flex-center"> <i class="las la-check f-size--56"></i></span>
                        </a>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text">@lang('Completed Dripfeed Orders')</span>
                            <h4 class="dashboard-widget__number">{{ $widget['completed_dripfeed_order'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Table -->
    <div class="dashboard-table mt-5">
        <h5 class="dashboard-section-title">@lang('Latest SMM Orders')</h5>
        @if (!blank($orders))
            @include(@$activeTemplate . 'partials.order_list')
        @else
            @include($activeTemplate . 'partials.empty', ['message' => 'Latest order not found!'])
        @endif
    </div>

    <!-- Dashboard Accordion Table -->
    <div class="dashboard-accordion-table mt-5">
        <h5 class="dashboard-section-title">@lang('Top Best Selling Services')</h5>
        @if (!blank($bestSellingServices))
            <div class="accordion table--acordion" id="transactionAccordion">
                @foreach ($bestSellingServices as $service)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="h-{{ $loop->index }}">
                            <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#c-{{ $service->id }}" type="button" aria-expanded="false" aria-controls="c-1">
                                <div class="col-xl-8 col-sm-8 col-8 order-1">
                                    <div class="left">
                                        <div class="icon base">
                                            <i class="las la-cart-plus"></i>
                                        </div>
                                        <div class="content">
                                            <h6 class="title mb-0">{{ __($service->name) }}</h6>
                                            <span class="date-time">{{ showDateTime($service->created_at) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-4 col-4 order-sm-3 order-2 text-end amount-wrapper">
                                    <p class="amount" title="@lang('Total Ordered')">{{ $service->total_orders }}</p>
                                </div>
                            </button>
                        </h2>
                        <div class="accordion-collapse collapse" id="c-{{ $service->id }}" data-bs-parent="#transactionAccordion" aria-labelledby="h-{{ $loop->index }}">
                            <div class="accordion-body">
                                <ul class="caption-list">
                                    <li class="caption-list__item">
                                        <span class="caption">@lang('Category')</span>
                                        <span class="value">{{ __($service->category->name) }}</span>
                                    </li>
                                    <li class="caption-list__item">
                                        <span class="caption">@lang('Minimum | Maximum')</span>
                                        <span class="value">{{ $service->min }} | {{ $service->max }}</span>
                                    </li>
                                    <li class="caption-list__item">
                                        <span class="caption">@lang('Price Per 1K')</span>
                                        <span class="value">{{showAmount($service->price_per_k) }}</span>
                                    </li>
                                    @if ($service->details)
                                        <li class="caption-list__item">
                                            <span class="caption">@lang('Details')</span>
                                            <span class="value">{{ $service->details }}</span>
                                        </li>
                                    @endif
                                    <li class="caption-list__item">
                                        <span class="caption">@lang('Make Order')</span>
                                        <span class="value">
                                            <a class="action-btn order-btn" href="{{ route('user.order.overview', $service->id) }}">
                                                <span class="icon"><i class="las la-cart-plus"></i></span>
                                            </a>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            @include($activeTemplate . 'partials.empty', ['message' => 'Best selling service not found!'])
        @endif
    </div>

@endsection
