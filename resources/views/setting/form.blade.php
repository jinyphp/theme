<div>
    <x-navtab class="mb-3 nav-bordered">

        <!-- formTab -->
        <x-navtab-item class="show active" >

            <x-navtab-link class="rounded-0 active">
                <span class="d-none d-md-block">테마</span>
            </x-navtab-link>

            <x-form-hor>
                <x-form-label>서버주소</x-form-label>
                <x-form-item>
                    {!! xInputText()
                        ->setWire('model.defer',"forms.server")
                        ->setWidth("standard")
                    !!}
                    <p>서버주소</p>
                </x-form-item>
            </x-form-hor>


        </x-navtab-item>



    </x-navtab>
</div>
