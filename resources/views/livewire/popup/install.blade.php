<div>
    {{-- loading 화면 처리 --}}
    <x-loading-indicator/>

    <!-- 팝업 데이터 수정창 -->
    @if ($popupstore)
    <x-dialog-modal wire:model="popupstore" maxWidth="2xl">

        <x-slot name="content">
            @if(isset($theme['image']) && $theme['image'])
            <img class="card-img-top" src="/images/{{$theme['image']}}" />
            @endif

            <div class="card-title h5">
                {{ $theme['title'] }}
            </div>

            <p class="card-text">{{ $theme['subtitle'] }}</p>

            <table class="table table-sm">
                <tr>
                    <th width="150px">카테고리</th>
                    <td>{{$theme['category']}}</td>
                </tr>
                <tr>
                    <th width="150px">코드</th>
                    <td>{{$theme['code']}}</td>
                </tr>
                <tr>
                    <th width="150px">version</th>
                    <td>{{$theme['version']}}</td>
                </tr>
                <tr>
                    <th width="150px">css framwork</th>
                    <td>{{$theme['css']}}</td>
                </tr>
                <tr>
                    <th width="150px">price</th>
                    <td>{{$theme['price']}}</td>
                </tr>
            </table>

            <p class="card-text">{{ $theme['content'] }}</p>
        </x-slot>

        <x-slot name="footer">

            <x-flex-between>
                <div></div>
                <div>

                @if (isset($theme['installed']) && $theme['installed'])
                    <x-button secondary wire:click="popupStoreClose">닫기</x-button>
                    <x-button danger wire:click="remove">제거</x-button>
                @else
                    <x-button secondary wire:click="popupStoreClose">닫기</x-button>
                    @if($theme['url'])
                    <x-button primary wire:click="download">설치</x-button>
                    @endif
                @endif

                </div>
            </x-flex-between>

        </x-slot>
    </x-dialog-modal>
    @endif
</div>
