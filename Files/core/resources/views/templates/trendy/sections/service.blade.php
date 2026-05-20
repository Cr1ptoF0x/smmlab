@php
    $serviceContent = getContent('service.content', true);
    $serviceElements = getContent('service.element', false);
@endphp

<div class="service-section pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-8">
                <div class="section-heading style-left">
                    <p class="section-heading__sub-title"> {{ __(@$serviceContent->data_values->heading) }} </p>
                    <h2 class="section-heading__title"> {{ __(@$serviceContent->data_values->sub_heading) }} </h2>

                </div>
            </div>
        </div>
        <div class="custom-card">
            <div class="row g-md-4 g-3 justify-content-center">
                @foreach ($serviceElements as $serviceElement)
                    <div class="col-lg-4 col-sm-6 col-xsm-6">
                        <div class="template-card">
                            <div class="template-card__icon">
                                <img class="icon" src="{{ frontendImage('service', @$serviceElement->data_values->social_image, '60x60') }}">
                                <img class="arrow" src="{{ getImage($activeTemplateTrue . 'images/shapes/theree-arrow.png') }}">
                            </div>
                            <div class="template-card__content">
                                <h5 class="template-card__title"> {{ __(@$serviceElement->data_values->title) }} </h5>
                                <p class="template-card__desc">
                                    {{ __(@$serviceElement->data_values->content) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
