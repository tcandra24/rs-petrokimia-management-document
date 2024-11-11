@extends('layouts.error')

@section('title')
    Error 503
@endsection

@section('content')
    <h1>503</h1>
    <h2>Terjadi kesalahan pada Server.</h2>
    <a class="btn" href="{{ route('dashboard.index') }}">Kembali Ke Dashboard</a>
    <img src=" {{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5" alt="Terjadi kesalahan pada Server">
    <div class="credits">
    </div>
@endsection
