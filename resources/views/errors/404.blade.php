@extends('layouts.error')

@section('title')
    Error 404
@endsection

@section('content')
    <h1>404</h1>
    <h2>Halaman tidak ditemukan.</h2>
    <a class="btn" href="{{ route('dashboard.index') }}">Kembali Ke Dashboard</a>
    <img src=" {{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5" alt="Halaman tidak ditemukan">
    <div class="credits">
    </div>
@endsection
