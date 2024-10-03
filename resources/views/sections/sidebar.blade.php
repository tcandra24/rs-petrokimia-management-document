<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('dashboard.index') }}">
                <i class="bi bi-display"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @if (auth()->user()->can('master.divisions.index') || auth()->user()->can('master.instructions.index'))
            <li class="nav-heading">Master</li>
            @can('master.divisions.index')
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#departement-nav" data-bs-toggle="collapse"
                        href="#">
                        <i class="bi bi-building"></i><span>Divisi</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="departement-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('divisions.index') }}">
                                <i class="bi bi-circle"></i><span>Daftar</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('master.instructions.index')
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#employee-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-person-badge"></i><span>Instruksi</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="employee-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('instructions.index') }}">
                                <i class="bi bi-circle"></i><span>Daftar</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
        @endif

        <li class="nav-heading">Transaksi</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-calculator"></i>
                <span>Memo</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('dispositions.index') }}">
                <i class="bi bi-journal-check"></i>
                <span>Disposisi</span>
            </a>
        </li>

        @if (auth()->user()->can('setting.users.index') ||
                auth()->user()->can('setting.roles.index') ||
                auth()->user()->can('setting.permissions.index'))
            <li class="nav-heading">Pengaturan</li>
            @can('setting.users.index')
                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('users.index') }}">
                        <i class="bi bi-people"></i>
                        <span>Pengguna</span>
                    </a>
                </li>
            @endcan
            @can('setting.roles.index')
                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('roles.index') }}">
                        <i class="bi bi-shield-lock"></i>
                        <span>Peran</span>
                    </a>
                </li>
            @endcan
            @can('setting.permissions.index')
                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('permissions.index') }}">
                        <i class="bi bi-door-open"></i>
                        <span>Hak Akses</span>
                    </a>
                </li>
            @endcan
        @endif
    </ul>
</aside>
