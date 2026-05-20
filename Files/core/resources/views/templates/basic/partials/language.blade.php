@php

    $language = App\Models\Language::all();
    $currentLang = $language->where('code', config('app.locale'))->first();
@endphp

@if (gs('multi_language'))
    <div class="custom--dropdown ms-2">
        <!-- Selected Language -->
        @foreach ($language as $lang)
            @if (session('lang') == $lang->code)
                <div class="custom--dropdown__selected dropdown-list__item">
                    <div class="thumb">
                        <img class="flag" src="{{ getImage(getFilePath('language') . '/' . @$lang->image, getFileSize('language')) }}" alt="@lang('flag')">
                    </div>
                    <span class="text">{{ __($lang->name) }}</span>
                </div>
            @endif
        @endforeach

        <!-- Language List -->
        <ul class="dropdown-list">
            @foreach ($language as $lang)
                <li class="dropdown-list__item langSel" data-value="{{ @$lang->code }}">
                    <div class="thumb">
                        <img class="flag" src="{{ getImage(getFilePath('language') . '/' . @$lang->image, getFileSize('language')) }}" alt="@lang('flag')">
                    </div>
                    <span class="text">{{ __($lang->name) }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    @push('script')
        <script>
            (function($) {
                "use strict";
                $(".langSel").on("click", function() {
                    window.location.href = "{{ route('home') }}/change/" + $(this).data('value');
                });


                $('.custom--dropdown > .custom--dropdown__selected').on('click', function() {
                    $(this).parent().toggleClass('open');
                });

                $('.custom--dropdown > .dropdown-list > .dropdown-list__item').on('click', function() {
                    $('.custom--dropdown > .dropdown-list > .dropdown-list__item').removeClass('selected');
                    $(this).addClass('selected').parent().parent().removeClass('open').children('.custom--dropdown__selected').html($(this).html());
                });

                $(document).on('keyup', function(evt) {
                    if ((evt.keyCode || evt.which) === 27) {
                        $('.custom--dropdown').removeClass('open');
                    }
                });

                $(document).on('click', function(evt) {
                    if ($(evt.target).closest(".custom--dropdown > .custom--dropdown__selected").length === 0) {
                        $('.custom--dropdown').removeClass('open');
                    }
                });


            })(jQuery)
        </script>
    @endpush
@endif
