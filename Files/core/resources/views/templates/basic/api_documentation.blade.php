@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="ptb-80">
        <div class="container">
            <div class="bodywrapper__inner dashboard">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="api-card">
                            <div class="api-card__body">
                                <ul class="api-list">
                                    <li class="api-list__item">
                                        <span class="title">@lang('Title')</span>
                                        <span class="title">@lang('Content')</span>
                                    </li>
                                    <li class="api-list__item">
                                        <span class="parameter">@lang('API URL')</span>
                                        <span class="desc">{{ route('api.v1') }}</span>
                                    </li>
                                    <li class="api-list__item">
                                        <span class="parameter">@lang('Response Format')</span>
                                        <span class="desc">JSON</span>
                                    </li>
                                    <li class="api-list__item">
                                        <span class="parameter">@lang('HTTP Method')</span>
                                        <span class="desc">POST</span>
                                    </li>
                                    <li class="api-list__item">
                                        <span class="parameter">@lang('Your API Key')</span>
                                        <div class="desc d-flex justify-content-between">
                                            <span class="desc">@lang('Your API key')</span>
                                        </div>
                                    </li>
                                    <li class="api-list__item">
                                        <span class="parameter">@lang('Example PHP Code')</span>
                                        <span class="desc">
                                            <a class="action-btn" href="{{ asset('assets/example.txt') }}" target="_blank">
                                                <i class="las la-code"></i> @lang('Code')
                                            </a>
                                        </span>
                                    </li>
                                </ul>
                                <div class="api-card__code mt-5 ">
                                    <h6 class="title"><i class="las la-arrow-circle-right"></i> @lang('Service List:')</h6>
                                    <ul class="api-list">
                                        <li class="api-list__item">
                                            <span class="title">@lang('Required Parameter')</span>
                                            <span class="title">@lang('Content')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('key')</span>
                                            <span class="desc">@lang('Your API Key')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('action')</span>
                                            <span class="desc">"services"</span>
                                        </li>
                                    </ul>
                                    <h6 class="title text--success mb-3">@lang('Service List Success Response'):</h6>
                                    <pre class="rounded-2">
                                        <code class="language-php">
                                            [
                                                {
                                                    "service": 1,
                                                    "name": "YouTube Livestream Viewers ",
                                                    "rate": "0.33000000",
                                                    "min": 1000,
                                                    "max": 200000,
                                                    "category": "Live Stream [ Low ConCurrent | Less Price ] [ 30 Minutes to 24 Hours]"</em>,
                                                    "refill": true,
                                                    "dripfeed": true,
                                                },
                                                {
                                                    "service": 2,
                                                    "name": "YouTube Livestream Viewers ~ ",
                                                    "rate": "2.10000000",
                                                    "min": 1000,
                                                    "max": 200000,
                                                    "category": "Live Stream [ Low ConCurrent | Less Price ] [ 30 Minutes to 24 Hours]" </em>
                                                    "refill": true,
                                                    "dripfeed": false,
                                                }
                                            ]
                                        </code>
                                    </pre>
                                </div>
                                <div class="api-card__code mt-3">
                                    <h6 class="title text--danger mb-3">@lang('Service List Error Response'):</h6>
                                    <pre class="rounded-3">
                                        <code class="language-php">
                                            {"@lang('error')" : "@lang('The action field is required')"}
                                            {"@lang('error')" : "@lang('The api key field is required')"}
                                            {"@lang('error')" : "@lang('Invalid api key')"}
                                            {"@lang('error')" : "@lang('Invalid action')"}
                                        </code>
                                    </pre>
                                </div>
                                <div class="api-card__code mt-5">
                                    <h6 class="title mb-3"><i class="las la-arrow-circle-right"></i> @lang('Place New Order:')</h6>
                                    <ul class="api-list">
                                        <li class="api-list__item">
                                            <span class="title">@lang('Required Parameter')</span>
                                            <span class="title">@lang('Content')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('key')</span>
                                            <span class="desc">@lang('Your API Key')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('action')</span>
                                            <span class="desc">"add"</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('service')</span>
                                            <span class="desc">@lang('Service ID')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('link')</span>
                                            <span class="desc">@lang('Link to Page')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('quantity')</span>
                                            <span class="desc">@lang('Quantity to be Delivered')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('runs(Optional)')</span>
                                            <span class="desc">@lang('Runs to Deliver')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('interval(Optional)')</span>
                                            <span class="desc">@lang('Interval in Minutes')</span>
                                        </li>
                                    </ul>
                                    <h6 class="title text--success my-3">@lang('New Order Success Response'):</h6>
                                    <pre class="rounded-2">
                                        <code class="language-php">
                                            {
                                                "order": 1242
                                            }
                                        </code>
                                    </pre>
                                </div>
                                <div class="api-card__code mb-5">
                                    <h6 class="title text--danger my-3">@lang('New Order Error Response'):</h6>
                                    <pre class="rounded-3">
                                        <code class="language-php">
                                            {"@lang('error')" : "@lang('The action field is required')"}
                                            {"@lang('error')" : "@lang('The api key field is required')"}
                                            {"@lang('error')" : "@lang('Invalid api key')"}
                                            {"@lang('error')" : "@lang('Invalid Service Id')"}
                                            {"@lang('error')" : "@lang('The link field is required')"}
                                            {"@lang('error')" : "@lang('The quantity field is required')"}
                                            {"@lang('error')" : "@lang('Please follow the limit')"}
                                            {"@lang('error')" : "@lang('Insufficient balance')"}
                                        </code>
                                    </pre>
                                </div>
                                <div class="api-card__code mb-3">
                                    <h6 class="title mb-3"><i class="las la-arrow-circle-right"></i> @lang('Order Status:')</h6>
                                    <ul class="api-list">
                                        <li class="api-list__item">
                                            <span class="title">@lang('Required Parameter')</span>
                                            <span class="title">@lang('Content')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('key')</span>
                                            <span class="desc">@lang('Your API Key')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('action')</span>
                                            <span class="desc">"status"</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('order')</span>
                                            <span class="desc">@lang('Order ID')</span>
                                        </li>
                                    </ul>
                                    <h6 class="title text--success my-3">@lang('Order Status Success Response'):</h6>
                                    <pre class="rounded-2">
                                        <code class="language-php">
                                            {
                                                "status" : "Pending",
                                                "start_count" : "1000",
                                                "remains" : "500",
                                                "currency" : USD
                                            }
                                        </code>
                                    </pre>
                                    <ul class="api-list">
                                        <li class="api-list__item">
                                            <h5 class="title">@lang('Available status')</h5>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter text--warning">@lang('Pending')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter text--info">@lang('Processing')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter text--success">@lang('Complete')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter text--danger">@lang('Order Cancelled')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter text--dark">@lang('Refunded')</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="api-card__code mb-5">
                                    <h6 class="title text--danger mb-3">@lang('Order Status Error Response'):</h6>
                                    <pre class="rounded-3">
                                        <code class="language-php">
                                            {"@lang('error')" : "@lang('The action field is required')"}
                                            {"@lang('error')" : "@lang('The api key field is required')"}
                                            {"@lang('error')" : "@lang('Invalid api key')"}
                                            {"@lang('error')" : "@lang('Invalid action')"}
                                            {"@lang('error')" : "@lang('The order field is required')"}
                                            {"@lang('error')" : "@lang('Invalid Order Id')"}
                                        </code>
                                    </pre>
                                </div>
                                <div class="api-card__code mb-3">
                                    <h6 class="title mb-3"><i class="las la-arrow-circle-right"></i> @lang('Order Refill:')
                                    </h6>
                                    <ul class="api-list">
                                        <li class="api-list__item">
                                            <span class="title">@lang('Required Parameter')</span>
                                            <span class="title">@lang('Content')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('key')</span>
                                            <span class="desc">@lang('Your API Key')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('action')</span>
                                            <span class="desc">"refill"</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('order')</span>
                                            <span class="desc">@lang('Order ID')</span>
                                        </li>
                                    </ul>
                                    <h6 class="title text--success my-3">@lang('Order Refill Success Response'):</h6>
                                    <pre class="rounded-2">
                                        <code class="language-php">
                                            {
                                                "success": "Your order will be refill asap. Thank you for patience",
                                                "refill": 12345
                                            }
                                        </code>
                                    </pre>
                                </div>
                                <div class="api-card__code mb-5">
                                    <h6 class="title text--danger my-3">@lang('Order Refill Error Response'):</h6>
                                    <pre class="rounded-3">
                                        <code class="language-php">
                                            {"@lang('error')" : "@lang('Order not eligible for refill')"}
                                        </code>
                                    </pre>
                                </div>
                                <div class="api-card__code mb-5">
                                    <h6 class="title mb-3"><i class="las la-arrow-circle-right"></i> @lang('Get Refill Status:')
                                    </h6>
                                    <ul class="api-list">
                                        <li class="api-list__item">
                                            <span class="title">@lang('Required Parameter')</span>
                                            <span class="title">@lang('Content')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('key')</span>
                                            <span class="desc">@lang('Your API Key')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('action')</span>
                                            <span class="desc">"refill_status"</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('refill ')</span>
                                            <span class="desc">@lang('Refill  ID')</span>
                                        </li>
                                    </ul>
                                    <h6 class="title text--success my-3">@lang('Refill Status Success Response'):</h6>
                                    <pre class="rounded-2">
                                        <code class="language-php">
                                            {
                                                "status": "Completed"
                                            }
                                        </code>
                                    </pre>
                                </div>
                                <div class="api-card__code mb-3">
                                    <h6 class="title mb-3"><i class="las la-arrow-circle-right"></i> @lang('User Balance:')
                                    </h6>
                                    <ul class="api-list">
                                        <li class="api-list__item">
                                            <span class="title">@lang('Required Parameter')</span>
                                            <span class="title">@lang('Content')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('key')</span>
                                            <span class="desc">@lang('Your API Key')</span>
                                        </li>
                                        <li class="api-list__item">
                                            <span class="parameter">@lang('action')</span>
                                            <span class="desc">"balance"</span>
                                        </li>
                                    </ul>
                                    <h6 class="title text--success my-3">@lang('User Balance Success Response'):</h6>
                                    <pre class="rounded-2">
                                        <code class="language-php">
                                            {
                                                "balance": "100.84292",
                                                "currency" :" USD"
                                            }
                                        </code>
                                    </pre>
                                </div>
                                <div class="api-card__code mb-5">
                                    <h6 class="title text--danger">@lang('User Balance Error Response'):</h6>
                                    <pre class="rounded-3">
                                        <code class="language-php">
                                            {"@lang('error')" : "@lang('The action field is required')"}
                                            {"@lang('error')" : "@lang('The api key field is required')"}
                                            {"@lang('error')" : "@lang('Invalid api key')"}
                                        </code>
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .dashboard .api-card {
            padding: 30px 60px;
        }
    </style>
@endpush
