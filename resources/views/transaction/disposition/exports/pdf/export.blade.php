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
            width: 120px;
            height: 120px;
        }

        .memo-container .table-header {
            width: 100%;
            border-collapse: collapse;
        }

        .memo-container td {
            padding: 3px;
            vertical-align: top;
        }

        .title-row {
            text-align: left;
        }

        .content-row {
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="image">
            <img src="{{ $logo }}" width="150" alt="Logo">
        </div>

        <div class="container-title">
            <h1 class="title">
                Disposisi
            </h1>
        </div>
        <div class="memo-container">
            <table class="table-header">
                <tr>
                    <td class="title-row no-border" width="130">Nomor Agenda:</td>
                    <td class="no-border">:</td>
                    <td class="content-row no-border">{{ $disposition->number_transaction }}</td>
                </tr>
                <tr>
                    <td class="title-row no-border" width="130">Tipe</td>
                    <td class="no-border">:</td>
                    <td class="content-row no-border">{{ $disposition->memo ? 'Memo' : 'Surat Masuk' }}</td>
                </tr>
                <tr>
                    <td class="title-row no-border" width="130">Sifat</td>
                    <td class="no-border">:</td>
                    <td class="content-row no-border">{{ $disposition->is_urgent ? 'Segera' : 'Biasa' }}</td>
                </tr>
                <tr>
                    <td class="title-row no-border" width="150">Dituju Kepada</td>
                    <td class="no-border">:</td>
                    <td class="content-row no-border">{{ $disposition->purpose->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="title-row no-border" width="130">Status</td>
                    <td class="no-border">:</td>
                    <td class="content-row no-border">{{ $disposition->status }}</td>
                </tr>
                <tr>
                    <td class="title-row no-border" width="130">Tanggal</td>
                    <td class="no-border">:</td>
                    <td class="content-row no-border">
                        {{ Carbon\Carbon::parse($disposition->created_at)->format('d F Y') }}
                    </td>
                </tr>
                <tr>
                    <td class="title-row no-border" width="130">Kabag / Kabid</td>
                    <td class="no-border">:</td>
                    <td class="content-row no-border">
                        @foreach ($disposition->divisions as $division)
                            <span>
                                {{ $division->name }},
                            </span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="title-row no-border" width="130">Unit</td>
                    <td class="no-border">:</td>
                    <td class="content-row no-border">
                        @foreach ($disposition->sub_divisions as $sub_division)
                            <span>
                                {{ $sub_division->name }},
                            </span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="title-row no-border" width="130">Instruksi / Delegasi</td>
                    <td class="no-border">:</td>
                    <td class="content-row no-border">
                        @foreach ($disposition->instructions as $instruction)
                            <span>
                                {{ $instruction->name }},
                            </span>
                        @endforeach
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="content">
        <p>
            Note: {{ $disposition->note }}
        </p>
    </div>

    @if ($qrcode_image)
        <div class="container-signature">
            <p style="font-weight: bold">Rumah sakit Petrokimia Gresik</p>
            <div class="signature">
                <img src="{{ $qrcode_image }}" width="120" height="120"
                    alt="{{ $disposition->number_transaction }}">
            </div>
            <p style="font-weight: bold">{{ $disposition->approve_by }}</p>
            <p> Direktur </p>
        </div>
    @endif
</body>

</html>
