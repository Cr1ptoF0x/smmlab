@php
    $actionContent = getContent('action.content', true);
@endphp

<div class="contact-section py-60">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-9">
                <div class="section-heading heading-three">
                    <h2 class="section-heading__title"> {{ __(@$actionContent->data_values->heading) }} </h2>
                    <p class="section-heading__desc">
                        {{ __(@$actionContent->data_values->sub_heading) }}
                    </p>
                    <a href="{{ url(@$actionContent->data_values->button_url) }}" class="btn btn--base"> {{ __(@$actionContent->data_values->button) }} </a>
                </div>
            </div>
            <div class="col-xl-5 col-lg-3">
                <div class="contact-section__thumb">
                    <img alt="" src="{{ frontendImage('action', @$actionContent->data_values->image, '325x310') }}" />
                </div>
            </div>
        </div>
    </div>
</div>
