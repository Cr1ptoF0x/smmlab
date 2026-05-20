@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="dashboard-accordion-table mt-5">
                @if (!blank($favorites))
                    <div class="accordion table--acordion" id="transactionAccordion">
                        @foreach ($favorites as $favorite)
                            @php
                                $service = $favorite->service;
                            @endphp
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
                                            <p class="amount" title="@lang('Price Per 1K')">{{ showAmount($service->price_per_k) }}</p>
                                        </div>
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse" id="c-{{ $service->id }}" data-bs-parent="#transactionAccordion" aria-labelledby="h-{{ $loop->index }}">
                                    <div class="accordion-body">
                                        <ul class="caption-list">

                                            <li class="caption-list__item">
                                                <span class="caption">
                                                    @if (auth()->check() && @$service->id == @$favorite->service->id)
                                                        @lang('Remove Favourite')
                                                    @else
                                                        @lang('Make Favourite')
                                                    @endif
                                                </span>
                                                <span class="value"><span class="cursor-pointer  favoriteBtn @if (auth()->check() && @$service->id == @$favorite->service->id) active @else badge badge--base @endif" data-id="{{ $service->id }}" title="@lang('Favourite / Unfavourite')"><i class="la la-star"></i>
                                            </li>
                                            <li class="caption-list__item">
                                                <span class="caption">@lang('Service ID')</span>
                                                <span class="value">{{ __($service->id) }}</span>
                                            </li>
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
                                                <span class="value">{{ showAmount($service->price_per_k) }}</span>
                                            </li>
                                            @if ($service->details)
                                                <li class="caption-list__item">
                                                    <span class="caption">@lang('Details')</span>
                                                    <span class="value">{{ $service->details }}</span>
                                                </li>
                                            @endif
                                            <li class="caption-list__item">
                                                <span class="caption">@lang('Make Order')</span>
                                                <span class="value" title="@lang('Make Order')">
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
                    @if ($favorites->hasPages())
                        <div class="mt-5">
                            {{ paginateLinks($favorites) }}
                        </div>
                    @endif
                @else
                    @include($activeTemplate . 'partials.empty', ['message' => 'Favorite service not found!'])
                @endif
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.favoriteBtn').on('click', function() {
                var isAuthenticated = @json(auth()->check());
                if (!isAuthenticated) {
                    notify('error', 'Login required for manage favourite services!');
                    return 0;
                }
                var $this = $(this);
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('user.favorite.add') }}",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.action == 'add') {
                            notify('success', response.notification);
                            $this.removeClass('badge badge--base');
                            $this.addClass('active');
                        } else {
                            $this.removeClass('active');
                            $this.addClass('badge badge--base');
                            notify('success', response.notification);
                        }
                        location.reload();
                    }
                });
            });



        })(jQuery);
    </script>
@endpush
