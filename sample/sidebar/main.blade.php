<div class="main">
    {{-- 상대경로 --}}
    @theme(".main_header")

    <main class="content">
        {{$slot}}
    </main>

    @theme(".main_footer")
</div>
