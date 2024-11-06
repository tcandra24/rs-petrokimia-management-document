@extends('layouts.app')

@section('title')
    Edit Divisi
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
                        <h5 class="card-title">Edit</h5>
                        <form method="POST" action="{{ route('sub-divisions.update', $subDivision->id) }}">
                            @csrf
                            @method('PATCH')
                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" value="{{ $subDivision->name }}"
                                        class="form-control  {{ $errors->has('name') ? 'border border-danger' : '' }}">
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
                                <label for="acronym" class="col-sm-2 col-form-label">Divisi</label>
                                <div class="col-sm-10">
                                    <select id="division" name="division_id"
                                        class="form-select {{ $errors->has('division_id') ? 'border border-danger' : '' }}">
                                        <option value="">Pilih Divisi</option>
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division->id }}"
                                                {{ $division->id === $subDivision->division->id ? 'selected' : '' }}>
                                                {{ $division->name }}</option>
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
                            </div>

                            <div class="row mb-3">
                                <legend class="col-form-label col-sm-2 pt-0"></legend>
                                <div class="col-sm-10">

                                    <div class="form-check">
                                        <input class="form-check-input" name="is_active" type="checkbox" id="is_active"
                                            {{ $subDivision->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Aktif
                                        </label>
                                    </div>

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
