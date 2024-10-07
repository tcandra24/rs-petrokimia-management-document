@extends('layouts.app')

@section('title')
    Tampilkan Detail Memo
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
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Memo</h5>
                        <div class="row my-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Nomor Memo</div>
                            <div class="col-lg-9 col-md-8">{{ $memo->number_transaction }}</div>
                        </div>

                        <div class="row my-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Dari</div>
                            <div class="col-lg-9 col-md-8">{{ $memo->from_user->name }}</div>
                        </div>

                        <div class="row my-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Dibuat</div>
                            <div class="col-lg-9 col-md-8">{{ $memo->created_at }}</div>
                        </div>

                        <div class="row my-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Isi</div>
                            <div class="col-lg-9 col-md-8">{!! $memo->content !!}</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>
@endsection
