<!-- 검색 필터 -->
<x-card>
    <x-card-body>
        <x-table-filter>

            <x-row>
                <x-col-6>
                    <x-form-hor>
                        <x-form-label>코드</x-form-label>
                        <x-form-item>
                            {!! xInputText()
                                ->setWire('model.defer',"filter.code")
                                ->setWidth("small")
                            !!}
                        </x-form-item>
                    </x-form-hor>
                </x-col-6>
                <x-col-6>

                </x-col-6>
            </x-row>

        </x-table-filter>
    </x-card-body>
</x-card>
