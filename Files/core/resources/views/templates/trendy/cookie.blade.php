@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="py-100">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="card-title pb-5 text-center">{{ __($pageTitle) }}</h3>
                    <p>
                        @php
                            echo $cookie->data_values->description;
                        @endphp
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
