<div class="card">
    @if(isset($item['image']))
    <img src="{{$item['image']}}" alt="">
    @endif

    <div class="card-body">
        <x-click wire:click="edit({{$id}})">
            {{$item['code']}}
        </x-click>

        @if(isset($item['content']))
        <p>{{$item['content']}}</p>
        @endif

    </div>
</div>

{{-- <x-wire-table>
    <x-wire-thead>
    <x-wire-thead>

        <th width='50'>Id</th>
        <th width='100'>코드</th>
        <th > {!! xWireLink('Title', "orderBy('title')") !!}</th>
        <th width='250'>설치</th>
        <th width='200'>생성일자</th>
    </x-wire-thead>
    <tbody>
        @if(!empty($rows))
            @foreach ($rows as $item)
            <x-wire-tbody-item :selected="$selected" :item="$item">

                <td width='50'>{{$item->id}}</td>
            <td width='100'>{{$item->code}}</td>
            <td >
                {!! $popupEdit($item, $item->title) !!}
            </td>
            <td width='250'>
                {{$item->installed}}
                @if ($item->installed)
                    <x-link class="text-red-600" wire:click="$emit('uninstall','{{$item->code}}')">제거</x-link>
                @else
                    <x-link class="text-blue-600" wire:click="$emit('install','{{$item->code}}')">설치</x-link>
                @endif

            </td>
            <td width='200'>{{$item->created_at}}</td>

            </x-wire-tbody-item>
            @endforeach
        @endif
    </tbody>
</x-wire-table> --}}
