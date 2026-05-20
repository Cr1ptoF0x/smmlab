<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ gs()->siteName($pageTitle ?? '') }}</title>

    <link type="image/png" href="{{ siteFavicon() }}" rel="shortcut icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/line-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/prism.css') }}" rel="stylesheet">

    @stack('style-lib')

    <link href="{{ asset($activeTemplateTrue . 'css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/custom.css') }}" rel="stylesheet">
    @stack('style')
    <link href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ gs('base_color') }}&secondColor={{ gs('secondary_color') }}" rel="stylesheet">

</head>

<body>
    <div id="overlayer">
        <div class="loader">
            <div class="loader-inner"></div>
        </div>
    </div>

    <div class="body-overlay"></div>

    <div class="sidebar-overlay"></div>

    <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>

    @include('Template::partials.header')

    <section class="dashboard-section section-bg pb-60 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex gap-3 flex-wrap align-items-center mb-4">
                        <span class="sidebar_menu_btn d-lg-none d-inline-flex mt-2"><i class="fas fa-bars"></i></span>
                        <div class="dashboard-wrapper__header mb-0">
                            <h4 class="title mb-0">{{ __($pageTitle) }}</h4>
                        </div>
                    </div>
                    <div class="dashboard-wrapper">
                        <div class="dashboard">
                            <div class="dashboard__inner flex-wrap">
                                @include('Template::partials.sidenav')
                                <div class="dashboard__right">
                                    <div class="dashboard-body">
                                        @yield('content')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/prism.js') }}"></script>

    @stack('script-lib')

    <script src="{{ asset($activeTemplateTrue . 'js/dashboard.js') }}"></script>

    @include('partials.plugins')

    @include('partials.notify')

    @stack('script')

</body>

</html>
