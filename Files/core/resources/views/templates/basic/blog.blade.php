@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="news-section ptb-80" id="blog">
        <div class="container">
            <figure class="figure highlight-background highlight-background--lean-left">
                <img src="{{ getImage($activeTemplateTrue . 'images/svg/animation.svg') }}" alt="">
            </figure>
            <div class="news-area">
                <div class="row justify-content-center ml-b-30">
                    @forelse($blogElements as $item)
                        <div class="col-lg-4 col-md-6 col-sm-12 mrb-30">
                            <div class="news-item">
                                <div class="news-thumb">
                                    <img src="{{ frontendImage('blog', 'thumb_' . @$item->data_values->image, '480x280') }}" alt="@lang('blog')">
                                </div>
                                <div class="news-content">
                                    <h3 class="title">
                                        <a href="{{ route('blog.details', @$item->slug) }}">{{ __(@$item->data_values->title) }}</a>
                                    </h3>
                                    <p>{{ __(@$item->data_values->short_description) }}</p>
                                    <div class="news-btn">
                                        <a class="custom-btn" href="{{ route('blog.details', @$item->slug) }}">@lang('Read more..') <i class="ti-angle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-lg-4 col-md-6 col-sm-12 mrb-30">
                            {{ __($emptyMessage) }}
                        </div>
                    @endforelse
                </div>
                @if ($blogElements->hasPages())
                    {{ paginateLinks($blogElements) }}
                @endif
            </div>
        </div>
    </section>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
