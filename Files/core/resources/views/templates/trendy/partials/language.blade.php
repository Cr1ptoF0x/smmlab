@php
    $language = App\Models\Language::all();
    $currentLang = $language->where('code', config('app.locale'))->first();
@endphp

<div class="language_switcher">
    <div class="language_switcher__caption">
        <span class="icon"><img src="{{ getImage(getFilePath('language') . '/' . @$currentLang->image, getFileSize('language')) }}" alt="{{ __(@$currentLang->name) }}"></span>
        <span class="text">{{ __(@$currentLang->name) }}</span>
    </div>
    <div class="language_switcher__list">
        @foreach ($language as $item)
            <div class="language_switcher__item langSel" data-code="{{ @$item->code }}">
                <span class="icon"><img src="{{ getImage(getFilePath('language') . '/' . @$item->image, getFileSize('language')) }}" alt="{{ __(@$item->name) }}"></span>
                <span class="text">{{ __(@$item->name) }}</span>
            </div>
        @endforeach
    </div>
</div>

@push('script')
    <script>
        "use stric";
        $(document).ready(function() {
            $('.langSel').on('click', function(e) {
                let langCode = $(this).data('code');
                window.location.href = "{{ route('home') }}/change/" + langCode;
            });


            //========================= Language Dropdown Js Start ======================
            $('.language_switcher > .language_switcher__caption').on('click', function() {
                $(this).parent().toggleClass('open');
            });

            $('.language_switcher > .language_switcher__list > .language_switcher__item').on('click', function() {
                $('.language_switcher > .language_switcher__list > .language_switcher__item').removeClass('selected');
                $(this).addClass('selected').parent().parent().removeClass('open').children('.language_switcher__caption').html($(this).html());


            });

            $(document).on('keyup', function(evt) {
                if ((evt.keyCode || evt.which) === 27) {
                    $('.language_switcher').removeClass('open');
                }
            });

            $(document).on('click', function(evt) {
                if ($(evt.target).closest(".language_switcher > .language_switcher__caption").length === 0) {
                    $('.language_switcher').removeClass('open');
                }
            });
            //========================= Language Dropdown Js End ======================

        });
    </script>
@endpush
