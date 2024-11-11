@extends('layouts.error')

@section('title')
    Error 419
@endsection

@section('content')
    <h1>419</h1>
    <h2>Halaman Form Input Kadaluarsa.</h2>
    <a class="btn" href="{{ route('dashboard.index') }}">Kembali Ke Dashboard</a>
    <img src=" {{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5" alt="Halaman Form Input Kadaluarsa">
    <div class="credits">
    </div>
@endsection
