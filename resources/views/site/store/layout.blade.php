<x-www-app>
    <x-www-layout>
        <x-www-main>

            @livewire('site-theme-store',[
                'actions' => $actions,
                'slug' => $slug
            ])

        </x-www-main>
    </x-www-layout>
</x-www-app>
