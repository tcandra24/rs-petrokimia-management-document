@extends('layouts.app')

@section('title')
    Tambah Memo
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

    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet"> --}}
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#divisions').select2()
            $('#instructions').select2()

            if (document.getElementById('quill-editor-area')) {
                const editor = new Quill('#quill-editor', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{
                                    font: [],
                                },
                                {
                                    size: [],
                                },
                            ],
                            ["bold", "italic", "underline", "strike"],
                            [{
                                    color: [],
                                },
                                {
                                    background: [],
                                },
                            ],
                            [{
                                    script: "super",
                                },
                                {
                                    script: "sub",
                                },
                            ],
                            [{
                                    list: "ordered",
                                },
                                {
                                    list: "bullet",
                                },
                                {
                                    indent: "-1",
                                },
                                {
                                    indent: "+1",
                                },
                            ],
                            [
                                "direction",
                                {
                                    align: [],
                                },
                            ],
                            ["link", "image", "video"],
                            ["clean"],
                        ],
                    },
                });

                const quillEditor = document.getElementById('quill-editor-area');
                editor.on('text-change', function() {
                    quillEditor.value = editor.root.innerHTML;
                });

                quillEditor.addEventListener('input', function() {
                    editor.root.innerHTML = quillEditor.value;
                });
            }
        })
    </script>
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah</h5>
                        <form class="row g-3" method="POST" action="{{ route('memos.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <label for="committee" class="form-label">Perihal<span class="text-danger">*</span></label>
                                <input type="text" name="regarding"
                                    class="form-control {{ $errors->has('regarding') ? 'border border-danger' : '' }}"
                                    id="regarding">
                                @error('regarding')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="from_user_id" class="form-label">Pemohon<span
                                        class="text-danger">*</span></label>
                                <select id="from_user_id" name="from_user_id" disabled
                                    class="form-select {{ $errors->has('from_user_id') ? 'border border-danger' : '' }}">
                                    <option value="">Pilih Pemohon</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $user->id === auth()->user()->id ? 'selected' : '' }}>
                                            {{ $user->name }}</option>
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
                                <label for="to_user_id" class="form-label">Termohon<span
                                        class="text-danger">*</span></label>
                                <select id="to_user_id" name="to_user_id"
                                    class="form-select {{ $errors->has('to_user_id') ? 'border border-danger' : '' }}">
                                    <option value="">Pilih Termohon</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
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
                                    <div id="quill-editor" class="mb-3"></div>
                                </div>
                                <textarea rows="3" class="mb-3 d-none" name="content" id="quill-editor-area"></textarea>
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
