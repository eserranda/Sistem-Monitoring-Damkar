<!-- Menu -->
<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
    <div class="container-xxl d-flex h-100">
        <ul class="menu-inner py-1">
            <!-- Page -->
            <li class="menu-item {{ Request::is('dashboard*') ? 'active show' : '' }}">
                <a href="/dashboard" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-smart-home"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('monitoring*') ? 'active show' : '' }}">
                <a href="/monitoring" class="menu-link">
                    {{-- <i class="menu-icon tf-icons ti ti-app-window"></i> --}}
                    <i class="menu-icon tf-icons ti ti-screen-share"></i>
                    <div data-i18n="Monitoring">Monitoring</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('sensor*', 'add_sensor') ? 'active show' : '' }}">
                <a href="/sensor" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-temperature"></i>
                    <div data-i18n="Data Sensor">Data Sensor</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('damkar*', 'add_damkar') ? 'active show' : '' }}">
                <a href="/damkar" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-firetruck"></i>
                    <div data-i18n="Data Damkar">Data Damkar</div>
                </a>
            </li>
            @if (Auth::check() && Auth::user()->role == 'super_admin')
                <li class="menu-item {{ Request::is('akun*') || Request::is('add_akun') ? 'active show' : '' }}">
                    <a href="{{ route('akun') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-user-circle"></i>
                        <div data-i18n="Akun">Akun</div>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</aside>
<!-- / Menu -->
