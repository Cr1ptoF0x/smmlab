@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light tabstyle--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td>{{ __($category->name) }}
                                            <a href="{{ route('admin.service.index') }}?category_id={{ $category->id }}"
                                               class="badge badge--info ms-2"
                                               data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               title="{{ __('View all services in this category') }}">
                                                {{ $category->services_count }}
                                            </a>
                                        </td>
                                        <td> @php echo $category->statusBadge; @endphp </td>
                                        <td>
                                            <div class="button--group">
                                                <button type="button" class="btn btn-sm btn-outline--primary updateCategory"
                                                        data-id="{{ $category->id }}" data-name="{{ $category->name }}"><i
                                                       class="las la-pen"></i>
                                                    @lang('Edit')</button>

                                                @if ($category->status == Status::DISABLE)
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline--success confirmationBtn"
                                                            data-action="{{ route('admin.category.status', $category->id) }}"
                                                            data-question="@lang('Are you sure to enable this category?')">
                                                        <i class="la la-eye"></i> @lang('Enable')
                                                    </button>
                                                @else
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline--danger confirmationBtn"
                                                            data-action="{{ route('admin.category.status', $category->id) }}"
                                                            data-question="@lang('Are you sure to disable this category?')">
                                                        <i class="la la-eye-slash"></i> @lang('Disable')
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($categories->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($categories) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
    {{-- Add & Edit  Category MODAL --}}
    <div class="modal fade" id="addCategory">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Add Category')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal"><i class="las la-times"></i></button>
                </div>
                <form class="form-horizontal resetForm" method="post" action="{{ route('admin.category.store') }}">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection


@push('breadcrumb-plugins')
    <x-search-form placeholder="Search category" />
    <button class="btn btn-outline--primary h-45 addCategory"><i class="las la-plus"></i> @lang('Add New')</button>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.updateCategory').on('click', function() {
                let title = "@lang('Update Category')";
                var modal = $('#addCategory');
                let id = $(this).data('id');
                let name = $(this).data('name');
                modal.find('input[name=id]').val(id);
                modal.find('input[name=name]').val(name);
                modal.find('.modal-title').text(title)
                modal.modal('show');
            });

            $('.addCategory').on('click', function() {
                let title = "@lang('Add Category')";
                let modal = $('#addCategory');
                $('.resetForm').trigger('reset');
                modal.find('input[name=id]').val('');
                modal.find('.modal-title').text(title)
                modal.modal('show');
            })
        })(jQuery);
    </script>
@endpush
