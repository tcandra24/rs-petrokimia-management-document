<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disposisi | {{ $disposition->number_transaction }}</title>
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
            font-size: 25px;
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
            <img src="{{ $logo }}" width="200" alt="Logo">
        </div>

        <div class="container-title">
            <h1 class="title">
                Disposisi
            </h1>
        </div>
        <p>
            <span style="font-weight: bold">Nomor Agenda:</span> {{ $disposition->number_transaction }}<br>
            <span style="font-weight: bold">Tipe:</span> {{ $disposition->memo ? 'Memo' : 'Surat Masuk' }}<br>
            <span style="font-weight: bold">Sifat:</span> {{ $disposition->is_urgent ? 'Segera' : 'Biasa' }}<br>
            <span style="font-weight: bold">Komite:</span> {{ $disposition->committee }}<br>
            <span style="font-weight: bold">Status:</span> {{ $disposition->status }}<br>
            <span style="font-weight: bold">Tanggal:</span>
            {{ Carbon\Carbon::parse($disposition->created_at)->format('d F Y') }}
        </p>
        <p>
            <span style="font-weight: bold">Divisi:</span>
            <br>
            @foreach ($disposition->sub_divisions as $sub_division)
                <span>
                    {{ $sub_division->division->name }} | {{ $sub_division->name }},
                </span>
            @endforeach
        </p>
        <p>
            <span style="font-weight: bold">Instruksi / Delegasi:</span>
            <br>
            @foreach ($disposition->instructions as $instruction)
                <span>
                    {{ $instruction->name }},
                </span>
            @endforeach
        </p>
    </div>

    <div class="content">
        <p>
            Note: {{ $disposition->note }}
        </p>
    </div>

    @if ($qrcode_image)
        <div class="container-signature">
            <div class="signature">
                <img src="{{ $qrcode_image }}" width="100" height="100"
                    alt="{{ $disposition->number_transaction }}">
            </div>
            <p style="font-weight: bold">{{ $disposition->approve_by }}</p>
            <p> Direktur </p>
        </div>
    @endif
</body>

</html>
