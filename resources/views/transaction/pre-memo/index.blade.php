@extends('layouts.app')

@section('title')
    Daftar Memo
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
                title: "Yakin Hapus Memo ?",
                text: name,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#5d87ff",
                confirmButtonText: "Yes",
                closeOnConfirm: !1
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete-memo-' + id).submit()
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
                        <h5 class="card-title">Daftar Memo</h5>
                        @can('transaction.pre-memos.create')
                            <a href="{{ route('pre-memos.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i>
                                Tambah
                            </a>
                        @endcan
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nomer Memo</th>
                                    <th scope="col">Perihal</th>
                                    <th scope="col">Pemohon</th>
                                    <th scope="col">Termohon</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($memos as $key => $memo)
                                    <tr>
                                        <th scope="row">{{ $memos->firstItem() + $key }}</th>
                                        <td>{{ $memo->number_transaction }}</td>
                                        <td>{{ $memo->regarding }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                                    <span class="badge bg-primary rounded-3 fw-semibold">
                                                        {{ $memo->from_user->name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                                    <span class="badge bg-success rounded-3 fw-semibold">
                                                        {{ $memo->to_user->name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="d-flex align-items-center gap-2 flex-wrap"
                                                    style="min-width: 200px;">
                                                    <span class="badge bg-secondary rounded-3 fw-semibold">
                                                        {{ $memo->status }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if (auth()->user()->can('transaction.pre-memos.edit') ||
                                                    auth()->user()->can('transaction.pre-memos.destroy') ||
                                                    auth()->user()->can('transaction.pre-memos.show'))
                                                <div class="dropdown">
                                                    <a href="javascript:void(0)" class="btn btn-light"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        id="dropdown-menu-{{ $memo->id }}">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu"
                                                        aria-labelledby="dropdown-menu-{{ $memo->id }}">
                                                        @if ($memo->status === 'Disetujui')
                                                            <a href="{{ route('download.pre-memos', $memo->id) }}"
                                                                class="dropdown-item">
                                                                Unduh
                                                            </a>
                                                        @endif

                                                        @can('transaction.pre-memos.show')
                                                            <a href="{{ route('pre-memos.show', $memo->id) }}"
                                                                class="dropdown-item">
                                                                Tampilkan
                                                            </a>
                                                        @endcan

                                                        @can('transaction.pre-memos.edit')
                                                            <a href="{{ route('pre-memos.edit', $memo->id) }}"
                                                                class="dropdown-item">
                                                                Ubah
                                                            </a>
                                                        @endcan

                                                        @can('transaction.pre-memos.destroy')
                                                            <button class="dropdown-item btn-delete" type="button"
                                                                data-id="{{ $memo->id }}"
                                                                data-name="{{ $memo->number_transaction }}">Hapus</button>
                                                            <form id="form-delete-memo-{{ $memo->id }}" method="POST"
                                                                action="{{ route('pre-memos.destroy', $memo->id) }}">
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
                                                Memo Masih Kosong
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex flex-column justify-content-end my-2">
                            {{ $memos->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
