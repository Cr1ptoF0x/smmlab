@php
    $clientContent = getContent('client.content', true);
    $clientElements = getContent('client.element', false);
@endphp
<div class="client pb-120 pt-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <p class="client-title"> {{ __(@$clientContent->data_values->heading) }} </p>
            </div>
        </div>
        <div class="client-logos">
            @foreach ($clientElements as $image)
                <img src="{{ frontendImage('client',@$image->data_values->image, '140x30') }}" alt="img">
            @endforeach
        </div>
    </div>
</div>
