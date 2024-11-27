@extends('layouts.app')

@section('title')
    Profil
@endsection

@section('styles')
    {{--  --}}
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    @if ($errors->any())
        <script>
            $('#button-change-password').trigger('click')
        </script>
    @endif
@endsection

@section('content')
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&amp;background=random&amp;color=ffffff&amp;size=100"
                            alt="Profile" class="rounded-circle">
                        <h2>{{ auth()->user()->name }}</h2>
                        <h3>{{ auth()->user()->division->name ?? '-' }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview"
                                    aria-selected="true" role="tab">Rangkuman</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password"
                                    id="button-change-password" aria-selected="false" role="tab" tabindex="-1">
                                    Ubah Password
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade profile-overview active show" id="profile-overview" role="tabpanel">
                                <h5 class="card-title">Profil Lengkap</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Nama</div>
                                    <div class="col-lg-9 col-md-8">{{ auth()->user()->name }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ auth()->user()->email }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Jabatan</div>
                                    <div class="col-lg-9 col-md-8">
                                        {{ auth()->user()->position->name ?? '-' }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Unit</div>
                                    <div class="col-lg-9 col-md-8">
                                        {{ auth()->user()->division->name ?? '-' }}
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-change-password" role="tabpanel">
                                <form method="POST" action="{{ route('profile.change-password') }}">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="old_password" class="col-md-4 col-lg-3 col-form-label">
                                            Password Lama
                                        </label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="old_password" type="password"
                                                class="form-control {{ $errors->has('old_password') ? 'border border-danger' : '' }}"
                                                id="old_password">
                                            @error('old_password')
                                                <span class="text-danger">
                                                    <small>
                                                        <i>{{ $message }}</i>
                                                    </small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="new_password" class="col-md-4 col-lg-3 col-form-label">
                                            Password Baru
                                        </label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="new_password" type="password"
                                                class="form-control {{ $errors->has('new_password') ? 'border border-danger' : '' }}"
                                                id="new_password">
                                            @error('new_password')
                                                <span class="text-danger">
                                                    <small>
                                                        <i>{{ $message }}</i>
                                                    </small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="new_password_confirmation" class="col-md-4 col-lg-3 col-form-label">
                                            Konfirmasi Password
                                        </label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="new_password_confirmation" type="password"
                                                class="form-control {{ $errors->has('new_password_confirmation') ? 'border border-danger' : '' }}"
                                                id="new_password_confirmation">
                                            @error('new_password_confirmation')
                                                <span class="text-danger">
                                                    <small>
                                                        <i>{{ $message }}</i>
                                                    </small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Ubah Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
