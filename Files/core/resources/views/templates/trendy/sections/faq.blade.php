@php
    $faqContent = getContent('faq.content', true);
    $faqElements = getContent('faq.element', false);
@endphp

<section class="py-100">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-6">
                <div class="section-heading heading-three">
                    <h2 class="section-heading__title"> {{ __(@$faqContent->data_values->heading) }} </h2>
                    <p class="section-heading__desc">
                        {{ __(@$faqContent->data_values->sub_heading) }}
                    </p>
                </div>
                <div class="polygon-shape">
                    <img src="{{ frontendImage('faq', @$faqContent->data_values->image, '230x190') }}" alt="faq">
                </div>
            </div>

            <div class="col-md-6">
                <div class="accordion custom--accordion" id="accordionExample">
                    @foreach ($faqElements as $key => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button @if (!$loop->first) collapsed @endif" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $key }}" type="button" aria-expanded="{{ $key == 0 ? 'true' : 'false' }}" aria-controls="panelsStayOpen-collapseOne">
                                    {{ __(@$faq->data_values->question) }}
                                </button>
                            </h2>
                            <div class="accordion-collapse {{ $key == 0 ? 'show' : '' }} collapse" id="collapseOne{{ $key }}" data-bs-parent="#accordionExample">
                                <p class="accordion-body">
                                    {{ __(@$faq->data_values->answer) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
