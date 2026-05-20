@php
    @$blogContent = getContent('blog.content', true);
    $blogElements = getContent('blog.element', false, 3);
@endphp

<section class="blog py-60">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-9">
                <div class="section-heading heading-three">
                    <p class="section-heading__sub-title"> {{ __(@$blogContent->data_values->heading) }} </p>
                    <h2 class="section-heading__title"> {{ __(@$blogContent->data_values->sub_heading) }} </h2>
                    <p class="section-heading__desc">
                        {{ __(@$blogContent->data_values->description) }}
                    </p>
                </div>
            </div>
            <div class="col-xl-5 col-lg-3">
                <div class="get-all-btn"><a class="btn btn--base" href="{{ route('blog') }}"> {{ __(@$blogContent->data_values->button_text) }} </a></div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @foreach ($blogElements as $blogElement)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item">
                        <div class="blog-item__thumb">
                            <a class="blog-item__thumb-link" href="{{ route('blog.details', @$blogElement->slug) }}">
                                <img class="img-fluid" src="{{ frontendImage('blog', 'thumb_' . @$blogElement->data_values->image, '415x310') }}" alt="{{ @$blogElement->data_values->title }}">
                            </a>
                        </div>
                        <div class="blog-item__content">
                            <ul class="text-list flex-align gap-3">
                                <li class="text-list__item date fs-14"><i class="las la-clock"></i> {{ showDateTime(@$blogElement->created_at, 'd M Y') }} </li>
                            </ul>
                            <h4 class="blog-item__title">
                                <a class="blog-item__title-link border-effect" href="{{ route('blog.details', @$blogElement->slug) }}"> {{ __(@$blogElement->data_values->title) }} </a>
                            </h4>
                            <p class="blog-item__desc">
                                {{ __(strip_tags(@$blogElement->data_values->short_description)) }}
                            </p>
                            <a class="blog-item__link" class="btn--simple" href="{{ route('blog.details', @$blogElement->slug) }}">@lang('Read More')
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
