@extends($activeTemplate . 'layouts.master')
@section('content')

    <div class="user-profile-wrapper">
        <div class="profile-form">
            <div class="card">
                <div class="card-body">
                    <form class="dashboard-form" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>@lang('Password')</label>
                            <input class="form--control" name="password" type="password" required
                                autocomplete="current-password">
                        </div>
                        <div class="form-group">
                            <label>@lang('New Password')</label>
                            <input class="form--control  @if (gs('secure_password')) secure-password @endif"
                                name="password" type="password" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Confirm Password')</label>
                            <input class="form--control" name="password_confirmation" type="password" required>
                        </div>
                        <button class="btn btn--base w-100 btn-lg h-45" type="submit">@lang('Submit')</button>
                    </form>
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
@push('style')
    <style>

        .dashboard {
            overflow:visible !important;
        }
        .user-profile-wrapper {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .profile-form {
            width: calc(100% - 10%);
        }

        @media(max-width:767px) {
            .user-profile-wrapper {
                gap: 10px;
            }

            .profile-form {
                width: 100%;
            }
        }
    </style>
@endpush
