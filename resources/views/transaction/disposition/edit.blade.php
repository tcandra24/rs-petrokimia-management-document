@extends('layouts.app')

@section('title')
    Edit Disposisi
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
                        <form class="row g-3" method="POST" action="{{ route('dispositions.update', $disposition->id) }}"
                            enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
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
                                        <option value="{{ $memo->id }}"
                                            {{ $disposition->memo?->id === $memo->id ? 'selected' : '' }}>
                                            {{ $memo->number_transaction }}</option>
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
