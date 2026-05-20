@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 mb-4">
                <div class="card--body">
                    <form action="{{ route('admin.dripfeed.update', $order->id) }}" method="post">
                        @csrf
                        <div class="card-body p-0">
                            <div class="table-responsive--sm table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>@lang('Order ID')</th>
                                            <td class="text-start">{{ $order->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('User')</th>
                                            <td class="text-start">
                                                <a href="{{ route('admin.users.detail', $order->user_id) }}">
                                                    {{ __($order->user->username) }}
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Category')</th>
                                            <td class="text-start">
                                                {{ __($order->category->name) }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>@lang('Service')</th>
                                            <td class="text-start">
                                                {{ __($order->service->name) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Link')</th>
                                            <td class="text-start">
                                                <a href="{{ empty(parse_url($order->link, PHP_URL_SCHEME)) ? 'https://' : null }}{{ $order->link }}"
                                                    target="_blank">{{ $order->link }}
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Quantity')</th>
                                            <td class="text-start">{{ $order->quantity }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Start Counter')</th>
                                            <td class="text-start">
                                                @if ($order->status == Status::ORDER_PENDING || $order->status == Status::ORDER_PROCESSING)
                                                    <input type="text" name="start_count" max="{{ $order->quantity }}"
                                                        value="{{ $order->start_counter }}" class="form-control" required>
                                                @else
                                                    {{ $order->start_counter }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Remains')</th>
                                            <td class="text-start">{{ $order->remain }}
                                            </td>
                                        </tr>

                                        @if ($order->api_order)
                                            <tr>
                                                <td>@lang('API Order')</td>
                                                <td class="text-start">
                                                    @if ($order->api_order)
                                                        <span class="badge  badge--primary">@lang('Yes')</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if ($order->order_placed_to_api)
                                                <tr>
                                                    <td>@lang('API Order ID')</td>
                                                    <td class="text-start">
                                                        <strong>{{ @$order->api_order_id }}</strong>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>@lang('Order Placed To API')</td>
                                                <td class="text-start">
                                                    @if ($order->order_placed_to_api)
                                                        <span class="badge  badge--primary">@lang('Yes')</span>
                                                    @else
                                                        <span class="badge  badge--danger">@lang('No')</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <th>@lang('Status')</th>
                                            <td class="text-start">
                                                @if ($order->status == Status::ORDER_PENDING || $order->status == Status::ORDER_PROCESSING)
                                                    <select class="form-control" name="status" required>
                                                        <option>@lang('Select Status')</option>
                                                        <option value="0" @selected($order->status == Status::ORDER_PENDING)>
                                                            @lang('Pending')</option>
                                                        <option value="1" @selected($order->status == Status::ORDER_PROCESSING)>
                                                            @lang('Processing')</option>
                                                        <option value="2" @selected($order->status == Status::ORDER_COMPLETED)>
                                                            @lang('Completed')</option>
                                                        <option value="3" @selected($order->status == Status::ORDER_CANCELLED)>
                                                            @lang('Cancelled')</option>
                                                        <option value="4" @selected($order->status == Status::ORDER_REFUNDED)>
                                                            @lang('Refunded')</option>
                                                    </select>
                                                @elseif($order->status == Status::ORDER_COMPLETED)
                                                    <span class="badge  badge--success">@lang('Completed')</span>
                                                @elseif($order->status == Status::ORDER_CANCELLED)
                                                    <span class="badge  badge--danger">@lang('Cancelled')</span>
                                                @else
                                                    <span class="badge  badge--dark">@lang('Refunded')</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if ($order->status == Status::ORDER_PENDING || $order->status == Status::ORDER_PROCESSING)
                            <div class="card-footer">
                                <button type="submit" class="btn btn--primary w-100 h-45 ">@lang('Submit')</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div><!-- card end -->
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ url()->previous() }}" />
@endpush
