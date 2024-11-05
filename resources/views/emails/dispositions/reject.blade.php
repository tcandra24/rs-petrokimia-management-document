@extends('layouts.email')

@section('content')
    <h2 class="text-center">Disposisi</h2>
    @if ($memo)
        <p>Berikut nomor memo yang telah diajukan {{ $memo->number_transaction }}</p>
    @endif
    <p>
        Nomor disposisi {{ $noDisposition }} telah ditolak, silahkan dievaluasi lebih lanjut
    </p>
    <p>
        Catatan:
    </p>
    <p>
        {{ $note }}
    </p>
    <p>Terima Kasih.</p>
@endsection
