@extends('layouts.error')

@section('title')
    Error 401
@endsection

@section('content')
    <h1>401</h1>
    <h2>Anda tidak diijinkan mengakses halaman ini.</h2>
    <a class="btn" href="{{ route('dashboard.index') }}">Kembali Ke Dashboard</a>
    <img src=" {{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5"
        alt="Anda tidak diijinkan mengakses halaman ini">
    <div class="credits">
    </div>
@endsection
