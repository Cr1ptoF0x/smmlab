@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card b-radius--10">
        <div class="card-body">
            <form class="dashboard-form" id="orderConfirmation" action="{{ route('user.order.create', @$service->id) }}"
                method="POST">
                @csrf
                <input class="form-control" name="api_provider_id" type="hidden">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <h4><i class="las la-shopping-cart"></i> @lang('New Order')</h4>
                        <hr class="mb-4">
                        <div class="form-group">
                            <label class="form--label">@lang('Category')</label>
                            <select class="form--control select2" name="category_id" required>
                                <option data-title="@lang('Select One')" data-service_from="@lang('N/A')" value="">
                                    @lang('Select One')
                                </option>
                                @foreach ($categories as $category)
                                    <option data-title="{{ __($category->name) }} ({{ $category->services_count }})"
                                        data-service_from="{{ showAmount(($category->price_per_k / 1000) * $category->service_min_start) }}"
                                        data-services='@json($category->services)' value="{{ $category->id }}"
                                        @selected($category->id == @$service->category_id)>{{ __($category->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form--label">@lang('Select Service')</label>
                            <select class="form--control select2" name="service_id" required> </select>
                        </div>
                        <div class="form-group">
                            <label class="form--label">@lang('Link')</label>
                            <input class="form--control" name="link" type="url" value="{{ old('link') }}"
                                placeholder="https://www.example.com" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Quantity')</label>
                                    <div class="input-group">
                                        <input class="form-control form--control" name="quantity" type="number"
                                            value="{{ old('quantity') }}" required>
                                        <div class="input-group-text">@lang('QTY')</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Price')
                                        <small>(@lang('Per 1K'))</small></label>
                                    <div class="input-group">
                                        <input class="form-control form--control" name="price" type="number"
                                            value="{{ old('price') }}" required readonly>
                                        <div class="input-group-text">{{ __(gs('cur_text')) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form--check">
                                <input class="form-check-input" id="orderConfirmationCheck" type="checkbox" value="1"
                                    required>
                                <label class="form-check-label" for="orderConfirmationCheck">
                                    @lang('Yes! I confirm the order.')
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <button class="btn btn--base w-100" type="submit"> @lang('Place Order')</button>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h4><i class="las la-luggage-cart"></i> @lang('Order Resume')</h4>
                        <hr class="mb-4">
                        <div class="order-resume">
                            <div class="order-details">
                                <div class="detail-item">
                                    <span class="detail-label fw-bold">@lang('Service Name'):</span>
                                    <span class="detail-value service_name">---</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label fw-bold">@lang('Minimum Quantity'):</span>
                                    <span class="detail-value minimum">0</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label fw-bold">@lang('Maximum Quantity'):</span>
                                    <span class="detail-value maximum">0</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label fw-bold">@lang('Price Per 1K'):</span>
                                    <span class="detail-value">
                                        {{ gs('cur_sym') }}<span class="price_per_k">0</span>
                                    </span>
                                </div>
                                <div class="detail-item-desc">
                                    <div class="detail-item  border-0">
                                        <span class="detail-label fw-bold">@lang('Description'):</span>
                                        <span class="detail-value no_details ">@lang('No description available.')</span>
                                    </div>
                                    <p class="details"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            @if (old() && old('category_id'))
                $('[name=category_id]').val(@json(old('category_id')));
            @endif

            var oldServiceId = "{{ old('service_id') }}";

            $('.select2').select2();

            var serviceId = `{{ @$service->id }}`
            let services = $('select[name="category_id"]').find(`option:selected`).data(`services`);

            getService(services);
            $('select[name="category_id"]').on('change', function() {
                getService(services)
            }).change();

            function getService(services) {
                services = $('select[name="category_id"]').find(`option:selected`).data(`services`);
                let html = `<option value="">@lang('Select One')</option>`;
                $.each(services, function(i, service) {
                    let isSelected = serviceId == service.id || oldServiceId == service.id ? 'selected' : '';
                    let serviceDataAttr =
                        `data-service_data="${JSON.stringify(service).replace(/"/g, '&quot;')}"`;
                    html +=
                        `<option ${serviceDataAttr} value="${service.id}" ${isSelected}>${service.name}</option>`;
                });
                $(`select[name=service_id]`).html(html);
                let serviceData = $('select[name="service_id"]').find(`option:selected`).data('service_data');
                if (serviceData) {
                    updateService(serviceData)
                }
            }

            $('select[name="service_id"]').on('change', function() {
                let data = $(this).find('option:selected').data('service_data');
                updateService(data);
                var newAction = "{{ route('user.order.create', ':id') }}";
                newAction = newAction.replace(':id', data.id);
                $('#orderConfirmation').attr('action', newAction);
                $('[name="quantity"]').val('');
            });

            @if (old('service_id'))
                $('select[name="service_id"]').change();
            @endif

            function updateService(serviceData) {
                let pricePerK = serviceData.price_per_k;
                if (serviceData.user_services.length > 0) {
                    pricePerK = serviceData.user_services[0].price
                }
                $('[name ="api_provider_id"]').val(serviceData.api_provider_id ?? '');
                $('.service_name').text(serviceData.name ?? '---');
                $('.minimum').text(serviceData.min ?? 0);
                $('.maximum').text(serviceData.max ?? 0);
                $('.price_per_k').text(parseFloat(pricePerK ?? 0.00).toFixed(2));
                if (serviceData.details) {
                    $('.details').text(serviceData.details);
                    $('.no_details').addClass('d-none');
                } else {
                    $('.no_details').text(`@lang('No description')`).addClass('d-block');
                    $('.details').addClass('d-none');
                }
            }

            $(document).on("keyup", '[name="quantity"]', function() {
                var pricePerK = $('.price_per_k').text();
                var quantity = parseInt($(this).val());
                var totalPrice = parseFloat((pricePerK / 1000) * quantity);
                $('[name="price"]').val(totalPrice.toFixed(2));
            });
        })(jQuery);
    </script>
@endpush
