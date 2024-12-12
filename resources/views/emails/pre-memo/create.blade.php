@extends('layouts.email')

@section('content')
    <h2 class="text-center">Memo Kainst</h2>
    <p>
        Nomor memo {{ $noMemo }} telah dibuat, silahkan diproses lebih lanjut
    </p>
    <div class="container-btn">
        <a href="{{ $link }}" target="_blank" class="btn btn-primary btn-action">Tampilkan Memo</a>
    </div>
    <p>Terima Kasih.</p>
@endsection
