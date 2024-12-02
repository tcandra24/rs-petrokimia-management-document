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
            margin-top: 10px;
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
            margin-top: 10px;
        }

        .instructions p {
            line-height: 1.8;
        }

        .numbered-list {
            margin-left: 10px;
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
                Memo
            </h1>
        </div>
        <div class="memo-container">
            <table class="table-header">
                <tr>
                    <td class="title-row no-border" width="80">Kepada</td>
                    <td class="no-border">:</td>
                    <td class="content-row no-border">Direktur RS Petrokimia Gresik Driyorejo</td>
                </tr>
                <tr>
                    <td class="title-row no-border" width="80">Dari</td>
                    <td class="no-border">:</td>
                    <td class="content-row no-border">{{ $memo->from_user->division?->name }}</td>
                </tr>
                <tr>
                    <td class="title-row no-border" width="80">Perihal</td>
                    <td class="no-border">:</td>
                    <td class="content-row no-border">{{ $memo->regarding }}</td>
                </tr>
                <tr>
                    <td class="title-row no-border" width="80">Nomor</td>
                    <td class="no-border">:</td>
                    <td class="content-row no-border">{{ $memo->number_transaction }}</td>
                </tr>
                <tr>
                    <td class="title-row no-border" width="80">Tanggal</td>
                    <td class="no-border">:</td>
                    <td class="content-row no-border">
                        {{ Carbon\Carbon::parse($memo->created_at)->format('d F Y') }}
                    </td>
                </tr>
            </table>
        </div>
        <hr>
    </div>

    <div class="content">
        {!! $memo->content !!}
    </div>

    <div class="container-signature">
        <p style="font-weight: bold">{{ $memo->from_user->division?->name }}</p>
        <div class="signature">
            <img src="{{ $qrcode_image }}" width="120" height="120" alt="{{ $memo->number_transaction }}">
        </div>
        <p style="font-weight: bold">{{ $memo->from_user->name }}</p>
        <p>{{ $memo->from_user->position?->name }}</p>
    </div>
</body>

</html>
