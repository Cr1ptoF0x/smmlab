@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row mb-none-30">
        <div class="col-xl-12">
            <div class="card">
                <form action="{{ route('user.order.mass.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group col-md-12">
                            <label class="fw-bold mb-2" for="mass_order">
                                <h5>@lang("Place mass order (Press 'Enter' button for every new order)").</h5>
                            </label>
                            <textarea class="form-control form--control" id="mass_order" name="mass_order" placeholder="service_id|link|quantity
service_id|link|quantity
service_id|link|quantity" cols="30" rows="20">{{ old('mess_order') }}</textarea>
                        </div>
                        <div class="form-group col-md-12 text-center">
                            <button class="btn btn--base w-100 h-45 mr-2" type="submit">@lang('Place Order')</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        #mass_order {
            min-height: 250px;
        }
    </style>
@endpush
