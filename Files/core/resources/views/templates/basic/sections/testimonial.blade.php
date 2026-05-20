@php
    $testimonialContent = getContent('testimonial.content', true);
    $testimonialElements = getContent('testimonial.element', null, false, true);
@endphp
<div class="client-section ptb-80 bg_img" data-background="{{ getImage($activeTemplateTrue . 'images/client-bg.png') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-header">
                    <h2 class="section-title">{{ __(@$testimonialContent->data_values->heading) }}</h2>
                    <span class="title-border"></span>
                </div>
            </div>
        </div>
        <div class="row justify-content-center ml-b-20">
            <div class="col-lg-12">
                <div class="client-slider">
                    <div class="swiper-wrapper">
                        @foreach ($testimonialElements as $item)
                            <div class="swiper-slide">
                                <div class="client-item">
                                    <div class="client-content">
                                        <div class="client-details">
                                            <div class="client-ratings">
                                                @php
                                                    $rating = @$item->data_values->rating;
                                                    $noRating = 5 - $rating;
                                                @endphp
                                                @for ($i = 1; $i <= $rating; $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                                @for ($i = 1; $i <= $noRating; $i++)
                                                    <i class="far fa-star"></i>
                                                @endfor
                                            </div>
                                            <p>{{ __(@$item->data_values->review) }}</p>
                                        </div>
                                        <div class="client-bottom">
                                            <div class="client-thumb">
                                                <img src="{{ frontendImage('testimonial', @$item->data_values->image, '70x70') }}" alt="@lang('client')">
                                            </div>
                                            <div class="client-title">
                                                <h3 class="title">{{ __(@$item->data_values->name) }}</h3>
                                                <span class="sub-title">{{ __(@$item->data_values->designation) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</div>
