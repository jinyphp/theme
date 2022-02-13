{{-- 목록을 타일형태로 출력합니다. --}}
@foreach ($rows as $item)
    <x-col-3>
        <x-card class="h-100">
            <x-card-before>
                <img class="card-img-top" src="/images/{{$item->image}}" alt="{{$item->title}}">
            </x-card-before>

            <x-card-header>
                <div class="card-title h5">{{$item->title}}</div>
                <p class="card-text">
                    {{$item->subtitle}}
                </p>
            </x-card-header>

            <x-card-body>
                <table class="table table-sm">
                    <tr>
                        <th width="70px">코드</th>
                        <td>{{$item->code}}</td>
                    </tr>
                </table>
            </x-card-body>
            <x-card-footer>
                <x-flex-between>
                    <div>
                        <p class="card-text">
                            <small class="text-muted">{{$item->created_at}}</small>
                        </p>
                    </div>
                    <div>

                        @if ( isset($installed[ $item->code ]) &&  $installed[ $item->code ] )
                            <x-button danger wire:click="$emit('uninstall','{{$item->code}}')">제거</x-button>
                        @else
                            <x-button primary wire:click="$emit('install','{{$item->code}}')">설치</x-button>
                        @endif

                    </div>
                </x-flex-between>
            </x-card-footer>
        </x-card>
    </x-col-3>
@endforeach

@if(empty($rows))
<div>
    목록이 없습니다.
</div>
@endif


