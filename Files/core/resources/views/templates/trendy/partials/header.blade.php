@php
    $pages = App\Models\Page::where('tempname', $activeTemplate)
        ->where('is_default', Status::NO)
        ->get();
@endphp
<header class="header" id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logo" href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="Site Logo"></a>
            <button class="navbar-toggler header-button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" type="button" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span id="hiddenNav"><i class="las la-bars"></i></span>
            </button>
            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <ul
                    class="navbar-nav nav-menu primary-nav align-items-lg-center justify-content-end flex-grow-1 ms-auto">
                    <li class="nav-item {{ menuActive('home') }}">
                        <a class="nav-link" href="{{ route('home') }}">@lang('Home')</a>
                    </li>
                    @foreach ($pages->sortBy('name') as $k => $data)
                        <li class="nav-item {{ menuActive('pages', null, $data->slug) }}">
                            <a class="nav-link" href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a>
                        </li>
                    @endforeach
                    <li class="nav-item {{ menuActive('services') }}">
                        <a class="nav-link" href="{{ route('services') }}"> @lang('Services') </a>
                    </li>
                    <li class="nav-item {{ menuActive('blog') }}">
                        <a class="nav-link" href="{{ route('blog') }}"> @lang('Blogs') </a>
                    </li>
                    <li class="nav-item {{ menuActive('contact') }}">
                        <a class="nav-link" href="{{ route('contact') }}"> @lang('Contact') </a>
                    </li>
                </ul>
                <div class="top-button nav-item d-lg-none flex-between align-items-center">
                    <ul class="login-registration-list d-flex align-items-center flex-wrap">
                        @guest
                            <li class="login-registration-list__item login">
                                <a class="login-registration-list__link" href="{{ route('user.login') }}">
                                    @lang('Sign In')
                                </a>
                            </li>
                            <li class="login-registration-list__item get-start">
                                <a class="login-registration-list__link btn btn--base nav-btn"
                                    href="{{ route('user.register') }}">
                                    @lang('Get Started')
                                </a>
                            </li>
                        @endguest
                        @auth
                            <li class="login-registration-list__item get-start">
                                <a class="login-registration-list__link btn btn--base nav-btn"
                                    href="{{ route('user.home') }}">
                                    @lang('Dashboard')
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
                <ul class="navbar-nav nav-menu align-items-lg-center d-none d-lg-flex ms-auto">
                    @auth
                        @php
                            $routeName = Route::currentRouteName();
                            $routePrefix = explode('.', $routeName)[0];
                        @endphp
                        <li class="nav-item">
                            @if ($routePrefix == 'user')
                                <a class="btn btn--base nav-btn d-inline" href="{{ route('user.logout') }}">
                                    <i class="las la-sign-out-alt"></i> @lang('Logout')
                                </a>
                            @else
                                <a class="btn btn--base nav-btn d-inline" href="{{ route('user.home') }}">
                                    <i class="las la-tachometer-alt"></i> @lang('Dashboard')
                                </a>
                            @endif
                        </li>
                    @endauth
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.login') }}"> @lang('Sign In') </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn--base nav-btn d-inline" href="{{ route('user.register') }}">
                                @lang('Get Started')
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
    </div>
</header>
