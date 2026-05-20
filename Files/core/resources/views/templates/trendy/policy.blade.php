@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="py-100">
        <div class="container">
            <h3 class="card-title pb-5 text-center">{{ __($pageTitle) }}</h3>
            @php
                echo $policy->data_values->content;
            @endphp
        </div>
    </section>
@endsection
