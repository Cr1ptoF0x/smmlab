@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form method="post" action="{{ route('admin.service.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Category')</label>
                                    <select class="form-control select2" id="category" name="category" required>
                                        <option value="" selected disabled>--@lang('Select One')--</option>
                                        @foreach (@$categories as $category)
                                            <option value="{{ $category->id }}">{{ @$category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">@lang('Name') </label>
                                    <input class="form-control " name="name" type="text" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Dripfeed')</label>
                                            <div class="form-group">
                                                <input name="dripfeed" data-width="100%" data-size="large"
                                                    data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle"
                                                    data-height="35" data-on="@lang('Yes')"
                                                    data-off="@lang('No')" type="checkbox">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Refill')</label>
                                            <div class="form-group">
                                                <input name="refill" data-width="100%" data-size="large"
                                                    data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle"
                                                    data-height="35" data-on="@lang('Yes')"
                                                    data-off="@lang('No')" type="checkbox">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Price Per 1k') </label>
                                    <div class="input-group">
                                        <input class="form-control" name="price_per_k" type="text" required>
                                        <div class="input-group-text">{{ __(gs('cur_text')) }}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>@lang('Min')</label>
                                        <input class="form-control" name="min" type="number" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>@lang('Max')</label>
                                        <input class="form-control" name="max" type="number" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>@lang('Details')</label>
                                    <textarea class="form-control" name="details" rows="6" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group api_service_id"></div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn--primary h-45 w-100" type="submit">@lang('Submit')</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.service.index') }}" />
@endpush
