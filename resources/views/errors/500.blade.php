@extends('layouts.error')

@section('title')
    Error 500
@endsection

@section('content')
    <h1>500</h1>
    <h2>Terjadi Error di Server.</h2>
    <a class="btn" href="{{ route('dashboard.index') }}">Kembali Ke Dashboard</a>
    <img src=" {{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5" alt="Terjadi Error di Server">
    <div class="credits">
    </div>
@endsection
