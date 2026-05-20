@php
    $aboutContent = getContent('about.content', true);
    $aboutElements = getContent('about.element', false, 4);
@endphp

<section class="about-section py-60">
    <div class="container">
        <div class="row">
            <div class="col-md-6">

                <div class="section-heading style-left">
                    <p class="section-heading__sub-title"> {{ __(@$aboutContent->data_values->title_top) }} </p>
                    <h2 class="section-heading__title"> {{ __(@$aboutContent->data_values->title) }} </h2>
                    <p class="section-heading__desc">
                        {{ __(@$aboutContent->data_values->description) }}
                    </p>
                </div>
                <div class="about-section-content">
                    @foreach ($aboutElements as $aboutElement)
                        <div class="counter-list">
                            <i class="counter-list__icon">
                                <img src="{{ frontendImage('about',@$aboutElement->data_values->image, '45x45') }}" alt="">
                            </i>
                            <div class="counter-list__content">
                                <h2 class="counter-list__title counterup-item" data-odometer-final="1000"> {{ @$aboutElement->data_values->count }} <span
                                          class="extra"><i class="fa fa-plus"></i></span>
                                </h2>
                                <p class="counter-list__desc"> {{ __(@$aboutElement->data_values->title) }} </p>
                            </div>
                        </div>
                    @endforeach

                </div>
                <a class="btn btn--base" href="{{ __(@$aboutContent->data_values->button_link) }}"> {{ __(@$aboutContent->data_values->button) }} </a>

            </div>
            <div class="col-md-6">
                <div class="about-section-banner">
                    <img src="{{ frontendImage('about',@$aboutContent->data_values->image, '640x770') }}" alt="about">
                </div>
            </div>
        </div>
    </div>
</section>
