@extends('layouts.app')

@section('title')
    Tambah Disposisi
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
                        <h5 class="card-title">Tambah</h5>
                        <form class="row g-3" method="POST" action="{{ route('dispositions.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            {{-- <div class="col-md-6">
                                <label for="committee" class="form-label">Komite</label>
                                <select id="committee" name="committee"
                                    class="form-select {{ $errors->has('committee') ? 'border border-danger' : '' }}">
                                    <option value="-" selected>Pilih Komite</option>
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
                                <label for="email" class="form-label">Sifat<span class="text-danger">*</span></label>
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
                                <label for="divisions" class="form-label">Divisi<span class="text-danger">*</span></label>
                                <select id="divisions" name="sub_divisions[]"
                                    class="form-select {{ $errors->has('sub_divisions') ? 'border border-danger' : '' }}"
                                    multiple="multiple">
                                    @foreach ($divisions as $division)
                                        <optgroup label="{{ $division->name }}">
                                            @foreach ($division->sub_divisions as $sub_division)
                                                <option value="{{ $sub_division->id }}">{{ $sub_division->name }}</option>
                                            @endforeach
                                        </optgroup>
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
                            <div class="col-md-6">
                                <label for="instructions" class="form-label">Instruksi<span
                                        class="text-danger">*</span></label>
                                <select id="instructions" name="instructions[]"
                                    class="form-select {{ $errors->has('instructions') ? 'border border-danger' : '' }}"
                                    multiple>
                                    @foreach ($instructions as $instruction)
                                        <option value="{{ $instruction->id }}">{{ $instruction->name }}</option>
                                    @endforeach
                                </select>
                                @error('instructions')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div> --}}
                            <div class="col-md-6">
                                <label for="file" class="form-label">File</label>
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

                            <div class="col-md-6">
                                <label for="memo_id" class="form-label">Memo</label>
                                <select id="memo_id" name="memo_id"
                                    class="form-select {{ $errors->has('memo_id') ? 'border border-danger' : '' }}">
                                    <option value="" selected>Pilih Memo</option>
                                    @foreach ($memos as $memo)
                                        <option value="{{ $memo->id }}">{{ $memo->number_transaction }}</option>
                                    @endforeach
                                </select>
                                @error('memo_id')
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
