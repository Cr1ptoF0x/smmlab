@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="user-profile-wrapper">
        <div class="profile-form">
            <div class="card">
                <div class="card-header">
                    <div class="ms-2 me-auto">
                        <div class="d-flex align-items-center">
                            <div class="order_icon me-2">
                                <i class="las la-font fs-25"></i>
                            </div>
                            <div class="fw-bold">@lang('Full Name') : {{ __($user->fullname) }}</div>
                        </div>
                    </div>
                    <div class="ms-2 me-auto">
                        <div class="d-flex align-items-center">
                            <div class="order_icon me-2">
                                <i class="las la-user-tie fs-25"></i>
                            </div>
                            <div class="fw-bold">@lang('Username') : {{ __($user->username) }}</div>
                        </div>
                    </div>
                    <div class="ms-2 me-auto">
                        <div class="d-flex align-items-center">
                            <div class="order_icon me-2">
                                <i class="las la-envelope-open-text fs-25"></i>
                            </div>
                            <div class="fw-bold">@lang('Email') : {{ $user->email }}</div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="register dashboard-form" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xxl-6 col-xl-12 col-lg-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('First Name')</label>
                                    <input class="form--control control-two" name="firstname" type="text" value="{{ $user->firstname }}" required>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-12 col-lg-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Last Name')</label>
                                    <input class="form--control control-two" name="lastname" type="text" value="{{ $user->lastname }}" required>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-12 col-lg-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('State')</label>
                                    <input class="form--control control-two" name="state" type="text" value="{{ @$user->state }}">
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-12 col-lg-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('City')</label>
                                    <input class="form--control control-two" name="city" type="text" value="{{ @$user->city }}">
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-12 col-lg-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Zip Code')</label>
                                    <input class="form--control control-two" name="zip" type="text" value="{{ @$user->zip }}">
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-12 col-lg-6">
                                <div class="form-group">
                                    <label class="form--label">@lang('Address')</label>
                                    <input class="form--control control-two" name="address" type="text" value="{{ @$user->address }}">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn--base w-100 h-45" type="submit">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
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

        .form--control[type=file] {
            line-height: 45px !important;
        }
    </style>
@endpush
