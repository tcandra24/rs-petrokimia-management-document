@extends('layouts.email')

@section('content')
    <h2 class="text-center">Verifikasi Email</h2>
    <p>{{ $name }},</p>
    <p>Terimakasih telah melakukan pendaftaran ke website kami. Untuk menyelesaikan pendaftaran Anda, harap
        verifikasi alamat email Anda dengan mengklik tombol di bawah ini:</p>
    <div class="container-btn">
        <a href="{{ route('verify', $token) }}" target="_blank" class="btn btn-primary btn-action">Verifikasi</a>
    </div>
    <p>Jika Anda belum membuat akun, tidak ada tindakan lebih lanjut yang diperlukan.</p>
@endsection
