@php
    $testimonialContent = getContent('testimonial.content', true);
    $testimonialElements = getContent('testimonial.element', false);
@endphp

<section class="testimonials pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-8">
                <div class="section-heading style-left">
                    <p class="section-heading__sub-title"> {{ __(@$testimonialContent->data_values->heading_top) }} </p>
                    <h2 class="section-heading__title">
                        {{ __(@$testimonialContent->data_values->heading) }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="testimonial-slider">
            @foreach ($testimonialElements as $testimonialElement)
                <div class="testimonials-card">
                    <div class="testimonial-item">
                        <div class="testimonial-item__content">
                            <img class="user-thumb testimonial-item__thumb" src="{{ frontendImage('testimonial', @$testimonialElement->data_values->image, '75x75') }}" alt="" alt="testimonial photo" />
                            <div class="testimonial-item__icon flex-center">
                                <img class="icon" src="{{ asset($activeTemplateTrue . 'images/icons/quote-icon01.png') }}" alt="" />
                            </div>
                        </div>
                        <div class="testimonial-item__details">
                            <h5 class="testimonial-item__name"> {{ __(@$testimonialElement->data_values->name) }} </h5>
                            <p class="testimonial-item__designation"> {{ __(@$testimonialElement->data_values->designation) }} </p>
                        </div>
                        <div class="testimonial-item__rating">
                            @php
                                $rating = @$testimonialElement->data_values->rating;
                                $noRating = 5 - $rating;
                            @endphp
                            <ul class="rating-list">
                                @for ($i = 1; $i <= $rating; $i++)
                                    <li class="rating-list__item"><i class="fas fa-star"></i></li>
                                @endfor
                                @for ($i = 1; $i <= $noRating; $i++)
                                    <li class="rating-list__item"><i class="far fa-star"></i></li>
                                @endfor
                            </ul>
                        </div>
                        <p class="testimonial-item__desc">
                            {{ __(@$testimonialElement->data_values->review) }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@push('style-lib')
    <link href="{{ asset($activeTemplateTrue . 'css/slick.css') }}" rel="stylesheet">
@endpush
@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            ("use strict");

            $(".testimonial-slider").slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: false,
                autoplaySpeed: 2000,
                speed: 1500,
                dots: true,
                pauseOnHover: true,
                arrows: false,
                prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-right"></i></button>',
                responsive: [{
                        breakpoint: 1199,
                        settings: {
                            arrows: false,
                            slidesToShow: 2,
                            dots: true,
                        },
                    },
                    {
                        breakpoint: 991,
                        settings: {
                            arrows: false,
                            slidesToShow: 2,
                        },
                    },
                    {
                        breakpoint: 560,
                        settings: {
                            arrows: false,
                            slidesToShow: 1,
                        },
                    },
                ],
            });

        })(jQuery);
    </script>
@endpush
