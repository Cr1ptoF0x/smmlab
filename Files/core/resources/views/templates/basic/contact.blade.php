@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @php
        $contactContent = getContent('contact.content', true);
        $addressContent = getContent('address.content', true);
    @endphp
    <!-- contact-section start -->
    <section class="contact-section register-section ptb-80">
        <div class="container">
            <figure class="figure highlight-background highlight-background--lean-left">
                <img src="{{ getImage($activeTemplateTrue . 'images/svg/animation.svg') }}" alt="">
            </figure>
            <div class="row justify-content-center align-items-center ml-b-30">
                <div class="col-lg-6 mrb-30">
                    <div class="contact-thumb">
                        <img src="{{ frontendImage('contact', @$contactContent->data_values->image, '715x470') }}" alt="@lang('Contact')">
                    </div>
                </div>

                <div class="col-lg-6 mrb-30">
                    <div class="register-form-area">
                        <h3 class="title">@lang('Get In Touch')</h3>
                        <form class="register-form verify-gcaptcha" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input class="form--control" name="name" type="text" value="{{ old('name', @$user->fullname) }}" placeholder="@lang('Enter name')" @if ($user && $user->profile_complete) readonly @endif required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input class="form--control" name="email" type="text" value="{{ old('email', @$user->email) }}" placeholder="@lang('Enter e-mail address')" {{ $user ? 'readonly' : '' }} required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input class="form--control" name="subject" type="text" value="{{ old('subject') }}" placeholder="@lang('Enter subject')" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <textarea class="form--control" name="message" wrap="off" placeholder="@lang('Enter message')">{{ old('message') }}</textarea>
                                </div>
                            </div>

                            <x-captcha />

                            <button class="btn btn--base w-100 h-45" type="submit">@lang('Submit Now')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact-section end -->

    <!-- contact-info start -->
    <div class="contact-info-area ptb-80">
        <div class="container">
            <figure class="figure highlight-background highlight-background--lean-left">
                <img src="{{ getImage($activeTemplateTrue . 'images/svg/animation.svg') }}" alt="">
            </figure>
            <div class="contact-info-item-area">
                <div class="row justify-content-center align-items-center ml-b-30">
                    <div class="col-lg-4 col-md-6 col-sm-8 text-center mrb-30">
                        <div class="contact-info-item">
                            <i class="fas fa fa-map-marker-alt"></i>
                            <h3 class="title">@lang('Office Address')</h3>
                            <p>{{ __(@$addressContent->data_values->address) }}</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-8 text-center mrb-30">
                        <div class="contact-info-item active">
                            <i class="fas fa-envelope"></i>
                            <h3 class="title">@lang('Email Address')</h3>
                            <p>{{ __(@$addressContent->data_values->email) }}</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-8 text-center mrb-30">
                        <div class="contact-info-item">
                            <i class="fas fa-phone-alt"></i>
                            <h3 class="title">@lang('Phone Number')</h3>
                            <p>{{ __(@$addressContent->data_values->phone) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact-info end -->

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection

@push('script')
    <script>
        "use strict";
        (function($) {
            $('label').attr('for', 'captcha').remove();
            $('.mb-2').addClass('mb-3').removeClass('.mb-2');
            $('input[name=captcha]').attr('placeholder', `@lang('Captcha')`);
        })(jQuery);
    </script>
@endpush
