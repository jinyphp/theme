<x-datatable>
    <x-data-table-thead>
        <th width='50'>Id</th>

        <th width='100'>코드</th>
        <th > {!! xWireLink('Title', "orderBy('title')") !!}</th>
        <th width='180'>설치</th>
        <th width='180'>생성일자</th>
    </x-data-table-thead>

    @if(!empty($rows))
    <tbody>
        @foreach ($rows as $item)
        <x-data-table-tr :item="$item" :selected="$selected">
            <td width='50'>{{$item->id}}</td>

            <td width='100'>{{$item->code}}</td>
            <td >
                {!! $popupEdit($item, $item->title) !!}
            </td>
            <td width='100'>
                <x-button primary wire:click="$emit('install','{{$item->code}}')">설치</x-button>
            </td>
            <td width='180'>{{$item->created_at}}</td>
        </x-data-table-tr>
        @endforeach

    </tbody>
    @endif
</x-datatable>


@if(empty($rows))
<div>
    목록이 없습니다.
</div>
@endif


