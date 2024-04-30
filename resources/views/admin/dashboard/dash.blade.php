@setTheme("admin.sidebar")
<x-theme theme="admin.sidebar">
    <x-theme-layout>



        <div class="d-flex justify-content-between my-2">
            <div class="">
                <h3>
                @if(isset($actions['title']))
                    {{$actions['title']}}
                @endif
                </h3>
                <div class="lead text-center" style="font-size: 1rem;">
                @if(isset($actions['subtitle']))
                    {{$actions['subtitle']}}
                @endif
                </div>
            </div>
            <div class="flex justify-content-end align-items-top">

                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Admin</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/admin/theme">Theme</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Dashbaord
                    </li>
                </ol>

            </div>
        </div>

        {{-- 설치된 테마 목록 --}}
        <div class="row">
            <div class="col-12">
                @livewire('theme-list')
            </div>
        </div>



        <div class="row">

            {{-- <div class="col-4">
                <div class="card">
                    <div class="card-header">

                        <x-flex-between>
                            <div>
                                <h5 class="card-title">
                                    <a href="/admin/theme/list">
                                    설치 목록
                                    </a>
                                </h5>
                                <h6 class="card-subtitle text-muted">
                                    설치된 테마의 목록을 출력합니다.
                                </h6>
                            </div>
                            <div>
                                @icon("info-circle.svg")
                            </div>
                        </x-flex-between>
                    </div>
                    <div class="card-body">
                        <a href="/admin/theme/list">
                            <x-badge-secondary>List</x-badge-secondary>
                        </a>

                    </div>
                </div>
            </div> --}}

            <div class="col-6">
                <div class="card">
                    <div class="card-header">

                        <x-flex-between>
                            <div>
                                <h5 class="card-title">
                                    <a href="/admin/theme/store">
                                    스토어
                                    </a>
                                </h5>
                                <h6 class="card-subtitle text-muted">
                                    스토어에서 테마를 다운로드 받습니다.
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

                    </div>
                </div>
            </div>

            <!-- -->
            <div class="col-6">
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
                        <a href="/admin/theme/setting">
                            <x-badge-secondary>설정</x-badge-secondary>
                        </a>
                    </div>
                </div>
            </div>





        </div>






    </x-theme-layout>
</x-theme>

