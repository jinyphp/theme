{{-- 컴포넌트: 사이드바--}}
<nav {{ $attributes->merge(['class' => 'sidebar']) }}>
    {{$slot}}
</nav>