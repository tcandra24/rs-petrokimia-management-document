@extends('layouts.app')

@section('title')
    Daftar Pengguna
@endsection

@section('styles')
    {{--  --}}
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $('.btn-delete').on('click', function() {
            const id = $(this).attr('data-id')
            const name = $(this).attr('data-name')

            Swal.fire({
                title: "Yakin Hapus Pengguna ?",
                text: name,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#5d87ff",
                confirmButtonText: "Yes",
                closeOnConfirm: !1
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete-user-' + id).submit()
                }
            })
        })

        $('.btn-resend').on('click', function() {
            const id = $(this).attr('data-id')
            const name = $(this).attr('data-name')

            Swal.fire({
                title: "Yakin Kirim Email Ulang ?",
                text: name,
                icon: "info",
                showCancelButton: !0,
                confirmButtonColor: "#5d87ff",
                confirmButtonText: "Yes",
                closeOnConfirm: !1
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-resend-email-' + id).submit()
                }
            })
        })
    </script>
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Pengguna</h5>
                        @can('setting.users.create')
                            <a href="{{ route('users.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i>
                                Tambah
                            </a>
                        @endcan
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Divisi</th>
                                    <th scope="col">Tipe</th>
                                    <th scope="col">Peran</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $key => $user)
                                    <tr>
                                        <th scope="row">{{ $users->firstItem() + $key }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->division?->name }}</td>
                                        <td>{{ $user->type }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="d-flex align-items-center gap-2 flex-wrap"
                                                    style="min-width: 200px;">
                                                    @foreach ($user->roles as $role)
                                                        <span class="badge bg-success rounded-3 fw-semibold">
                                                            {{ $role->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if (auth()->user()->can('setting.users.edit') || auth()->user()->can('setting.users.destroy'))
                                                <div class="dropdown">
                                                    <a href="javascript:void(0)" class="btn btn-light"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        id="dropdown-menu-{{ $user->id }}">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu"
                                                        aria-labelledby="dropdown-menu-{{ $user->id }}">
                                                        @if (!$user->hasVerifiedEmail())
                                                            <button class="dropdown-item btn-resend" type="button"
                                                                data-id="{{ $user->id }}"
                                                                data-name="{{ $user->name }}">
                                                                Kirim Email Verifikasi
                                                            </button>
                                                            <form id="form-resend-email-{{ $user->id }}" method="POST"
                                                                action="{{ route('email.resend', $user->email) }}">
                                                                @csrf
                                                            </form>
                                                        @endif

                                                        @can('setting.users.edit')
                                                            <a href="{{ route('users.edit', $user->id) }}"
                                                                class="dropdown-item">
                                                                Ubah
                                                            </a>
                                                        @endcan

                                                        @can('setting.users.destroy')
                                                            <button class="dropdown-item btn-delete" type="button"
                                                                data-id="{{ $user->id }}"
                                                                data-name="{{ $user->name }}">Hapus</button>
                                                            <form id="form-delete-user-{{ $user->id }}" method="POST"
                                                                action="{{ route('users.destroy', $user->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        @endcan
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="alert alert-info alert-dismissible fade show text-center"
                                                role="alert">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Pengguna Masih Kosong
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex flex-column justify-content-end my-2">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
