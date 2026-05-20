<!-- banner-section start -->
<section class="banner-section inner-banner-section">
    <div class="banner-shape-one">
        <img src="{{ asset($activeTemplateTrue . 'images/banner/icon-1.png') }}" alt="@lang('shape')">
    </div>
    <div class="banner-shape-two">
        <img src="{{ asset($activeTemplateTrue . 'images/banner/icon-2.png') }}" alt="@lang('shape')">
    </div>
    <div class="banner-shape-three">
        <img src="{{ asset($activeTemplateTrue . 'images/banner/icon-3.png') }}" alt="@lang('shape')">
    </div>
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="banner-content">
                    <h2 class="title">@lang($pageTitle)</h2>
                    <div class="breadcrumb-area">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('Home')</a></li>
                                <li class="breadcrumb-item active" aria-current="page">@lang($pageTitle)</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- banner-section end -->
