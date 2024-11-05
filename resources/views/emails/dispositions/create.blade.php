@extends('layouts.email')

@section('content')
    <h2 class="text-center">Disposisi</h2>
    @if ($memo)
        <p>Berikut nomor memo yang telah diajukan {{ $memo->number_transaction }}</p>
    @endif
    <p>
        Nomor disposisi {{ $noDisposition }} telah dibuat, silahkan diproses lebih lanjut
    </p>
    <p>Terima Kasih.</p>
@endsection
