@extends('layouts.app')

@section('title')
    Tambah Pengguna
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
                        <form class="row g-3" method="POST" action="{{ route('users.store') }}">
                            @csrf
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name"
                                    class="form-control {{ $errors->has('name') ? 'border border-danger' : '' }}"
                                    id="name">
                                @error('name')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email"
                                    class="form-control {{ $errors->has('email') ? 'border border-danger' : '' }}"
                                    id="email">
                                @error('email')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="division" class="form-label">Unit</label>
                                <select id="division" name="division_id"
                                    class="form-select {{ $errors->has('division_id') ? 'border border-danger' : '' }}">
                                    <option value="">Pilih Unit</option>
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
                                <label for="roles" class="form-label">Peran</label>
                                <select id="roles" name="roles[]"
                                    class="form-select {{ $errors->has('roles') ? 'border border-danger' : '' }}">
                                    <option value="">Pilih Peran</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('roles')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="type" class="form-label">Tipe</label>
                                <select id="type" name="type"
                                    class="form-select {{ $errors->has('type') ? 'border border-danger' : '' }}">
                                    <option value="">Pilih Tipe</option>
                                    <option value="general">Umum</option>
                                    <option value="assistant">Asisten</option>
                                    <option value="director">Direktur</option>
                                </select>
                                @error('type')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="position_id" class="form-label">Jabatan</label>
                                <select id="position_id" name="position_id"
                                    class="form-select {{ $errors->has('position_id') ? 'border border-danger' : '' }}">
                                    <option value="">Pilih Jabatan</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                </select>
                                @error('position_id')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password"
                                    class="form-control {{ $errors->has('password') ? 'border border-danger' : '' }}"
                                    id="password">
                                @error('password')
                                    <span class="text-danger">
                                        <small>
                                            <i>{{ $message }}</i>
                                        </small>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="confirm_password" class="form-label">Ulangi Password</label>
                                <input type="password" name="confirm_password"
                                    class="form-control {{ $errors->has('confirm_password') ? 'border border-danger' : '' }}"
                                    id="confirm_password">
                                @error('confirm_password')
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
