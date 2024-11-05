@extends('layouts.app')

@section('title')
    Notifikasi
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Notifikasi</h5>

                        <div class="list-group">
                            @forelse($notifications as $notification)
                                <a href="{{ route('notifications.show', $notification->id) }}"
                                    class="list-group-item list-group-item-action" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $notification->data['title'] }}</h5>
                                        {{-- <small>3 days ago</small> --}}
                                    </div>
                                    <p class="mb-1">{{ $notification->data['message'] }}</p>
                                </a>
                            @empty
                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    Tidak ada notifikasi
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
