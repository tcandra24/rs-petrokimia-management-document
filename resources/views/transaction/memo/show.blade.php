@extends('layouts.app')

@section('title')
    Detail Memo {{ $memo->number_transaction }}
@endsection

@section('styles')
    {{--  --}}
@endsection

@section('scripts')
    {{--  --}}
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Detail Memo</h5>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <h4 class="col-sm-12 fw-bold">Nomor Memo</h4>
                                <p>{{ $memo->number_transaction }}</p>
                            </div>
                            <div class="col-md-12">
                                <h4 class="col-sm-12 fw-bold">Perihal</h4>
                                <p>{{ $memo->regarding }}</p>
                            </div>

                            <div class="col-md-6">
                                <h4 class="col-sm-12 fw-bold">Pemohon</h4>
                                <p>{{ $memo->from_user->name }}</p>
                            </div>

                            <div class="col-md-6">
                                <h4 class="col-sm-12 fw-bold">Termohon</h4>
                                <p>{{ $memo->to_user->name }}</p>
                            </div>
                            @if ($memo->file)
                                <div class="col-md-6">
                                    <h4 class="col-sm-12 fw-bold">Lampiran</h4>
                                    <a href="{{ route('attachment.memo', $memo->id) }}" target="_blank"
                                        class="btn btn-primary" target="_blank">Download</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tanda Tangan</h5>
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('/storage/memo/qr-codes-signature/' . $memo->qr_code_file) }}"
                                alt="{{ $memo->number_transaction }}" width="200">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Isi Memo</h5>
                        {!! $memo->content !!}
                    </div>
                </div>
            </div>
        </div>
        @if ($memo->pre_memo)
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Memo Kainst</h5>
                            <div class="row my-2">
                                <div class="col-lg-3 col-md-4 label fw-bold">Nomor Memo</div>
                                <div class="col-lg-9 col-md-8">{{ $memo->pre_memo->number_transaction }}</div>
                            </div>

                            <div class="row my-2">
                                <div class="col-lg-3 col-md-4 label fw-bold">Dari</div>
                                <div class="col-lg-9 col-md-8">{{ $memo->pre_memo->from_user->name }}</div>
                            </div>

                            <div class="row my-2">
                                <div class="col-lg-3 col-md-4 label fw-bold">Dibuat</div>
                                <div class="col-lg-9 col-md-8">{{ $memo->pre_memo->created_at }}</div>
                            </div>

                            <div class="row my-2">
                                <div class="col-lg-3 col-md-4 label fw-bold">Isi</div>
                                <div class="col-lg-9 col-md-8">{!! $memo->pre_memo->content !!}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endif
    </section>
@endsection
