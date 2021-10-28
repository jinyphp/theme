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

        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet"> 
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @stack('css')

        <script src="//unpkg.com/alpinejs" defer></script>
        <!-- ChartJS https://www.chartjs.org/ -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @livewireStyles
    </head>

    <body>
        {{$slot}}

        <script src="{{ asset('js/app.js') }}" defer></script>
        @stack('scripts')
        @livewireScripts
    </body>
</html>
