@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="blog py-60">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                @foreach ($blogElements as $blogElement)
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-item">
                            <div class="blog-item__thumb">
                                <a class="blog-item__thumb-link" href="{{ route('blog.details', @$blogElement->slug) }}">
                                    <img class="img-fluid" src="{{ frontendImage('blog', 'thumb_' . @$blogElement->data_values->image, '415x310') }}" alt="blog">
                                </a>
                            </div>
                            <div class="blog-item__content">
                                <ul class="text-list flex-align gap-3">
                                    <li class="text-list__item date fs-14"><i class="las la-clock"></i> {{ showDateTime($blogElement->created_at, 'd M Y') }} </li>
                                </ul>
                                <h4 class="blog-item__title">
                                    <a class="blog-item__title-link border-effect" href="{{ route('blog.details', @$blogElement->slug) }}"> {{ __($blogElement->data_values->title) }} </a>
                                </h4>
                                <p class="blog-item__desc">
                                    {{ __($blogElement->data_values->short_description) }}
                                </p>
                                <a class="blog-item__link" class="btn--simple" href="{{ route('blog.details', @$blogElement->slug) }}">@lang('Read More')
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($blogElements->hasPages()) 
                <div class="mt-5">
                    {{ paginateLinks($blogElements) }}
                </div>
            @endif

        </div>
    </section>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif

@endsection
