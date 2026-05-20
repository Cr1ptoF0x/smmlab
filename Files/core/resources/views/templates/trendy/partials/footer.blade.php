@php
    $footerContent = getContent('footer.content', true);
    $footerElements = getContent('footer.element', false, 5, true);
    $policyPages = getContent('policy_pages.element', false, null, true);
    $pages = App\Models\Page::where('tempname', $activeTemplate)->where('is_default', Status::NO)->get();
@endphp
<footer class="footer-area">
    <div class="container">
        <div class="main-footer">
            <div class="row">
                <div class="col-xl-6 col-md-6 order-1">
                    <div class="footer-item footer-content">
                        <div class="footer-item__logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ siteLogo('dark') }}" alt="site logo" alt="Site Logo" /></a>
                        </div>
                        <p class="footer-item__desc">
                            {{ __($footerContent->data_values->subscribe_title) }}
                        </p>
                        <form class="email-form flex-align call-to-action-form">
                            <input required class="form--control" id="email" name="email" type="email" placeholder="@lang('Enter your email')" />
                            <button class="btn btn--base" type="submit"> {{ __($footerContent->data_values->subscribe_button) }}</button>
                        </form>
                    </div>
                </div>
                <div class="col-xl-2 col-md-3 col-6 col-xsm-6 order-3">
                    <div class="footer-item">
                        <h6 class="footer-item__title">@lang('Quick Link')</h6>
                        <ul class="footer-menu">
                            @foreach ($pages as $data)
                                <li class="footer-menu__item">
                                    <a class="footer-menu__link" href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a>
                                </li>
                            @endforeach
                            <li class="footer-menu__item">
                                <a class="footer-menu__link" href="{{ route('contact') }}">@lang('Contact')</a>
                            </li>
                            <li class="footer-menu__item">
                                <a class="footer-menu__link" href="{{ route('services') }}">@lang('Services')</a>
                            </li>
                            <li class="footer-menu__item">
                                <a class="footer-menu__link" href="{{ route('api.documentation') }}">@lang('API Documentation')</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-md-3 col-6 col-xsm-6 order-4">
                    <div class="footer-item">
                        <h6 class="footer-item__title">@lang('Privacy and Terms')</h6>
                        <ul class="footer-menu">
                            @foreach ($policyPages as $policy)
                                <li class="footer-menu__item">
                                    <a class="footer-menu__link" href="{{ route('policy.pages', $policy->slug) }}"> {{ __($policy->data_values->title) }} </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-xl-2 col-md-3 order-md-4 order-2">
                    <div class="footer-item social-menu">
                        <h6 class="footer-item__title">{{ __($footerContent->data_values->social_heading) }}</h6>
                        <ul class="social-list">
                            @foreach ($footerElements as $footerElement)
                                <li class="social-list__item flex-align">
                                    <a class="social-list__link flex-center footer-menu__link" target="_blank" href="{{ $footerElement->data_values->social_url }}">
                                        <img class="social-item__icon" src="{{ frontendImage('footer', @$footerElement->data_values->social_image, '24x24') }}" alt="social media" />
                                        <span class="text"> {{ __($footerElement->data_values->social_name) }} </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-footer py-3">
            <div class="d-flex justify-content-between flex-wrap gap-2">
                <p class="bottom-footer-text text-center text-white">
                    @lang('Copyright') &copy; {{ date('Y') }}. @lang('All Rights Reserved By') <a class="t-link" href="{{ route('home') }}">{{ __(gs('site_name')) }}</a>
                </p>
                @if (gs('multi_language'))
                    <div class="language-box">
                        @include($activeTemplate . 'partials.language')
                    </div>
                @endif
            </div>
        </div>
    </div>
</footer>

@push('script')
    <script>
        (function($) {
            "use strict";

            $(document).on('submit', '.call-to-action-form', function(e) {
                e.preventDefault();
                var email = $('[name="email"]').val();
                if (!email) {
                    notify('error', 'Email field is required');
                } else {
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        url: "{{ route('subscribe') }}",
                        method: "POST",
                        data: {
                            email: email
                        },
                        success: function(response) {
                            if (response.success) {
                                notify('success', response.message);
                            } else {
                                notify('error', response.error);
                            }
                            $('input[name="email"]').val('');
                        }
                    });
                }

            });

        })(jQuery);
    </script>
@endpush
