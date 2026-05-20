@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            @if (!blank($supports))
                <div class="dashboard-table">
                    <table class="table table--responsive--md">
                        <thead>
                            <tr>
                                <th>@lang('Subject')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Priority')</th>
                                <th>@lang('Last Reply')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($supports as $support)
                                <tr>
                                    <td class="break_line">
                                        <a class="fw-bold" href="{{ route('ticket.view', $support->ticket) }}">
                                            [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }}
                                        </a>
                                    </td>
                                    <td>
                                        @php echo $support->statusBadge; @endphp
                                    </td>
                                    <td>
                                        @if ($support->priority == Status::PRIORITY_LOW)
                                            <span class="badge badge--dark">@lang('Low')</span>
                                        @elseif($support->priority == Status::PRIORITY_MEDIUM)
                                            <span class="badge badge--success">@lang('Medium')</span>
                                        @elseif($support->priority == Status::PRIORITY_HIGH)
                                            <span class="badge badge--primary">@lang('High')</span>
                                        @endif
                                    </td>
                                    <td>{{ diffForHumans($support->last_reply) }} </td>

                                    <td>
                                        <div class="action-buttons">
                                            <a class="action-btn edit-btn" href="{{ route('ticket.view', $support->ticket) }}" title="@lang('View')">
                                                <span class="icon"><i class="las la-desktop"></i></span>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">{{ ___($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($supports->hasPages())
                    @php echo paginateLinks($supports) @endphp
                @endif
            @else
                @include($activeTemplate . 'partials.empty', ['message' => 'Support ticket not found!'])
            @endif
        </div>
    </div>
@endsection

@push('style')
    <style>
        .break_line {
            white-space: initial !important;
        }
    </style>
@endpush
