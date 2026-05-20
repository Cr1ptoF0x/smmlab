@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Email-Mobile')</th>
                                    <th>@lang('Country')</th>
                                    <th>@lang('Joined At')</th>
                                    <th>@lang('Balance')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $user->id) }}">
                                                    <span>@</span>{{ $user->username }}
                                                </a>
                                            </span>
                                        </td>
                                        <td>{{ $user->email }}<br>{{ $user->mobileNumber }}</td>
                                        <td>
                                            <span class="fw-bold" title="{{ @$user->country_name }}">
                                                {{ $user->country_code }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ showDateTime($user->created_at) }}
                                            <br>
                                            {{ diffForHumans($user->created_at) }}
                                        </td>
                                        <td>
                                            <span class="fw-bold">
                                                {{ showAmount($user->balance) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline--info" id="bulkAction"
                                                data-bs-toggle="dropdown">
                                                <i class="las la-ellipsis-v"></i>
                                                @lang('Action')
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('admin.users.detail', $user->id) }}"
                                                    class="dropdown-item">
                                                    <i class="las la-desktop"></i> @lang('Details')
                                                </a>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.users.service', $user->id) }}">
                                                    <i class="las la-wrench"></i> @lang('Custom Service')
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($users->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($users) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Username / Email" />
@endpush
