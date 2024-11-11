@extends('layouts.error')

@section('title')
    Error 403
@endsection

@section('content')
    <h1>403</h1>
    <h2>Anda tidak diijinkan mengakses halaman ini.</h2>
    <a class="btn" href="{{ route('dashboard.index') }}">Kembali Ke Dashboard</a>
    <img src=" {{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5"
        alt="Anda tidak diijinkan mengakses halaman ini">
    <div class="credits">
    </div>
@endsection
