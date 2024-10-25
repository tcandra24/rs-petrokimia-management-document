<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memo | {{ $memo->number_transaction }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .header,
        .content,
        .container-signature {
            margin: 0 auto;
            width: 80%;
        }

        .header {
            text-align: left;
            margin-bottom: 30px;
        }

        .header p {
            line-height: 1.6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        .no-border {
            border: none;
        }

        .instructions {
            margin-top: 20px;
        }

        .instructions p {
            line-height: 1.8;
        }

        .numbered-list {
            margin-left: 20px;
        }

        .container-title {
            padding-bottom: 13px;
            width: 100%;
        }

        .title {
            text-align: center;
            text-transform: uppercase;
            font-size: 50px;
        }

        .signature {
            width: 100px;
            height: 100px;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="image">
            <img src="{{ asset('assets/img/logo-black-white.png') }}" width="250" alt="Logo">
        </div>

        <div class="container-title">
            <h1 class="title">
                Memo
            </h1>
        </div>
        <p>
            Kepada: Direktur RSPG Driyorejo<br>
            Dari: {{ $memo->from_user->division->name }}<br>
            Perihal: {{ $memo->regarding }}<br>
            Nomor: {{ $memo->number_transaction }}<br>
            Tanggal: {{ Carbon\Carbon::parse($memo->created_at)->format('d F Y') }}
        </p>
        <hr>
    </div>

    <div class="content">
        {!! $memo->content !!}
    </div>

    <div class="container-signature">
        <div class="signature">
            <img src="{{ $qrcode_image }}" width="100" height="100" alt="{{ $memo->number_transaction }}">
        </div>
        <p style="font-weight: bold">{{ $memo->from_user->name }}</p>
        <p>{{ $memo->from_user->division->name }}</p>
    </div>
</body>

</html>
