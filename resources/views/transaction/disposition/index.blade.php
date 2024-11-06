@extends('layouts.app')

@section('title')
    Daftar Disposisi
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
                title: "Yakin Hapus Disposisi ?",
                text: name,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#5d87ff",
                confirmButtonText: "Yes",
                closeOnConfirm: !1
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete-disposition-' + id).submit()
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
                        <h5 class="card-title">Daftar Disposisi</h5>
                        @can('transaction.dispositions.create')
                            <a href="{{ route('dispositions.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i>
                                Tambah
                            </a>
                        @endcan
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nomer Agenda</th>
                                    <th scope="col">Komite</th>
                                    <th scope="col">Tipe</th>
                                    <th scope="col">Divisi</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dispositions as $key => $disposition)
                                    <tr>
                                        <th scope="row">{{ $dispositions->firstItem() + $key }}</th>
                                        <td>{{ $disposition->number_transaction }}</td>
                                        <td>{{ $disposition->committee }}</td>
                                        <td>
                                            @if ($disposition->memo)
                                                <div class="row">
                                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                                        <span class="badge bg-danger rounded-3 fw-semibold">
                                                            Memo
                                                        </span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                                        <span class="badge bg-danger rounded-3 fw-semibold">
                                                            Surat Masuk
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                                    @foreach ($disposition->sub_divisions as $sub_division)
                                                        <span class="badge bg-primary rounded-3 fw-semibold">
                                                            {{ $sub_division->division->name }} | {{ $sub_division->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="d-flex align-items-center gap-2 flex-wrap"
                                                    style="min-width: 200px;">
                                                    <span class="badge bg-secondary rounded-3 fw-semibold">
                                                        {{ $disposition->status }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if (auth()->user()->can('transaction.dispositions.edit') ||
                                                    auth()->user()->can('transaction.dispositions.destroy') ||
                                                    auth()->user()->can('transaction.dispositions.show'))
                                                <div class="dropdown">
                                                    <a href="javascript:void(0)" class="btn btn-light"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        id="dropdown-menu-{{ $disposition->id }}">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu"
                                                        aria-labelledby="dropdown-menu-{{ $disposition->id }}">
                                                        @can('transaction.dispositions.show')
                                                            <a href="{{ route('dispositions.show', $disposition->id) }}"
                                                                class="dropdown-item">
                                                                Tampilkan
                                                            </a>
                                                        @endcan

                                                        @can('transaction.dispositions.edit')
                                                            @if ($disposition->status !== 'Disetujui')
                                                                <a href="{{ route('dispositions.edit', $disposition->id) }}"
                                                                    class="dropdown-item">
                                                                    Ubah
                                                                </a>
                                                            @endif
                                                        @endcan

                                                        @can('transaction.dispositions.destroy')
                                                            <button class="dropdown-item btn-delete" type="button"
                                                                data-id="{{ $disposition->id }}"
                                                                data-name="{{ $disposition->number_transaction }}">Hapus</button>
                                                            <form id="form-delete-disposition-{{ $disposition->id }}"
                                                                method="POST"
                                                                action="{{ route('dispositions.destroy', $disposition->id) }}">
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
                                        <td colspan="7">
                                            <div class="alert alert-info alert-dismissible fade show text-center"
                                                role="alert">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Disposisi Masih Kosong
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex flex-column justify-content-end my-2">
                            {{ $dispositions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
