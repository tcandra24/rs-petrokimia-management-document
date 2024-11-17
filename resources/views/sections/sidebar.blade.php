<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ request()->is('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard.index') }}">
                <i class="bi bi-display"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @if (auth()->user()->can('master.divisions.index') ||
                auth()->user()->can('master.sub-divisions.index') ||
                auth()->user()->can('master.instructions.index'))
            <li class="nav-heading">Master</li>
            @can('master.divisions.index')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('master/divisions/*') || request()->is('master/divisions') ? '' : 'collapsed' }}"
                        data-bs-target="#division-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-building"></i><span>Unit</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="division-nav"
                        class="nav-content collapse {{ request()->is('master/divisions/*') || request()->is('master/divisions') ? 'show' : '' }}"
                        data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('divisions.index') }}">
                                <i class="bi bi-circle"></i><span>Daftar</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('master.sub-divisions.index')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('master/sub-divisions/*') || request()->is('master/sub-divisions') ? '' : 'collapsed' }}"
                        data-bs-target="#sub-division-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-collection"></i><span>Sub Unit</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="sub-division-nav"
                        class="nav-content collapse {{ request()->is('master/sub-divisions/*') || request()->is('master/sub-divisions') ? 'show' : '' }}"
                        data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('sub-divisions.index') }}">
                                <i class="bi bi-circle"></i><span>Daftar</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('master.instructions.index')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('master/instructions/*') || request()->is('master/instructions') ? '' : 'collapsed' }}"
                        data-bs-target="#instruction-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-person-badge"></i><span>Instruksi</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="instruction-nav"
                        class="nav-content collapse {{ request()->is('master/instructions/*') || request()->is('master/instructions') ? 'show' : '' }}"
                        data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('instructions.index') }}">
                                <i class="bi bi-circle"></i><span>Daftar</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
        @endif

        @if (auth()->user()->can('transaction.memos.index') || auth()->user()->can('transaction.dispositions.index'))
            <li class="nav-heading">Transaksi</li>
            @can('transaction.memos.index')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('transaction/memos/*') || request()->is('transaction/memos') ? '' : 'collapsed' }}"
                        href="{{ route('memos.index') }}">
                        <i class="bi bi-calculator"></i>
                        <span>Memo</span>
                    </a>
                </li>
            @endcan
            @can('transaction.dispositions.index')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('transaction/dispositions/*') || request()->is('transaction/dispositions') ? '' : 'collapsed' }}"
                        href="{{ route('dispositions.index') }}">
                        <i class="bi bi-journal-check"></i>
                        <span>Disposisi</span>
                    </a>
                </li>
            @endcan
        @endif

        @if (auth()->user()->can('setting.users.index') ||
                auth()->user()->can('setting.roles.index') ||
                auth()->user()->can('setting.permissions.index'))
            <li class="nav-heading">Pengaturan</li>
            @can('setting.users.index')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('setting/users/*') || request()->is('setting/users') ? '' : 'collapsed' }}"
                        href="{{ route('users.index') }}">
                        <i class="bi bi-people"></i>
                        <span>Pengguna</span>
                    </a>
                </li>
            @endcan
            @can('setting.roles.index')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('setting/roles/*') || request()->is('setting/roles') ? '' : 'collapsed' }}"
                        href="{{ route('roles.index') }}">
                        <i class="bi bi-shield-lock"></i>
                        <span>Peran</span>
                    </a>
                </li>
            @endcan
            @can('setting.permissions.index')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('setting/permissions/*') || request()->is('setting/permissions') ? '' : 'collapsed' }}"
                        href="{{ route('permissions.index') }}">
                        <i class="bi bi-door-open"></i>
                        <span>Hak Akses</span>
                    </a>
                </li>
            @endcan
        @endif
    </ul>
</aside>
