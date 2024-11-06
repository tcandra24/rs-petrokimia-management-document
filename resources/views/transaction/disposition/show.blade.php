@extends('layouts.app')

@section('title')
    Tampilkan Detail Disposisi
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
    <section class="section profile">
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Detail Disposisi</h5>
                        <div class="row my-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Nomor Agenda</div>
                            <div class="col-lg-9 col-md-8">{{ $disposition->number_transaction }}</div>
                        </div>

                        <div class="row my-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Divisi</div>
                            <div class="col-lg-9 col-md-8">
                                <div class="row">
                                    <div class="d-flex align-items-center gap-2 flex-wrap" style="min-width: 200px;">
                                        @foreach ($disposition->sub_divisions as $sub_division)
                                            <span class="badge bg-primary rounded-3 fw-semibold">
                                                {{ $sub_division->division->name }} | {{ $sub_division->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row my-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Instruksi</div>
                            <div class="col-lg-9 col-md-8">
                                <div class="row">
                                    <div class="d-flex align-items-center gap-2 flex-wrap" style="min-width: 200px;">
                                        @foreach ($disposition->instructions as $instruction)
                                            <span class="badge bg-primary rounded-3 fw-semibold">
                                                {{ $instruction->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row my-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Status</div>
                            <div class="col-lg-9 col-md-8">{{ $disposition->status }}</div>
                        </div>

                        <div class="row my-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Dibuat</div>
                            <div class="col-lg-9 col-md-8">{{ $disposition->created_at }}</div>
                        </div>

                        <div class="row my-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Note</div>
                            @if (auth()->user()->type === 'director' && $disposition->status === 'Dibuat')
                                <div class="col-lg-9 col-md-8">
                                    <form class="row g-3" method="POST"
                                        action="{{ route('transaction.change-status', $disposition->id) }}">
                                        @csrf
                                        {{-- <input type="hidden" name="memo_id" value="{{ $disposition->memo_id }}"> --}}
                                        <textarea class="form-control" name="note" id="" cols="30" rows="5"></textarea>
                                        <fieldset class="row my-2">
                                            <div class="col-sm-10">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status"
                                                        id="approve" value="approve" checked>
                                                    <label class="form-check-label" for="approve">
                                                        Menyutujui
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status"
                                                        id="reject" value="reject">
                                                    <label class="form-check-label" for="reject">
                                                        Menolak
                                                    </label>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <div class="d-flex px-0">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div class="col-lg-9 col-md-8">{{ $disposition->note }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tanda Tangan</h5>
                        @if ($disposition->status === 'Dibuat')
                            <div class="row my-2">
                                <div class="col-lg-12">
                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                        Tidak Ada
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row my-2">
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-center">
                                        <img src="{{ asset('/storage/disposition/qr-codes-signature/' . $disposition->qr_code_file) }}"
                                            alt="{{ $disposition->number_transaction }}" width="200">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        @if ($disposition->memo)
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Memo</h5>
                            <div class="row my-2">
                                <div class="col-lg-3 col-md-4 label fw-bold">Nomor Memo</div>
                                <div class="col-lg-9 col-md-8">{{ $disposition->memo->number_transaction }}</div>
                            </div>

                            <div class="row my-2">
                                <div class="col-lg-3 col-md-4 label fw-bold">Dari</div>
                                <div class="col-lg-9 col-md-8">{{ $disposition->memo->from_user->name }}</div>
                            </div>

                            <div class="row my-2">
                                <div class="col-lg-3 col-md-4 label fw-bold">Dibuat</div>
                                <div class="col-lg-9 col-md-8">{{ $disposition->memo->created_at }}</div>
                            </div>

                            <div class="row my-2">
                                <div class="col-lg-3 col-md-4 label fw-bold">Isi</div>
                                <div class="col-lg-9 col-md-8">{!! $disposition->memo->content !!}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endif

    </section>
@endsection
