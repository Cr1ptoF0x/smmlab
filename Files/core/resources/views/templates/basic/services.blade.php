@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="ptb-80">
        <div class="container">
            <div class="row gy-4">
                <div class="col-12">
                    <div class="show-filter mb-3 text-end">
                        <button class="btn btn--base showFilterBtn btn-sm" type="button"><i
                                class="las la-filter"></i>@lang('Filter')</button>
                    </div>
                    <div class="card responsive-filter-card common-form-style mb-4">
                        <div class="card-body">
                            <form action="{{ route('services') }}">
                                <div class="d-flex flex-wrap align-items-center gap-4">
                                    <div class="flex-grow-1">
                                        <label class="form-label">@lang('Category')</label>
                                        <select class="form--control select2" name="category_id">
                                            <option value="" selected>@lang('Select One')</option>
                                            @foreach ($listCategories as $category)
                                                <option value="{{ $category->id }}" @selected(request()->category_id == $category->id)>
                                                    {{ __(keyToTitle($category->name)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-label">@lang('Service')</label>
                                        <input class="form--control" name="search" type="text"
                                            value="{{ request()->search }}">
                                    </div>
                                    <div class="flex-grow-1 align-self-end">
                                        <button class="btn btn--base w-100 filter-btn"><i class="fas fa-filter"></i>
                                            @lang('Filter')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="accordion custom--accordion services-accordion" id="accordionExample">
                        @forelse($categories as $category)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $loop->index }}">
                                    <button class="accordion-button @if (!$loop->first) collapsed @endif"
                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}"
                                        type="button"
                                        aria-expanded="@if ($loop->first) true @else false @endif"
                                        aria-controls="collapse{{ $loop->index }}">
                                        <span class="icon"><i class="las la-feather"></i></span> {{ __($category->name) }}
                                    </button>
                                </h2>
                                <div class="accordion-collapse collapse @if ($loop->first) show @endif"
                                    id="collapse{{ $loop->index }}" data-bs-parent="#accordionExample"
                                    aria-labelledby="heading{{ $loop->index }}">
                                    <div class="accordion-body">
                                        <table class="table table--responsive--md">
                                            <thead>
                                                <th>@lang('Service ID')</th>
                                                <th>@lang('Service')</th>
                                                <th>@lang('Price Per 1k')</th>
                                                <th>@lang('Min') / @lang('Max')</th>
                                                <th>@lang('Make Order')</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($category->services ?? [] as $service)
                                                    <tr>
                                                        <td>{{ $service->id }}</td>
                                                        <td class="break_line">
                                                            {{ __($service->name) }}
                                                        </td>
                                                        <td>{{ showAmount($service->price_per_k) }}</td>
                                                        <td>{{ $service->min }} / {{ $service->max }}</td>
                                                        <td>
                                                            <div class="action-buttons">
                                                                <button class="action-btn bg-warning favoriteBtn"
                                                                    data-id="{{ $service->id }}"
                                                                    title="@lang('"Favorite / Unfavorite"')">
                                                                    @if (auth()->check() && in_array(@$service->id, @$myFavorites))
                                                                        <i class="las la-heart"></i>
                                                                    @else
                                                                        <i class="lar la-heart"></i>
                                                                    @endif
                                                                </button>
                                                                <button class="action-btn details-btn detailsBtn"
                                                                    data-details="{{ nl2br($service->details) }}" type="button"
                                                                    title="@lang('Details')" @disabled(!$service->details)>
                                                                    <span class="icon"><i
                                                                            class="la la-desktop"></i></span>
                                                                </button>
                                                                <a class="action-btn order-btn"
                                                                    href="{{ auth()->user() ? route('user.order.overview', $service->id) : route('user.login') }}"
                                                                    title="@lang('Make Order')">
                                                                    <span class="icon"><i
                                                                            class="las la-cart-plus"></i></span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                @include($activeTemplate . 'partials.empty', [
                                    'message' => 'SMM service not found!',
                                ])
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-modal modal" id="detailsModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Service Details')</h5>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <p id="details"></p>
                    </div>
                    <div class="col-12">
                        <div class="form-group buttons mb-0 text-end">
                            <button class="btn btn--dark btn-sm" data-bs-dismiss="modal"
                                type="button">@lang('Close')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('style')
    <style>
        .common-form-style {
            padding: 15px !important;
            border-radius: 8px !important
        }

        .filter-btn {
            padding: 12.52px 25px !important;
        }

        .card .select2-container--default .select2-selection--single {
            border-color: transparent !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.select2').select2();

            $('.detailsBtn').on('click', function() {
                var modal = $('#detailsModal');
                var details = $(this).data('details');
                modal.find('#details').html(details);
                modal.modal('show');
            });

            $('.favoriteBtn').on('click', function() {

                var isAuthenticated = @json(auth()->check());
                if (!isAuthenticated) {
                    notify('error', 'Login required for manage favourite services!');
                    return 0;
                }
                var element = $(this);
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('user.favorite.add') }}",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.action == 'add') {
                            element.html('<i class="las la-heart"></i>')
                            notify('success', response.notification);
                        } else {
                            element.html(`<i class="lar la-heart"></i>`)
                            notify('success', response.notification);
                        }
                    }
                });
            });

        })(jQuery);
    </script>
@endpush
