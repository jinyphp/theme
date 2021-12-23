{{-- 타이틀 로고 --}}
<a class="sidebar-brand" href="index.html">
    <span class="align-middle sidebar-brand-text">
        JinyAdmin
    </span>
</a>

{{--
<ul class="sidebar-nav">
    <li class="sidebar-header">
        Pages
    </li>

    <li class="sidebar-item">

        <a data-bs-target="#multi"
            data-bs-toggle="collapse"
            class="sidebar-link collapsed">
            <span class="align-middle">Multi Level</span>
        </a>

        <ul id="multi"
            class="sidebar-dropdown list-unstyled collapse"
            data-bs-parent="#sidebar">

            <li class="sidebar-item">
                <a data-bs-target="#multi-2" data-bs-toggle="collapse" class="sidebar-link collapsed">Two Levels</a>
                <ul id="multi-2" class="sidebar-dropdown list-unstyled collapse">
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="#">Item 1</a>
                        <a class="sidebar-link" href="#">Item 2</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#multi-3" data-bs-toggle="collapse" class="sidebar-link collapsed">Three Levels</a>
                <ul id="multi-3" class="sidebar-dropdown list-unstyled collapse">
                    <li class="sidebar-item">
                        <a data-bs-target="#multi-3-1" data-bs-toggle="collapse" class="sidebar-link collapsed">Item 1</a>
                        <ul id="multi-3-1" class="sidebar-dropdown list-unstyled collapse">
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="#">Item 1</a>
                                <a class="sidebar-link" href="#">Item 2</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="#">Item 2</a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
</ul>
--}}




{{--
<ul class="sidebar-nav">
    <li class="sidebar-header">
        Users
    </li>
    <li class="sidebar-item active">
        <a class="sidebar-link" href="/admin/users">
            <span class="align-middle">Users</span>
        </a>
    </li>
    <li class="sidebar-item">
        <a class="sidebar-link" href="/admin/theme/list">
            <span class="align-middle">Theme</span>
        </a>
    </li>
</ul>
--}}

{{-- @theme(".menu_tree") --}}
<!-- 사이드바 메뉴 -->



{{--
<x-menu-json path="menus/3.json">
</x-menu-json>
--}}
<x-menu-json>
</x-menu-json>


{{--
@livewire('menu-builder')
--}}

{{-- Menu Footer --}}
{{--
<div class="sidebar-cta">
    <div class="sidebar-cta-content">
        <strong class="mb-2 d-inline-block">Ducuments</strong>
        <div class="mb-3 text-sm">
            jinyuiKit is Component Builder!
        </div>

        <div class="d-grid">
            <a href="/docs" class="btn btn-outline-primary"
                target="_blank">Move</a>
        </div>
    </div>
</div>
--}}
