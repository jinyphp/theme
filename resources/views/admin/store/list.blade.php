<x-wire-table>
    <x-wire-thead>
        {{-- 테이블 제목 --}}
        <th width='50'>Id</th>

        <th width='100'>코드</th>
        <th > {!! xWireLink('Title', "orderBy('title')") !!}</th>
        <th width='180'>설치</th>
        <th width='180'>생성일자</th>

    </x-wire-thead>
    <tbody>
        @if(!empty($rows))
            @foreach ($rows as $item)
            <x-wire-tbody-item :selected="$selected" :item="$item">
                {{-- 테이블 리스트 --}}
                <td width='50'>{{$item->id}}</td>

                <td width='100'>{{$item->code}}</td>
                <td >
                    {!! $popupEdit($item, $item->title) !!}
                </td>
                <td width='100'>
                    <x-button primary wire:click="$emit('install','{{$item->code}}')">설치</x-button>
                </td>
                <td width='180'>{{$item->created_at}}</td>

            </x-wire-tbody-item>
            @endforeach
        @endif
    </tbody>
</x-wire-table>

