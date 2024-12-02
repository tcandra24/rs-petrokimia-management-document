@extends('layouts.app')

@section('title')
    Profil
@endsection

@section('styles')
    {{--  --}}
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    @if (session('active_tab') === 'profile-edit')
        <script>
            $('#button-change-profile').trigger('click')
        </script>
    @elseif(session('active_tab') === 'profile-change-password')
        <script>
            $('#button-change-password').trigger('click')
        </script>
    @endif

    <script>
        $('.delete-image').on('click', function() {
            Swal.fire({
                title: "Yakin Hapus Gambar ?",
                text: 'Gambar yang dihapus tidak bisa dikembalikan',
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#5d87ff",
                confirmButtonText: "Yes",
                closeOnConfirm: !1
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete-image').submit()
                }
            })
        })
    </script>
@endsection

@section('content')
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img class="profile-img-container"
                            src="{{ auth()->user()->image ? asset('storage/users/avatar/' . auth()->user()->image) : 'https://ui-avatars.com/api/?name=' . auth()->user()->name . '&background=random&color=ffffff&size=200' }}"
                            alt="Profile" class="rounded-circle">
                        @if (auth()->user()->image)
                            <button class="btn btn-danger btn-sm my-2 delete-image" title="Remove Image">
                                <i class="bi bi-trash"></i>
                            </button>
                            <form id="form-delete-image" method="POST" action="{{ route('profile.delete-profile') }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
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
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit"
                                    id="button-change-profile">Edit
                                    Profil
                                </button>
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

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <form method="POST" action="{{ route('profile.change-profile') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row mb-3">
                                        <label for="file" class="col-md-4 col-lg-3 col-form-label">Gambar</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="file" type="file" class="form-control" id="file"
                                                value="">
                                            @error('file')
                                                <span class="text-danger">
                                                    <small>
                                                        <i>{{ $message }}</i>
                                                    </small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="name" type="text" class="form-control" id="name"
                                                value="">
                                            @error('name')
                                                <span class="text-danger">
                                                    <small>
                                                        <i>{{ $message }}</i>
                                                    </small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
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
