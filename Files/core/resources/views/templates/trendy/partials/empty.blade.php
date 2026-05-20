<span class="empty-slip-message">
    <span class="d-flex justify-content-center align-items-center">
        <img src="{{ getImage($activeTemplateTrue . '/images/empty_list.png') }}" alt="image">
    </span>
    {{ __($message) }}
</span>

@push('style')
    <style>
        .empty-slip-message {
            display: grid;
            place-content: center;
            height: 30vh;
            color: #cfcfcf;
            font-size: 0.8754rem;
            font-family: inherit;
        }

        .empty-slip-message img {
            width: 75px;
            margin-bottom: 0.875rem;
        }
    </style>
@endpush
