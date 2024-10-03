@extends('layouts.app')

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
                title: "Yakin Hapus Peran ?",
                text: name,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#5d87ff",
                confirmButtonText: "Yes",
                closeOnConfirm: !1
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete-role-' + id).submit()
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
                        <h5 class="card-title">Daftar Peran</h5>
                        @can('setting.roles.create')
                            <a href="{{ route('roles.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i>
                                Tambah
                            </a>
                        @endcan
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Ijin</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $key => $role)
                                    <tr>
                                        <th scope="row">{{ $roles->firstItem() + $key }}</th>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="d-flex align-items-center gap-2 flex-wrap"
                                                    style="min-width: 200px;">
                                                    @foreach ($role->permissions as $permission)
                                                        <span class="badge bg-success rounded-3 fw-semibold">
                                                            {{ $permission->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if (auth()->user()->can('setting.roles.edit') || auth()->user()->can('setting.roles.destroy'))
                                                <div class="dropdown">
                                                    <a href="javascript:void(0)" class="btn btn-light"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        id="dropdown-menu-{{ $role->id }}">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu"
                                                        aria-labelledby="dropdown-menu-{{ $role->id }}">
                                                        @can('setting.roles.edit')
                                                            <a href="{{ route('roles.edit', $role->id) }}"
                                                                class="dropdown-item">
                                                                Edit
                                                            </a>
                                                        @endcan

                                                        @can('setting.roles.destroy')
                                                            <button class="dropdown-item btn-delete" type="button"
                                                                data-id="{{ $role->id }}"
                                                                data-name="{{ $role->name }}">Delete</button>
                                                            <form id="form-delete-role-{{ $role->id }}" method="POST"
                                                                action="{{ route('roles.destroy', $role->id) }}">
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
                                        <td colspan="3">
                                            <div class="alert alert-info alert-dismissible fade show text-center"
                                                role="alert">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Peran Masih Kosong
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex flex-column justify-content-end my-2">
                            {{ $roles->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
