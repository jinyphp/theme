<x-theme-app>
    @if (isset($seo_title)) 
        <x-slot name="seo_title">{{$seo_title}}</x-slot>
    @endif

    {{ $slot }}

</x-theme-app>

