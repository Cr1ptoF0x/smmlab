@php
    $processContent = getContent('process.content', true);
    $processElements = getContent('process.element', false);
@endphp

<div class="process-section py-60">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-9">
                <div class="section-heading style-left">
                    <p class="section-heading__sub-title text-white"> {{ __(@$processContent->data_values->title) }} </p>
                    <h2 class="section-heading__title"> {{ __(@$processContent->data_values->heading) }} </h2>
                    <h2 class="section-heading__title-alt"> {{ __(@$processContent->data_values->heading_two) }} </h2>
                    <p class="section-heading__desc">
                        {{ __(@$processContent->data_values->sub_heading) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="custom-card">
            <div class="row g-md-4 g-3 justify-content-center">
                @foreach ($processElements as $processElement)
                    <div class="col-md-4">
                        <div class="template-card text-md-start text-center">
                            <div class="template-card__icon">
                                <img class="icon" src="{{ frontendImage('process', @$processElement->data_values->image, '60x60') }}" alt="">
                                <img class="arrow" src="{{ getImage($activeTemplateTrue . 'images/shapes/three-arrow.png') }}" alt="">
                            </div>
                            <div class="template-card__content">
                                <h5 class="template-card__title"> {{ __(@$processElement->data_values->title) }} </h5>
                                <p class="template-card__desc"> {{ __(@$processElement->data_values->content) }} </p>
                            </div>
                            <a class="template-card__link" href="{{ url(@$processElement->data_values->button_link) }}"> {{ __(@$processElement->data_values->button) }} <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="cta-btn text-center ">
                <a class="btn btn--base" href="{{ url(@$processContent->data_values->button_link) }}"> {{ __(@$processContent->data_values->button) }} </a>
            </div>
        </div>
    </div>
</div>
