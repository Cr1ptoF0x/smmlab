@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="register-section ptb-80">
        <div class="register-element-one">
            <img src="{{ getImage($activeTemplateTrue . 'images/round.png') }}" alt="@lang('shape')">
        </div>
        <div class="container">

            <figure class="figure highlight-background highlight-background--lean-left">
                <img src="{{ getImage($activeTemplateTrue . 'images/svg/animation.svg') }}" alt="">
            </figure>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="common-form-style bg-one">
                        <p>@lang('To recover your account please provide your email or username to find your account.')</p>
                        <form class="verify-gcaptcha" method="POST" action="{{ route('user.password.email') }}">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">@lang('Email or Username')</label>
                                <input class="form-control form--control" name="value" type="text" value="{{ old('value') }}" required autofocus="off">
                            </div>
                            <x-captcha />
                            <button class="btn btn--base w-100 h-45" type="submit">@lang('Submit')</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
