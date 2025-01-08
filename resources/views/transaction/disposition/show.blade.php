@extends('layouts.app')

@section('title')
    Detail Disposisi {{ $disposition->number_transaction }}
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2-bootstrap-5-theme.min.css') }}" />
    <style>
        .select2-container--bootstrap-5.select2-container--focus .select2-selection,
        .select2-container--bootstrap-5.select2-container--open .select2-selection {
            box-shadow: unset !important;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('#divisions').select2({
            placeholder: "Pilih Kabag/Kabid",
            allowClear: true
        })

        $('#sub_divisions').select2({
            placeholder: "Pilih Unit",
            allowClear: true
        })

        $('#instructions').select2({
            placeholder: "Pilih instruksi",
            allowClear: true
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
                            <div class="col-lg-3 col-md-4 label fw-bold">Status</div>
                            <div class="col-lg-9 col-md-8">{{ $disposition->status }}</div>
                        </div>

                        <div class="row my-2">
                            <div class="col-lg-3 col-md-4 label fw-bold">Dibuat</div>
                            <div class="col-lg-9 col-md-8">{{ $disposition->created_at }}</div>
                        </div>

                        @if ($disposition->file)
                            <div class="row my-2">
                                <div class="col-lg-3 col-md-4 label fw-bold">Lampiran</div>
                                <div class="col-lg-9 col-md-8">
                                    <a href="{{ route('attachment.disposition', $disposition->id) }}" target="_blank"
                                        class="btn btn-primary" target="_blank">Download</a>
                                </div>
                            </div>
                        @endif

                        @if (auth()->user()->type === 'director' && $disposition->status === 'Dibuat')
                            <form method="POST"
                                action="{{ route('transaction.disposition.change-status', $disposition->id) }}">
                                @csrf
                                <div class="row my-2">
                                    <div class="col-lg-3 col-md-4 label fw-bold">Sifat</div>
                                    <div class="col-lg-9 col-md-8">
                                        <div class="row g-3">
                                            <div class="col-sm-10 d-flex">
                                                <div class="form-check mx-2">
                                                    <input class="form-check-input" type="radio" name="is_urgent"
                                                        id="is_urgent" value="1" checked>
                                                    <label class="form-check-label" for="is_urgent">
                                                        Segera
                                                    </label>
                                                </div>
                                                <div class="form-check mx-2">
                                                    <input class="form-check-input" type="radio" name="is_urgent"
                                                        id="is_not_urgent" value="0">
                                                    <label class="form-check-label" for="is_not_urgent">
                                                        Biasa
                                                    </label>
                                                </div>
                                            </div>
                                            @error('is_urgent')
                                                <span class="text-danger">
                                                    <small>
                                                        <i>{{ $message }}</i>
                                                    </small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <div class="col-lg-3 col-md-4 label fw-bold">Ditujukan Kepada</div>
                                    <div class="col-lg-6 col-md-4">
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-lg-3 col-md-4 label fw-bold">Komite/Tim/SPI</div>
                                    <div class="col-lg-6 col-md-4">
                                        <div class="row g-3">
                                            <select id="purpose_id" name="purpose_id"
                                                class="form-select {{ $errors->has('purpose_id') ? 'border border-danger' : '' }}">
                                                <option value="" selected>Pilih Tujuan</option>
                                                @foreach ($purposes as $purpose)
                                                    <option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('purpose_id')
                                                <span class="text-danger">
                                                    <small>
                                                        <i>{{ $message }}</i>
                                                    </small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-lg-3 col-md-4 label fw-bold">Kabag/Kabid</div>
                                    <div class="col-lg-9 col-md-8">
                                        <select id="divisions" name="divisions[]"
                                            class="form-select {{ $errors->has('divisions') ? 'border border-danger' : '' }}"
                                            multiple="multiple">
                                            @foreach ($divisions as $division)
                                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('divisions')
                                            <span class="text-danger">
                                                <small>
                                                    <i>{{ $message }}</i>
                                                </small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-lg-3 col-md-4 label fw-bold">Unit</div>
                                    <div class="col-lg-9 col-md-8">
                                        <select id="sub_divisions" name="sub_divisions[]"
                                            class="form-select {{ $errors->has('sub_divisions') ? 'border border-danger' : '' }}"
                                            multiple="multiple">
                                            @foreach ($sub_divisions as $sub_division)
                                                <option value="{{ $sub_division->id }}">{{ $sub_division->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('sub_divisions')
                                            <span class="text-danger">
                                                <small>
                                                    <i>{{ $message }}</i>
                                                </small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-lg-3 col-md-4 label fw-bold">Instruksi</div>
                                    <div class="col-lg col-md-8">
                                        <select id="instructions" name="instructions[]"
                                            class="form-select {{ $errors->has('instructions') ? 'border border-danger' : '' }}"
                                            multiple>
                                            @foreach ($instructions as $instruction)
                                                <option value="{{ $instruction->id }}">{{ $instruction->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('instructions')
                                            <span class="text-danger">
                                                <small>
                                                    <i>{{ $message }}</i>
                                                </small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
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
                                <div class="col-lg-3 col-md-4 label fw-bold">Sifat</div>
                                <div class="col-lg-9 col-md-8">
                                    @if ($disposition->is_urgent)
                                        Segera
                                    @else
                                        Biasa
                                    @endif
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-lg-3 col-md-4 label fw-bold">Dituju Kepada</div>
                                <div class="col-lg-9 col-md-8">{{ $disposition->purpose->name ?? '-' }}</div>
                            </div>

                            <div class="row my-2">
                                <div class="col-lg-3 col-md-4 label fw-bold">Kabag / Kabid</div>
                                <div class="col-lg-9 col-md-8">
                                    <div class="row">
                                        <div class="d-flex align-items-center gap-2 flex-wrap" style="min-width: 200px;">
                                            @foreach ($disposition->divisions as $division)
                                                <span class="badge bg-primary rounded-3 fw-semibold">
                                                    {{ $division->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row my-2">
                                <div class="col-lg-3 col-md-4 label fw-bold">Unit</div>
                                <div class="col-lg-9 col-md-8">
                                    <div class="row">
                                        <div class="d-flex align-items-center gap-2 flex-wrap" style="min-width: 200px;">
                                            @foreach ($disposition->sub_divisions as $sub_division)
                                                <span class="badge bg-primary rounded-3 fw-semibold">
                                                    {{ $sub_division->name }}
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
                                <div class="col-lg-3 col-md-4 label fw-bold">Note</div>
                                <div class="col-lg-9 col-md-8">{{ $disposition->note }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tanda Tangan</h5>
                        @if ($disposition->status === 'Dibuat' || $disposition->status === 'Ditolak')
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
