<x-admin-hyper>

    <div class="relative">
    <div class="absolute right-0 bottom-4">
        <div class="btn-group">
            <x-button id="btn-livepopup-manual" secondary wire:click="$emit('popupManualOpen')">메뉴얼</x-button>
            <x-button id="btn-livepopup-create" primary wire:click="$emit('popupFormOpen')">신규추가</x-button>
        </div>
    </div>
    </div>


    @push('scripts')
    <script>
    document.querySelector("#btn-livepopup-create").addEventListener("click",function(e){
        e.preventDefault();
        Livewire.emit('popupFormCreate');
    });

    document.querySelector("#btn-livepopup-manual").addEventListener("click",function(e){
        e.preventDefault();
        Livewire.emit('popupManualOpen');
    });
    </script>
    @endpush


    @livewire('WireTable', ['actions'=>$actions])

    @livewire('WirePopupForm', ['actions'=>$actions])

    @livewire('Popup-LiveManual')

    @livewire('ThemeInstall')


    {{-- SuperAdmin Actions Setting --}}
    @if(Module::has('Actions'))
        @livewire('setActionRule', ['actions'=>$actions])
    @endif
</x-admin-hyper>
