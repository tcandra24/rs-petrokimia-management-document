@extends('layouts.email')

@section('content')
    <h2 class="text-center">Memo</h2>
    <p>Nomor memo anda dengan nomor {{ $noMemo }} akan diproses, silahkan tunggu sampai notifikasi/pemberitahuan lebih
        lanjut</p>
    <div class="container-btn">
        <a href="{{ $link }}" target="_blank" class="btn btn-primary btn-action">Tampilkan Memo</a>
    </div>
    <p>Terima Kasih.</p>
@endsection
