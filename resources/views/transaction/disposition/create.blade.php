@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}" />
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
        $('#division').select2()
        $('#instruction').select2()
    </script>
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah</h5>
                        <form class="row g-3" method="POST" action="{{ route('dispositions.store') }}">
                            @csrf
                            <div class="col-md-6">
                                <label for="committee" class="form-label">Komite</label>
                                <select id="committee" name="committee"
                                    class="form-select {{ $errors->has('committee') ? 'border border-danger' : '' }}">
                                    <option value="" selected>Pilih Komite</option>
                                    <option value="medic">Medik</option>
                                    <option value="nursing">Keperawatan</option>
                                </select>
                                @error('committee')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Sifat</label>
                                <div class="col-sm-10 d-flex">
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="radio" name="is_urgent" id="is_urgent"
                                            value="1" checked>
                                        <label class="form-check-label" for="is_urgent">
                                            Segera
                                        </label>
                                    </div>
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="radio" name="is_urgent" id="is_not_urgent"
                                            value="0">
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
                            <div class="col-md-6">
                                <label for="division" class="form-label">Divisi</label>
                                <select id="division" name="division_id[]"
                                    class="form-select {{ $errors->has('division_id') ? 'border border-danger' : '' }}"
                                    multiple>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                                    @endforeach
                                </select>
                                @error('division_id')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="instruction" class="form-label">Instruksi</label>
                                <select id="instruction" name="instruction_id[]"
                                    class="form-select {{ $errors->has('instruction_id') ? 'border border-danger' : '' }}"
                                    multiple>
                                    @foreach ($instructions as $instruction)
                                        <option value="{{ $instruction->id }}">{{ $instruction->name }}</option>
                                    @endforeach
                                </select>
                                @error('instruction_id')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="file" class="form-label">Komite</label>
                                <input type="file" name="file"
                                    class="form-control {{ $errors->has('file') ? 'border border-danger' : '' }}"
                                    id="file">
                                @error('file')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div>

                            <div class="text-left">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
