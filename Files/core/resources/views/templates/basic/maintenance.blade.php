<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ gs()->siteName($pageTitle ?? '404 | page not found') }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ getImage(getFilePath('logoIcon') . '/favicon.png') }}">
    <!-- bootstrap 4  -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
    <!-- dashdoard main css -->
</head>

<style>
    body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<body>
    <div class="container py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-7 text-center">
                <div class="row justify-content-center">
                    

                    <div class="col-sm-6 col-8 mt-3">
                        <img src="{{ getImage(getFilePath('maintenance') . '/' . @$maintenance->data_values->image, getFileSize('maintenance')) }}" alt="@lang('image')" class="img-fluid mx-auto mb-5">
                    </div>
                </div>

                @php echo $maintenance->data_values->description @endphp
            </div>
        </div>
    </div>
</body>

</html>
