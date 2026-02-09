<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Jatuh Tempo</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            background-color: #f2f2f2;
        }
        th, td {
            padding: 6px;
            text-align: center;
        }
    </style>
</head>
<body>

<p style="text-align:right;">
    Tanggal Rilis: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
</p>

<h2 style="text-align:center;">Data User Melewati Jatuh Tempo</h2>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No Rumah</th>
            <th>Alamat</th>
            <th>Tanggal Jatuh Tempo</th>
            <th>Total</th>
            <th>Denda</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->user->name ?? '-' }}</td>
            <td>{{ $item->user->no_rumah ?? '-' }}</td>
            <td>{{ $item->user->alamat ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d-m-Y') }}</td>
            <td>Rp {{ number_format($item->total,0,',','.') }}</td>
            <td>Rp {{ number_format($item->denda,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
