@extends('layouts.app')

@section('title')
    Tambah Divisi
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
                        <form method="POST" action="{{ route('divisions.store') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name"
                                        class="form-control {{ $errors->has('name') ? 'border border-danger' : '' }}">
                                    @error('name')
                                        <span class="text-danger">
                                            <small>
                                                <i>{{ $message }}</i>
                                            </small>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="acronym" class="col-sm-2 col-form-label">Nama Pendek</label>
                                <div class="col-sm-10">
                                    <input type="text" name="acronym"
                                        class="form-control {{ $errors->has('acronym') ? 'border border-danger' : '' }}">
                                    @error('acronym')
                                        <span class="text-danger">
                                            <small>
                                                <i>{{ $message }}</i>
                                            </small>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
