<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            @if (isset($seo_title))
                {{$seo_title}}
            @endif
        </title>

        {{--
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        --}}

        <link rel="stylesheet" href="https://jinyphp.github.io/css/assets/css/app.css">
        @stack('css')

        <script src="//unpkg.com/alpinejs" defer></script>
        <!-- ChartJS https://www.chartjs.org/ -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



        {{--
            <link rel="stylesheet" href="http://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            --}}


            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        {{--

        <script src="https://cdn.jsdeliver.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        --}}
        @livewireStyles
    </head>

    <body>
        {{$slot}}

        <script src="https://jinyphp.github.io/css/assets/js/app.js" defer></script>
        @livewireScripts
        @stack('scripts')
    </body>
</html>
