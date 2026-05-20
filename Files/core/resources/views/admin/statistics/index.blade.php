@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-md-7">
            <div class="card full-view">
                <div class="card-header">
                    <div class="row g-2 align-items-center">
                        <div class="col-sm-6">
                            <h5 class="card-title mb-0">@lang('Total Orders')</h5>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <div class="d-flex justify-content-sm-end gap-2">
                                <select class="widget_select select2" data-minimum-results-for-search="-1" name="oredr_time">
                                    <option value="week">@lang('Current Week')</option>
                                    <option value="month">@lang('Current Month')</option>
                                    <option value="year">@lang('Current Year')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body text-center pb-0 px-0">
                    <div id="my_order_canvas"></div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card h-100">
                <div class="card-header">
                    <div class="row g-2 align-items-center">
                        <div class="col-sm-6 col-md-12 col-xl-5">
                            <h5 class="card-title mb-0">@lang('Statistics by API Providers')</h5>
                        </div>
                        <div class="col-sm-6 col-md-12 col-xl-7">
                            <div class="pair-option justify-content-md-start justify-content-xl-end">
                                <select class="widget_select select2" data-minimum-results-for-search="-1"
                                    name="order_statistics_time">
                                    <option value="all">@lang('All Duration')</option>
                                    <option value="week">@lang('Current Week')</option>
                                    <option value="month">@lang('Current Month')</option>
                                    <option value="year">@lang('Current Year')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container api-chart">
                        <div class="chart-info">
                            <a class="chart-info-toggle" href="#">
                                <img class="chart-info-img" src="{{ asset('assets/images/collapse.svg') }}">
                            </a>
                            <div class="chart-info-content">
                                <ul class="chart-info-list api-info-data"></ul>
                            </div>
                        </div>
                        <div class="chart-area chart-area--fixed">
                            <div class="order_api_statistic_canvas"></div>
                        </div>
                    </div>
                    <div class="no-data-container d-none">
                        <h5 class="text-center">@lang('No data found')</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="card-title">@lang('Order by API Provider') (@lang('Last 12 Month'))</h5>
                        <select class="widget_select_api select2" data-minimum-results-for-search="-1" name="provider_id">
                            @foreach ($providers as $provider)
                                <option value="{{ $provider->id }}">{{ __($provider->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="order-chart"> </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-4">
            <h5 class="mb-4">@lang('Top Seller Services')</h5>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--lg table-responsive">
                        <table class="table table--light tabstyle--two">
                            <thead>
                                <tr>
                                    <th>@lang('Service ID')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Provider')</th>
                                    <th>@lang('Min / Max')</th>
                                    <th>@lang('Price/1K')</th>
                                    <th>@lang('Total Orders')</th>
                                    <th>@lang('Description')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>{{ $order->service->provider ? $order->service->api_service_id : $order->service->id }}
                                        </td>
                                        <td class="break_line">
                                            {{ __(@$order->service->name) }}
                                            @if (@$order->service->provider->short_name)
                                                <span class="badge badge--primary">
                                                    {{ __(@$order->service->provider->short_name) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ @$order->service->provider->name ?? '-' }}</td>
                                        <td>{{ @$order->service->min }} / {{ @$order->service->max }}</td>
                                        <td>
                                            <strong>{{ showAmount(@$order->service->price_per_k) }}</strong>
                                            <br>
                                            @if ($order->service->provider)
                                                {{ showAmount(@$order->service->original_price) }} (@lang('Provider'))
                                            @else
                                                @lang('N/A')
                                            @endif
                                        </td>
                                        <td>{{ $order->service_count }}</td>
                                        <td>
                                            <div class="button--group">
                                                <button type="button" class="btn btn-sm btn-outline--primary detailBtn"
                                                    data-service="{{ $order->service }}">
                                                    <i class="las la-desktop"></i> @lang('View')
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
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p class="detail"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="close btn btn--dark w-100 h-45" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> @lang('Close')
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';

            $('.detailBtn').on('click', function() {
                let modal = $('#detailModal');
                let service = $(this).data('service');
                modal.find('.modal-title').text(service.name);
                modal.find('.detail').html(service.details.replace(/\n/g, '<br>'));
                modal.modal('show');
            });

            var chart;
            $('[name=oredr_time]').on('change', function() {
                let time = $(this).val();
                let url = "{{ route('admin.order.report.statistics') }}";

                $.get(url, {
                    time: time
                }, function(response) {
                    let pendingData = [];
                    let processingData = [];
                    let completedData = [];
                    let cancelledData = [];
                    let refundedData = [];
                    let labels = [];

                    $.each(response.chart_data, function(i, v) {
                        pendingData.push(v.pending);
                        processingData.push(v.processing);
                        completedData.push(v.completed);
                        cancelledData.push(v.cancelled);
                        refundedData.push(v.refunded);
                        labels.push(i);
                    });

                    var options = {
                        series: [{
                                name: 'Pending',
                                data: pendingData
                            },
                            {
                                name: 'Processing',
                                data: processingData
                            },
                            {
                                name: 'Completed',
                                data: completedData
                            },
                            {
                                name: 'Cancelled',
                                data: cancelledData
                            },
                            {
                                name: 'Refunded',
                                data: refundedData
                            }
                        ],
                        colors: [
                            getBackgroundColorForStatus('pending'),
                            getBackgroundColorForStatus('processing'),
                            getBackgroundColorForStatus('completed'),
                            getBackgroundColorForStatus('cancelled'),
                            getBackgroundColorForStatus('refunded')
                        ],
                        chart: {
                            type: 'bar',
                            height: 450,
                            toolbar: {
                                show: false
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '50%',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: labels,
                        },
                        grid: {
                            xaxis: {
                                lines: {
                                    show: false
                                }
                            },
                            yaxis: {
                                lines: {
                                    show: false
                                }
                            },
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val
                                }
                            }
                        }
                    };

                    if (chart) {
                        chart.destroy();
                    }
                    chart = new ApexCharts(document.querySelector("#my_order_canvas"), options);
                    chart.render();

                });
            }).change();

            function getBackgroundColorForStatus(status) {
                switch (status) {
                    case 'pending':
                        return '#ffcc00'; // Yellow for pending
                    case 'processing':
                        return '#007bff'; // Blue for processing
                    case 'completed':
                        return '#28a745'; // Green for completed
                    case 'cancelled':
                        return '#dc3545'; // Red for cancelled
                    case 'refunded':
                        return '#6610f2'; // Purple for refunded
                    default:
                        return '#6c757d'; // Default color
                }
            }

            // Api provider order chart
            $('[name=provider_id]').on('change', function() {
                var providerId = $(this).val();
                $.ajax({
                    type: "GET",
                    url: `{{ route('admin.provider.chart') }}/${providerId}`,
                    success: function(response) {
                        $('#order-chart').html('');
                        var options = {
                            series: [{
                                name: 'Total',
                                data: Object.values(response),
                            }],
                            chart: {
                                type: 'bar',
                                height: 400,
                                toolbar: {
                                    show: false
                                }
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '55%',
                                    endingShape: 'rounded'
                                },
                            },
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                show: true,
                                width: 1,
                                colors: ['transparent']
                            },
                            xaxis: {
                                categories: Object.keys(response)
                            },
                            fill: {
                                opacity: 1
                            },
                            tooltip: {
                                y: {
                                    formatter: function(val) {
                                        return val.toFixed(2) + " {{ gs('cur_text') }}"
                                    }
                                }
                            }
                        };
                        var orderChart = new ApexCharts(document.querySelector("#order-chart"),
                            options);
                        orderChart.render();
                    }
                });
            }).change()

            //API-providers-statistics//
            $('[name=order_statistics_time]').on('change', function() {
                let time = $('[name=order_statistics_time]').val();
                var url = "{{ route('admin.order.report.statistics.api') }}";

                $.get(url, {
                    time: time,
                }, function(response) {
                    $('.order_api_statistic_canvas').html(
                        '<canvas height="250" id="order_api_statistics"></canvas>');
                    let orders = response.order_data;
                    let apiInfo = '';
                    let orderPrice = [];
                    let apiName = [];
                    let totalOrder = response.total_order;
                    if (orders.length > 0) {

                        $('.chart-container').removeClass('d-none');
                        $('.no-data-container').addClass('d-none');

                        $.each(orders, function(key, order) {
                            let orderPercent = (order.orderPrice / totalOrder) * 100;
                            orderPrice.push(parseFloat(order.orderPrice).toFixed(2));
                            let providerName = (order.provider && order.provider.name) ? order
                                .provider.name : 'Direct Order';
                            apiName.push(providerName);
                            apiInfo +=
                                `<li class="chart-info-list-item"><i class="las la-shopping-cart apiPoint me-2"></i>${orderPercent.toFixed(2)}% - ${providerName} </li>`;
                        });
                    } else {
                        $('.chart-container').addClass('d-none');
                        $('.no-data-container').removeClass('d-none');
                        apiInfo = '<li class="chart-info-list-item">@lang('No Data')</li>';
                    }

                    $('.api-info-data').html(apiInfo);

                    /* -- Chartjs - Pie Chart -- */
                    var pieChartID = document.getElementById("order_api_statistics").getContext('2d');
                    var pieChart = new Chart(pieChartID, {
                        type: 'pie',
                        data: {
                            datasets: [{
                                data: orderPrice,
                                borderColor: 'transparent',
                                backgroundColor: apiColors()
                            }],
                            labels: apiName // Use provider names or 'No Data'
                        },
                        options: {
                            responsive: true,
                            legend: {
                                display: false
                            },
                            tooltips: {
                                callbacks: {
                                    label: (tooltipItem, data) => data.datasets[0].data[
                                        tooltipItem.index] + ' {{ gs('cur_text') }}'
                                }
                            }
                        }
                    });

                    var apiPoints = $('.apiPoint');
                    apiPoints.each(function(key, apiPoint) {
                        var apiPoint = $(apiPoint)
                        apiPoint.css('color', apiColors()[key])
                    });
                });
            }).change();

            function apiColors() {
                return [
                    '#D980FA',
                    '#fccbcb',
                    '#45aaf2',
                    '#05dfd7',
                    '#FF00F6',
                    '#1e90ff',
                    '#2ed573',
                    '#eccc68',
                    '#ff5200',
                    '#cd84f1',
                    '#7efff5',
                    '#7158e2',
                    '#fff200',
                    '#ff9ff3',
                    '#08ffc8',
                    '#3742fa',
                    '#1089ff',
                    '#70FF61',
                    '#bf9fee',
                    '#574b90'
                ]
            }

            let chartToggle = $('.chart-info-toggle');
            let chartContent = $(".chart-info-content");
            if (chartToggle || chartContent) {
                chartToggle.each(function() {
                    $(this).on("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        $(this).siblings().toggleClass("is-open");
                    });
                });
                chartContent.each(function() {
                    $(this).on("click", function(e) {
                        e.stopPropagation();
                    });
                });
                $(document).on("click", function() {
                    chartContent.removeClass("is-open");
                });
            }
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .card-body:has(.no-data-container) {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        @media (max-width:1599px) {
            .api-chart {
                flex-direction: column;
                min-height: unset;
                gap: 30px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        }

        .chart-info {
            isolation: isolate;
        }

        @media (max-width:1366px) {

            .chart-info-img {
                width: 30px;
                transform: rotate(180deg);
                filter: invert(0.62) sepia(1) saturate(4.5) hue-rotate(199deg);
            }

            .chart-info-content {
                position: absolute;
                top: 60px;
                left: 20px;
                border-radius: 3px;
                background: #fff;
                transform: translateX(-120%);
                transition: all 0.3s ease;
            }

            .chart-info-toggle {
                cursor: pointer;
                position: absolute;
                left: 20px;
                top: 20px;
            }

            .chart-info-content.is-open {
                transform: translateX(0);
                box-shadow: 0 0 1.5rem rgba(18, 38, 63, 0.1);
            }
        }
    </style>
@endpush
