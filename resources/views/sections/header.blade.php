<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li>

            <x-notification-component></x-notification-component>

            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&amp;background=4e73df&amp;color=ffffff&amp;size=100"
                        alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ auth()->user()->name }}</h6>
                        <span>{{ auth()->user()->division->name ?? '-' }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.index') }}">
                            <i class="bi bi-person"></i>
                            <span>Profil Saya</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <form method="POST" id="form-logout" action="{{ route('logout') }}">
                            @csrf
                        </form>
                        <a class="dropdown-item d-flex align-items-center" id="btn-logout" href="javascript:void(0)">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Keluar</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
