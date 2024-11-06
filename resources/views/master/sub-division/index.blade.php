@extends('layouts.app')

@section('title')
    Daftar Divisi
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
                title: "Yakin Hapus Sub Divisi ?",
                text: name,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#5d87ff",
                confirmButtonText: "Yes",
                closeOnConfirm: !1
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete-sub-division-' + id).submit()
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
                        <h5 class="card-title">Daftar Divisi</h5>
                        @can('master.sub-divisions.create')
                            <a href="{{ route('sub-divisions.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i>
                                Tambah
                            </a>
                        @endcan
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Divisi</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($subDivisions as $key => $subDivision)
                                    <tr>
                                        <th scope="row">{{ $subDivisions->firstItem() + $key }}</th>
                                        <td>{{ $subDivision->name }}</td>
                                        <td>{{ $subDivision->division->name }}</td>
                                        <td>
                                            @if ($subDivision->is_active)
                                                <span class="badge rounded-pill bg-primary">Aktif</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">Non Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (auth()->user()->can('master.sub-divisions.edit') || auth()->user()->can('master.sub-divisions.destroy'))
                                                <div class="dropdown">
                                                    <a href="javascript:void(0)" class="btn btn-light"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        id="dropdown-menu-{{ $subDivision->id }}">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu"
                                                        aria-labelledby="dropdown-menu-{{ $subDivision->id }}">
                                                        @can('master.sub-divisions.edit')
                                                            <a href="{{ route('sub-divisions.edit', $subDivision->id) }}"
                                                                class="dropdown-item">
                                                                Ubah
                                                            </a>
                                                        @endcan

                                                        @can('master.sub-divisions.destroy')
                                                            <button class="dropdown-item btn-delete" type="button"
                                                                data-id="{{ $subDivision->id }}"
                                                                data-name="{{ $subDivision->name }}">Hapus</button>
                                                            <form id="form-delete-sub-division-{{ $subDivision->id }}"
                                                                method="POST"
                                                                action="{{ route('sub-divisions.destroy', $subDivision->id) }}">
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
                                        <td colspan="5">
                                            <div class="alert alert-info alert-dismissible fade show text-center"
                                                role="alert">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Sub Divisi Masih Kosong
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex flex-column justify-content-end my-2">
                            {{ $subDivisions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
