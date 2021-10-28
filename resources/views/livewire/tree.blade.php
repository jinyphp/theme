<div>
    <x-row>
        @foreach ($tree as $name => $item)
            <x-col-3>
                <x-card>
                    <x-card-header>
                        {{$name}}
                    </x-card-header>
                </x-card>
            </x-col-3>                
        @endforeach
        
        <x-col-3>
            <x-button primary>추가</x-button>
        </x-col-3>
    </x-row>

    
</div>