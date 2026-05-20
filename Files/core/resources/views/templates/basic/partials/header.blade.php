@php
    $pages = App\Models\Page::where('tempname',$activeTemplate)->where('is_default',Status::NO)->get();
@endphp
<!-- header-section start -->
<header class="header-section">
    <div class="header">
        <div class="header-bottom-area">
            <div class="container">
                <div class="header-menu-content">
                    <nav class="navbar navbar-expand-lg p-0">
                        <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="@lang('site logo')"></a>
                        <button class="navbar-toggler ms-auto" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav main-menu ms-auto">
                                <li><a class="{{ menuActive('home') }}" href="{{ route('home') }}">@lang('Home')</a></li>
                                @foreach ($pages->sortBy('name') as $data)
                                    <li><a class="{{ menuActive('pages', null, $data->slug) }}" href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a></li>
                                @endforeach
                                <li><a class="{{ menuActive('services') }}" href="{{ route('services') }}"> @lang('Services')</a> </li>
                                <li><a class="{{ menuActive('blog') }}" href="{{ route('blog') }}"> @lang('Blogs')</a> </li>
                                <li><a class="{{ menuActive('contact') }}" href="{{ route('contact') }}">@lang('Contact')</a></li>
                                @auth
                                    @php
                                        $routeName = Route::currentRouteName();
                                        $routePrefix = explode('.', $routeName)[0];
                                    @endphp
                                    @if ($routePrefix != 'user')
                                        <li><a href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                                    @endif
                                @else
                                    <li class="menu_has_children">
                                        <a class="{{ menuActive(['user.login', 'user.register', 'user.home']) }}" href="#">@lang('Account')</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ route('user.login') }}"> @lang('Login')</a></li>
                                            <li> <a href="{{ route('user.register') }}"> @lang('Register')</a></li>
                                        </ul>
                                    </li>
                                @endauth
                                <li> @include($activeTemplate . 'partials.language')</li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
