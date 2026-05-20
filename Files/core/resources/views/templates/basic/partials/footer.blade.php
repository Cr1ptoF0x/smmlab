@php
    $footerContent = getContent('footer.content', true);
    $footerElements = getContent('footer.element', null, false, true);
    $addressContent = getContent('address.content', true);
    $policyPages = getContent('policy_pages.element', null, false, true);
    $pages = App\Models\Page::where('tempname', $activeTemplate)->where('is_default', Status::NO)->get();
@endphp
<footer class="footer-section ptb-80">
    <div class="container">
        <div class="footer-area">
            <div class="row gy-4">
                <div class="col-lg-4 col-sm-8">
                    <div class="footer-widget widget-menu">
                        <div class="footer-logo">
                            <h3 class="widget-title">@lang('About Us')</h3>
                            <p>{{ __(@$footerContent->data_values->content) }}</p>
                            <div class="social-area">
                                <ul class="footer-social">
                                    @forelse($footerElements as $item)
                                        <li><a href="{{ @$item->data_values->social_url }}" target="_blank">@php echo @$item->data_values->social_icon @endphp</a>
                                        </li>
                                    @empty
                                        <li>{{ __($emptyMessage) }}</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <div class="footer-widget">
                        <h3 class="widget-title">@lang('Quick Link')</h3>
                        <ul>
                            @foreach ($pages as $data)
                                <li><a href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a></li>
                            @endforeach
                            <li><a href="{{ route('contact') }}">@lang('Contact')</a></li>
                            <li><a href="{{ route('api.documentation') }}">@lang('API Documentation')</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="footer-widget">
                        <h3 class="widget-title">@lang('Privacy and Terms')</h3>
                        <ul>
                            @forelse($policyPages as $policy)
                                <li>
                                    <a href="{{ route('policy.pages', $policy->slug) }}">{{ __($policy->data_values->title) }}</a>
                                </li>
                            @empty
                                <li>{{ __($emptyMessage) }}</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="footer-widget widget-menu">
                        <h3 class="widget-title">@lang('Contact Info')</h3>
                        <ul class="footer-contact-list">
                            <li>{{ __(@$addressContent->data_values->address) }}</li>
                            <li>@lang('Call Us Now') {{ @$addressContent->data_values->phone }}</li>
                            <li><a href="mailto:{{ @$addressContent->data_values->email }}">{{ @$addressContent->data_values->email }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
