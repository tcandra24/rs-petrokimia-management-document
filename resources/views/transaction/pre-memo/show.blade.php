@extends('layouts.app')

@section('title')
    Detail Memo Kainst {{ $memo->number_transaction }}
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
                        <div class="row my-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Memo Kainst</div>
                            <div class="col-lg-9 col-md-8">{{ $memo->number_transaction }}</div>
                        </div>

                        <div class="row my-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Status</div>
                            <div class="col-lg-9 col-md-8">{{ $memo->status }}</div>
                        </div>

                        <div class="row my-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Perihal</div>
                            <div class="col-lg-9 col-md-8">{{ $memo->regarding }}</div>
                        </div>

                        <div class="row my-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Termohon</div>
                            <div class="col-lg-9 col-md-8">{{ $memo->to_user->name }}</div>
                        </div>
                        @if ($memo->file)
                            <div class="row my-2">
                                <div class="col-lg-3 col-md-4 label fw-bold">Lampiran</div>
                                <div class="col-lg-9 col-md-8">
                                    <a href="{{ route('attachment.pre-memo', $memo->id) }}" target="_blank"
                                        class="btn btn-primary" target="_blank">Download</a>
                                </div>
                            </div>
                        @endif

                        @if (auth()->user()->id === $memo->to_user->id && $memo->status === 'Dibuat')
                            <form method="POST" action="{{ route('transaction.pre-memo.change-status', $memo->id) }}">
                                @csrf
                                <div class="row my-2">
                                    <div class="col-lg-3 col-md-4 label fw-bold">Note</div>
                                    <div class="col-lg-9 col-md-8">
                                        <div class="row g-3">
                                            <textarea class="form-control {{ $errors->has('note') ? 'border border-danger' : '' }}" name="note" id=""
                                                cols="30" rows="5"></textarea>
                                            @error('note')
                                                <span class="text-danger">
                                                    <small>
                                                        <i>{{ $message }}</i>
                                                    </small>
                                                </span>
                                            @enderror
                                            <fieldset class="row my-2">
                                                <div class="col-sm-10">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status"
                                                            id="approve" value="approve" checked>
                                                        <label class="form-check-label" for="approve">
                                                            Menyetujui
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
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-lg-3 col-md-4 label fw-bold"></div>
                                    <div class="col-lg-9 col-md-8">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="row my-2">
                                <div class="col-lg-3 col-md-4 label fw-bold">Note</div>
                                <div class="col-lg-9 col-md-8">{{ $memo->note }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tanda Tangan</h5>
                        @if ($memo->status === 'Dibuat')
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
                                        <img src="{{ asset('/storage/pre-memo/qr-codes-signature/' . $memo->qr_code_file) }}"
                                            alt="{{ $memo->number_transaction }}" width="200">
                                    </div>
                                </div>
                            </div>
                        @endif
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
    </section>
@endsection
