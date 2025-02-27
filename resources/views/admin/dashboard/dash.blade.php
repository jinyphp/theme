<x-theme name="admin.sidebar">
    <x-theme-layout>

        {{-- Title --}}
        @if(isset($actions['view']['title']))
            @includeIf($actions['view']['title'])
        @else
            @includeIf("jiny-wire-table::table_popup_forms.title")
        @endif

        <x-ui-divider>
            설치된 테마
        </x-ui-divider>

        {{-- @livewire('theme-list') --}}
        @livewire('theme-list-json')

        <x-ui-divider>
            테마관리
        </x-ui-divider>

        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">

                        <x-flex-between>
                            <div>
                                <h5 class="card-title">
                                    <a href="/admin/theme/list">
                                    테마관리
                                    </a>
                                </h5>
                                <h6 class="card-subtitle text-muted">
                                    설치된 테마를 관리합니다.
                                </h6>
                            </div>
                            <div>
                                @icon("info-circle.svg")
                            </div>
                        </x-flex-between>
                    </div>
                    <div class="card-body">
                        <a href="/admin/theme/store">
                            <x-badge-secondary>Store</x-badge-secondary>
                        </a>

                        <a href="/admin/theme/setting">
                            <x-badge-secondary>설정</x-badge-secondary>
                        </a>

                    </div>
                </div>
            </div>

            <!-- -->
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <x-flex-between>
                            <div>
                                <h5 class="card-title">
                                    <a href="/admin/theme/market">
                                    마켓관리
                                    </a>
                                </h5>
                                <h6 class="card-subtitle text-muted">
                                    테마 마켓을 관리합니다
                                </h6>
                            </div>
                            <div>
                                @icon("info-circle.svg")
                            </div>
                        </x-flex-between>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>

            <!-- -->
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <x-flex-between>
                            <div>
                                <h5 class="card-title">
                                    <a href="/admin/theme/setting">
                                    설정
                                    </a>
                                </h5>
                                <h6 class="card-subtitle text-muted">
                                    테마 정보를 설정합니다.
                                </h6>
                            </div>
                            <div>
                                @icon("info-circle.svg")
                            </div>
                        </x-flex-between>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>

        </div>
    </x-theme-layout>
</x-theme>

