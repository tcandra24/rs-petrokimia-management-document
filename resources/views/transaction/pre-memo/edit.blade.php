@extends('layouts.app')

@section('title')
    Edit Memo
@endsection

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
    <script src="https://cdn.tiny.cloud/1/5oql2rbngsovyxasavqk4844mwig2cn7zvt27ffehxydtxms/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#divisions').select2()
            $('#instructions').select2()
        })
    </script>
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit</h5>
                        <form class="row g-3" method="POST" action="{{ route('pre-memos.update', $memo->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="col-md-12">
                                <label for="committee" class="form-label">Perihal<span class="text-danger">*</span></label>
                                <input type="text" name="regarding"
                                    class="form-control {{ $errors->has('regarding') ? 'border border-danger' : '' }}"
                                    id="regarding" value="{{ $memo->regarding }}">
                                @error('regarding')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="from_user_id" class="form-label">
                                    Pemohon<span class="text-danger">*</span>
                                </label>
                                <select name="from_user_id" id="from_user_id"
                                    class="form-control {{ $errors->has('from_user_id') ? 'border border-danger' : '' }}">
                                    <option value="">Pilih Pemohon</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $memo->from_user->id === $user->id ? 'selected' : '' }}>{{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('from_user_id')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="to_user_id" class="form-label">
                                    Termohon<span class="text-danger">*</span>
                                </label>
                                <select name="to_user_id" id="to_user_id"
                                    class="form-control {{ $errors->has('to_user_id') ? 'border border-danger' : '' }}">
                                    <option value="">Pilih Termohon</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $memo->to_user->id === $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('to_user_id')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="content" class="form-label">Isi<span class="text-danger">*</span></label>
                                <div class="d-block">
                                    <textarea name="content" class="tinymce-editor">{!! $memo->content !!}</textarea>
                                </div>
                                @error('content')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div>

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
