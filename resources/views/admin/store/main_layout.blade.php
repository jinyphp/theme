{{-- 타일 목록형태로  출력합니다. --}}
<div>
    <x-loading-indicator/>

    @if (session()->has('message'))
        <div class="alert alert-success">{{session('message')}}</div>
    @endif

    <!-- 데이터 목록 -->
    <x-row>
        @if (isset($actions['view_list']))
            @includeIf($actions['view_list'])
        @endif
    </x-row>

    <x-row>
        <x-col>
            @if (isset($row) && is_object($row))
                {{ $rows->links() }}
            @endif
        </x-col>
    </x-row>

    <br>

    {{-- 선택삭제 --}}
    @include("jinytable::livewire.popup.delete")

    {{-- 퍼미션 알람--}}
    @include("jinytable::error.popup.permit")
</div>
