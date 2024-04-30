<div>
    <x-loading-indicator/>

    <div class="row">
        @includeIf($actions['view']['list'])

        <div class="col-3">
            <div class="w-100 h-100">
                <button class="btn btn-primary" wire:click="create">추가</button>
            </div>
        </div>
    </div>

    @if($popupForm)
    <x-table-dialog-modal wire:model="popupForm" maxWidth="3xl">

        <x-slot name="title"></x-slot>

        <x-slot name="content">
            @includeIf($actions['view']['form'])
        </x-slot>

        <x-slot name="footer">
            <x-flex-between>
                <div>
                    @if(!is_null($edit_id))
                    <button class="btn btn-danger me-2" wire:click="delete">삭제</button>
                    @endif
                </div>
                <div>
                    <button class="btn btn-light" wire:click="close">취소</button>
                    @if(!is_null($edit_id))
                    <button class="btn btn-info me-2" wire:click="update">수정</button>
                    @else
                    <button class="btn btn-primary me-2" wire:click="store">등록</button>
                    @endif
                </div>
            </x-flex-between>
        </x-slot>
    </x-table-dialog-modal>
    @endif


</div>

