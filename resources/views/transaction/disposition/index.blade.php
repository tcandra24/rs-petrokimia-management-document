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
                title: "Yakin Hapus Disposisi ?",
                text: name,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#5d87ff",
                confirmButtonText: "Yes",
                closeOnConfirm: !1
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete-disposisi-' + id).submit()
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
                                    <th scope="col">Memo</th>
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
                                        <td>{{ $disposition->memo?->number_transaction }}</td>
                                        <td>{{ $disposition->division->name }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="d-flex align-items-center gap-2 flex-wrap"
                                                    style="min-width: 200px;">
                                                    <span class="badge bg-success rounded-3 fw-semibold">
                                                        {{ $disposition->status }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if (auth()->user()->can('transaction.dispositions.edit') || auth()->user()->can('transaction.dispositions.destroy'))
                                                <div class="dropdown">
                                                    <a href="javascript:void(0)" class="btn btn-light"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        id="dropdown-menu-{{ $user->id }}">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu"
                                                        aria-labelledby="dropdown-menu-{{ $user->id }}">
                                                        @can('transaction.dispositions.edit')
                                                            <a href="{{ route('users.edit', $user->id) }}"
                                                                class="dropdown-item">
                                                                Edit
                                                            </a>
                                                        @endcan

                                                        @can('transaction.dispositions.destroy')
                                                            <button class="dropdown-item btn-delete" type="button"
                                                                data-id="{{ $user->id }}"
                                                                data-name="{{ $user->name }}">Delete</button>
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
