@php
    $contactContent = getContent('contact.content', true);
    $contactElements = getContent('contact.element', false, 3);
@endphp

@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="contact-page pt-60">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-9">
                    <div class="section-heading heading-three">
                        <p class="section-heading__sub-title"> {{ __($contactContent->data_values->title) }} </p>
                        <h2 class="section-heading__title"> {{ __($contactContent->data_values->heading) }}</h2>
                    </div>
                </div>
            </div>
            <form class="verify-gcaptcha" method="post" action="">
                @csrf
                <div class="row gy-5">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-6 col-xsm-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Name')</label>
                                    <input class="form--control" name="name" type="text" value="{{ old('name', @$user->fullname) }}" @if ($user && $user->profile_complete) readonly @endif required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-6 col-xsm-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Email')</label>
                                    <input class="form--control" name="email" type="email" value="{{ old('email', @$user->email) }}" @if ($user) readonly @endif required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form--label">@lang('Subject')</label>
                                    <input class="form--control" name="subject" type="text" value="{{ old('subject') }}" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form--label">@lang('Message')</label>
                                    <textarea class="form--control" name="message" wrap="off" required>{{ old('message') }}</textarea>
                                </div>
                            </div>

                            <x-captcha />

                            <div class="col-12">
                                <button class="btn btn--base contact-form-submit"> @lang('Submit')</button>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-thumb">
                            <span class="contact-thumb__shape contact-thumb__img">
                                <img src="{{ asset($activeTemplateTrue . 'images/shapes/contact-thumb-shape.png') }}" alt="" />
                            </span>
                            <span class="contact-thumb__main-img contact-thumb__img">
                                <img src="{{ frontendImage('contact', @$contactContent->data_values->image, '555x580') }}" alt="" />
                            </span>
                        </div>
                    </div>
                </div>
            </form>
            <div class="contact-info py-60">
                <div class="row gy-3 justify-content-center">
                    @foreach ($contactElements as $contact)
                        <div class="col-md-4 col-sm-6 col-xsm-6">
                            <div class="info-card">
                                <span class="info-card__icon">
                                    <img src="{{ frontendImage('contact', @$contact->data_values->icon_photo, '40x40') }}" alt="icons">
                                </span>
                                <h5 class="info-card__title"> {{ __($contact->data_values->title) }} </h5>
                                <p class="info-card__desc"> {{ __($contact->data_values->sub_title) }} </p>
                                @if (in_array(@$contact->data_values->contact_type, ['mailto', 'tel']))
                                    <a class="text--base info-card__footer" href="{{ @$contact->data_values->contact_type }}:{{ @$contact->data_values->content }}"> {{ $contact->data_values->content }} </a>
                                @else
                                    <p class="desc">{{ __(@$contact->data_values->content) }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif

@endsection
@push('script')
    <script>
        (function($) {
            "use strict";

            $('[name=captcha]').siblings('label').removeClass('form-label').addClass('form--label');

        })(jQuery)
    </script>
@endpush
