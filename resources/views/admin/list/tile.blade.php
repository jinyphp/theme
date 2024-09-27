<div>
    <div class="row mb-3">
        @foreach ($rows as $id => $item)
        <div class="col-3">
            @includeIf($actions['view']['list'],[
                'id' => $id,
                'item' => $item
            ])
        </div>
        @endforeach
        <div class="col-3">
            <div class="card">
                <div class="card-body h-100">
                    <div class="mb-3">
                        <p>새로운 테마를 생성합니다.</p>
                        <button class="btn btn-primary" wire:click="create">생성</button>
                    </div>

                    <div class="mb-3">
                        <p>압축된 테마파일을 업로드 합니다.</p>
                        <button class="btn btn-primary" wire:click="upload">Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 팝업 데이터 수정창 -->
    @if ($popupForm)
        @includeIf("jiny-wire-table::table_popup_forms.popup_forms")
    @endif

</div>

