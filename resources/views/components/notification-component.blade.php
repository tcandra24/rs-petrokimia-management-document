<li class="nav-item dropdown">

    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-bell"></i>
        @if (count($unreadNotification) > 0)
            <span class="badge bg-primary badge-number">{{ count($unreadNotification) }}</span>
        @endif
    </a>

    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
        <li class="dropdown-header">
            Anda Mempunyai {{ count($unreadNotification) }}
            <a href="{{ route('notifications.index') }}">
                <span class="badge rounded-pill bg-primary p-2 ms-2">
                    Tampilkan Semua
                </span>
            </a>
        </li>

        @forelse($unreadNotification as $notification)
            <li>
                <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
                <i class="bi {{ $notification['data']['icon'] }} text-{{ $notification['data']['type'] }}"></i>
                <a href="{{ route('notifications.show', $notification->id) }}">
                    <div>
                        <h4>{{ $notification['data']['title'] }}</h4>
                        <p>{{ $notification['data']['message'] }}</p>
                        {{-- <p>1 hr. ago</p> --}}
                    </div>
                </a>
            </li>
        @empty
            <li>
                <hr class="dropdown-divider">
            </li>
            <li class="notification-item">
                <div class="text-center w-100">
                    <p>Tidak Ada Notifikasi</p>
                </div>
            </li>
        @endforelse

        <li>
            <hr class="dropdown-divider">
        </li>
        <li class="dropdown-footer">
            <a href="{{ route('notifications.index') }}">Tampilkan Semua Notifikasi</a>
        </li>
    </ul>
</li>
