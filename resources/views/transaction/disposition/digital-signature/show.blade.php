@extends('layouts.app')

@section('title')
    Hasil Verifikasi Disposisi {{ $disposition->number_transaction }}
@endsection

@section('styles')
    {{--  --}}
@endsection

@section('scripts')
    {{--  --}}
@endsection

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Detail Verifikasi</h5>
                        <div class="row g-3">
                            @if ($status)
                                <div class="col-md-6">
                                    <h4 class="col-sm-4 fw-bold">Nomer</h4>
                                    <p>{{ $disposition->number_transaction }}</p>
                                </div>

                                <div class="col-md-6">
                                    <h4 class="col-sm-4 fw-bold">Dibuat</h4>
                                    <p>{{ $disposition->created_at }}</p>
                                </div>

                                <div class="col-md-6">
                                    <h4 class="col-sm-6 fw-bold">Tgl Approve</h4>
                                    <p>{{ $disposition->approve_by }}</p>
                                    <p>{{ $disposition->approve_datetime }}</p>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Data Tidak Ditemukan
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Status Verifikasi</h5>
                        <div class="d-flex justify-content-center">
                            @if ($status)
                                <img src="{{ asset('/assets/img/check.webp') }}" alt="Verified" width="200">
                            @else
                                <img src="{{ asset('/assets/img/cross.webp') }}" alt="Not Verified" width="200">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
