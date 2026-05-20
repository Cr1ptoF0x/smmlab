@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="py-100 container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7 col-xl-5">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="card-title text-center">@lang('Reset Password')</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <p>@lang('Your account is verified successfully. Now you can change your password. Please enter a strong password and don\'t share it with anyone.')</p>
                        </div>
                        <form method="POST" action="{{ route('user.password.update') }}">
                            @csrf
                            <input name="email" type="hidden" value="{{ $email }}">
                            <input name="token" type="hidden" value="{{ $token }}">
                            <div class="form-group">
                                <label class="form--label">@lang('Password')</label>
                                <div class="position-relative">
                                    <input class="form--control @if (gs('secure_password')) secure-password @endif" id="your-password" name="password" type="password" required>
                                    <span class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#your-password"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form--label">@lang('Confirm Password')</label>
                                <div class="position-relative">
                                    <input class="form--control" id="comfirm-password" name="password_confirmation" type="password" required>
                                    <span class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#comfirm-password"></span>
                                </div>
                            </div>
                            <button class="btn btn--base w-100" type="submit"> @lang('Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
