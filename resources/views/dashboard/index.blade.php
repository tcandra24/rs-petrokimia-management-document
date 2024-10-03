@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('styles')
    {{--  --}}
@endsection

@section('scripts')
    {{--  --}}
@endsection

@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle me-1"></i>
                    Selamat Datang <b>{{ ucwords(auth()->user()->name) }}</b>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </section>
@endsection
