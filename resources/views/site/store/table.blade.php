<div>
    <x-loading-indicator/>

    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="h3">Themes</h1>
        </div>
        <div>
            <button class="btn btn-primary" wire:click="create">신규등록</button>
        </div>
    </div>

    <x-ui-divider>List</x-ui-divider>

    <div class="row">
        @foreach ($rows as $i => $item)
        <div class="col-4">
            @includeIf($actions['view']['list'])
        </div>
        @endforeach
    </div>


    <!-- 팝업 데이터 수정창 -->
    @if ($popupForm)
        @includeIf("jiny-wire-table::table_popup_forms.popup_forms")
    @endif

</div>
