<table class="table table--responsive--md">
    <thead>
        <tr>
            <th>@lang('Order ID')</th>
            <th>@lang('Service')</th>
            <th>@lang('Link')</th>
            <th>@lang('Quantity')</th>
            <th>@lang('Status')</th>
            <th>@lang('Actions')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td class="break_line">
                    {{ __($order->service->name) }}</td>
                <td class="break_line">
                    <a href="{{ empty(parse_url($order->link, PHP_URL_SCHEME)) ? 'https://' : null }}{{ $order->link }}"
                        target="_blank">{{ $order->link }}</a>
                </td>
                <td>{{ $order->quantity }}</td>
                <td>@php echo $order->statusBadge; @endphp </td>
                <td>
                    @if ($order->service->refill && $order->status == Status::ORDER_COMPLETED)
                        <button class="action-btn confirmationBtn"
                            data-action="{{ route('user.refill.store', $order->id) }}" data-question="@lang('Are you sure to refill this service?')"
                            title="@lang('Refill')">
                            <div class="icon"><i class="las la-sync"></i></div>
                        </button>
                    @endif
                    <button class="action-btn edit-btn orderDetailBtn"
                        data-order-date="{{ showDateTime($order->created_at) . ' (' . diffForHumans($order->created_at) . ')' }}"
                        data-resource="{{ $order }}" type="button" title="@lang('Details')">
                        <spna class="icon"><i class="las la-desktop"></i></spna>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="dashboard-modal modal" id="orderDetailModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="d-flex align-items-center">
                                <div class="order_icon me-2">
                                    <i class="las la-calendar fs-25"></i>
                                </div>
                                <div class="order_details">
                                    <div class="fw-bold">@lang('Order Date')</div>
                                    <span class="date-detail"></span>
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
                                    <span class="category-detail"></span>
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
                                    <span class="start-counter-detail"></span>
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
                                    <span class="remains-detail"></span>
                                </div>
                            </div>
                        </div>
                    </li>

                    <div class="dripfeed d-none">
                        <span class="my-2">@lang('Dripfeed:')</span>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="d-flex align-items-center">
                                    <div class="order_icon me-2">
                                        <i class="las la-running fs-25"></i>
                                    </div>
                                    <div class="order_details">
                                        <div class="fw-bold">@lang('Runs')</div>
                                        <span class="runs-detail"></span>
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
                                        <span class="intervals-detail"></span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </div>

                </ul>
            </div>
        </div>
    </div>
</div>

<x-confirmation-modal />

@push('script')
    <script>
        'use strict';
        $(document).ready(function() {
            $(".orderDetailBtn").on("click", function() {
                var modal = $("#orderDetailModal");
                let data = $(this).data('resource')
                modal.find('.category-detail').text(data.category.name);
                modal.find('.start-counter-detail').text(data.start_counter);
                modal.find('.remains-detail').text(data.remain);
                modal.find('.date-detail').text($(this).data('order-date'));
                modal.find('.modal-title').text(data.service.name);
                if (data.runs && data.interval) {
                    $(".dripfeed").removeClass('d-none');
                    modal.find('.runs-detail').text(data.runs + ' ' + "@lang('Times')");
                    modal.find('.intervals-detail').text(data.interval + ' ' + "@lang('Minutes')");
                } else {
                    $(".dripfeed").addClass('d-none')
                }
                modal.modal('show');
            });
        });
    </script>
@endpush
