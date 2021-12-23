<div class="wrapper">
    {{-- 테마의 sidebar.blade.php 적용--}}
    <x-theme-sidebar>
        @theme(".menu")
    </x-theme-sidebar>

    {{-- 테마의 main.blade.php 적용--}}
    <x-theme-main>
        {{$slot}}
    </x-theme-main>
</div>
