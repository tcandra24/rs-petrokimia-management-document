@extends('layouts.auth')

@section('content')
    <div class="d-flex justify-content-center py-4">
        <a href="#" class="logo d-flex align-items-center w-auto">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Document Control">
        </a>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                <p class="text-center small">Masukan username & password</p>
            </div>
            <form class="row g-3 needs-validation" action="{{ route('login') }}" method="POST" novalidate>
                @if (session()->has('errors'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        {{ session()->get('errors') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @csrf
                <div class="col-12">
                    <label for="yourUsername" class="form-label">Email</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" name="email" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Masukan username.</div>
                    </div>
                </div>

                <div class="col-12">
                    <label for="yourPassword" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="yourPassword" required>
                    <div class="invalid-feedback">Masukan password!</div>
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
    <div class="credits">
        Dibuat oleh <a href="#">{{ env('APP_CREATE_BY') }}</a>.
    </div>
@endsection
