@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form method="post" action="{{ route('admin.service.store') }}">
                    @csrf
                    <div class="card-body">
                        <input name="id" type="hidden" value="{{ $service->id }}">
                        <input name="api_provider_id" type="hidden" value="{{ $service->api_provider_id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Category')</label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="" selected disabled>--@lang('Select One')--</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected($service->category_id == $category->id)>
                                                {{ __($category->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Name') </label>
                                    <input class="form-control " name="name" type="text"
                                        value="{{ __($service->name) }}" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Details')</label>
                                    <textarea class="form-control" name="details" rows="8">{{ @$service->details }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Price/1k') </label>
                                    <div class="input-group">
                                        <input class="form-control" name="price_per_k" type="text"
                                            value="{{ getAmount(@$service->price_per_k) }}" required>
                                        <div class="input-group-text">{{ __(gs('cur_text')) }}</div>
                                    </div>
                                </div>
                                @if ($service->api_service_id)
                                    <div class="form-group">
                                        <label>@lang('Original Price/1k') </label>
                                        <div class="input-group">
                                            <input class="form-control" name="original_price" type="text"
                                                value="{{ getAmount(@$service->original_price) }}" required>
                                            <div class="input-group-text">{{ __(gs('cur_text')) }}</div>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>@lang('Min')</label>
                                        <input class="form-control" name="min" type="number"
                                            value="{{ $service->min }}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>@lang('Max')</label>
                                        <input class="form-control" name="max" type="number"
                                            value="{{ $service->max }}" required>
                                    </div>
                                </div>

                                @if ($service->api_service_id)
                                    <div class="form-group">
                                        <label>@lang('Service Id') [<b>@lang('Linked to external API provider')</b>]</label>
                                        <input class="form-control" name="api_service_id" type="text"
                                            value="{{ $service->api_service_id }}" disabled>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang('Dripfeed')</label>
                                                <div class="form-group">
                                                    <input name="dripfeed" data-width="100%" data-size="large"
                                                        data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle"
                                                        data-height="35" data-on="@lang('Yes')" data-off="@lang('No')"
                                                        type="checkbox" @if ($service->dripfeed == Status::YES) checked @endif>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang('Refill')</label>
                                                <div class="form-group">
                                                    <input name="refill" data-width="100%" data-size="large"
                                                        data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle"
                                                        data-height="35" data-on="@lang('Yes')" data-off="@lang('No')"
                                                        type="checkbox" @if ($service->refill == Status::YES) checked @endif>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
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
