@extends('layouts.error')

@section('title')
    Error 429
@endsection

@section('content')
    <h1>429</h1>
    <h2>Terlalu Banyak Permintaan pada Halaman ini.</h2>
    <a class="btn" href="{{ route('dashboard.index') }}">Kembali Ke Dashboard</a>
    <img src=" {{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5"
        alt="Terlalu Banyak Permintaan pada Halaman ini">
    <div class="credits">
    </div>
@endsection
