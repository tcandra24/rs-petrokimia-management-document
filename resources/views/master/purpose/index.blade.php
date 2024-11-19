@extends('layouts.app')

@section('title')
    Daftar Instruksi
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
                title: "Yakin Hapus Tujuan ?",
                text: name,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#5d87ff",
                confirmButtonText: "Yes",
                closeOnConfirm: !1
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete-purpose-' + id).submit()
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
                        <h5 class="card-title">Daftar Tujuan</h5>
                        @can('master.purposes.create')
                            <a href="{{ route('purposes.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i>
                                Tambah
                            </a>
                        @endcan
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($purposes as $key => $purpose)
                                    <tr>
                                        <th scope="row">{{ $purposes->firstItem() + $key }}</th>
                                        <td>{{ $purpose->name }}</td>
                                        <td>
                                            @if ($purpose->is_active)
                                                <span class="badge rounded-pill bg-primary">Aktif</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">Non Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (auth()->user()->can('master.purposes.edit') || auth()->user()->can('master.purposes.destroy'))
                                                <div class="dropdown">
                                                    <a href="javascript:void(0)" class="btn btn-light"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        id="dropdown-menu-{{ $purpose->id }}">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu"
                                                        aria-labelledby="dropdown-menu-{{ $purpose->id }}">
                                                        @can('master.purposes.edit')
                                                            <a href="{{ route('purposes.edit', $purpose->id) }}"
                                                                class="dropdown-item">
                                                                Ubah
                                                            </a>
                                                        @endcan

                                                        @can('master.purposes.destroy')
                                                            <button class="dropdown-item btn-delete" type="button"
                                                                data-id="{{ $purpose->id }}"
                                                                data-name="{{ $purpose->name }}">Hapus</button>
                                                            <form id="form-delete-purpose-{{ $purpose->id }}" method="POST"
                                                                action="{{ route('purposes.destroy', $purpose->id) }}">
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
                                        <td colspan="4">
                                            <div class="alert alert-info alert-dismissible fade show text-center"
                                                role="alert">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Tujuan Masih Kosong
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex flex-column justify-content-end my-2">
                            {{ $purposes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
