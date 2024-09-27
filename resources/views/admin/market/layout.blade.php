<x-theme theme="admin.sidebar">
    <x-theme-layout>

        {{-- Title --}}
        @if(isset($actions['view']['title']))
            @includeIf($actions['view']['title'])
        @else
            @includeIf("jiny-wire-table::table_popup_forms.title")
        @endif

        @livewire('site-theme-store',[
                'actions' => $actions,
                'viewFile' => "jinytheme::admin.market.table",
                'slug' => $slug
            ])
    </x-theme-layout>
</x-theme>
