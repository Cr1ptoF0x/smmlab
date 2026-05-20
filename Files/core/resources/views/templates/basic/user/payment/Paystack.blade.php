@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center gy-4 py-5">
        <div class="col-lg-8">
                <h5 class="deposit-card-title">@lang('Paystack')</h5>
                <div class="card-body">
                    <form class="text-center dashboard-form" action="{{ route('ipn.' . $deposit->gateway->alias) }}" method="POST">
                        @csrf
                        <ul class="list-group text-center">
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('You have to pay '):
                                <strong>{{ showAmount($deposit->final_amount) }}
                                    {{ __($deposit->method_currency) }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('You will get '):
                                <strong>{{ showAmount($deposit->amount) }}</strong>
                            </li>
                        </ul>
                        <button class="btn btn--base w-100 h-45 mt-3" id="btn-confirm" type="button">@lang('Pay Now')</button>
                        <script src="//js.paystack.co/v1/inline.js" data-key="{{ $data->key }}" data-email="{{ $data->email }}"
                                data-amount="{{ round($data->amount) }}" data-currency="{{ $data->currency }}" data-ref="{{ $data->ref }}"
                                data-custom-button="btn-confirm"></script>
                    </form>
                </div>
        </div>
    </div>
@endsection
