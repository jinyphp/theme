<div class="mt-4">
    <x-loading-indicator/>

    <div class="row">
        @foreach ($rows as $i => $item)
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    @includeIf($actions['view']['list'])
                </div>
            </div>
        </div>
        @endforeach

        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <button class="btn btn-primary" wire:click="create">테마등록</button>
                </div>
            </div>
        </div>
    </div>




    <!-- 팝업 데이터 수정창 -->
    @if ($popupForm)
        @includeIf("jiny-wire-table::table_popup_forms.popup_forms")
    @endif

</div>
