<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notulen Rapat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            margin: 0 20px;
        }
        .content h2 {
            margin-top: 0;
        }
        .table {
            width: 100%;
            margin-top: 20px;
        }
        .table tr {
            vertical-align: top;
        }
        .table td:first-child {
            width: 20%;
            font-weight: bold;
        }
        .table td {
            padding: 4px 8px;
        }
        .signature {
            margin-top: 40px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>NOTULEN</h1>
        <h2>RAPAT DOMAIN APLIKASI</h2>
    </div>
    <div class="content">
        <table class="table">
            <tr>
                <td>Rapat</td>
                <td>: Pembahasan Persiapan SPBE Tahun 2024</td>
            </tr>
            <tr>
                <td>Hari / Tanggal</td>
                <td>: {{ $data['tanggal'] }}</td>
            </tr>
            <tr>
                <td>Waktu Sidang / Rapat</td>
                <td>: {{ $data['waktu'] }}</td>
            </tr>
            <tr>
                <td>Tempat</td>
                <td>: {{ $data['tempat'] }}</td>
            </tr>
            <tr>
                <td>Pimpinan Rapat</td>
            </tr>
            <tr>
                <td>Ketua</td>
                <td>: {{ $data['pimpinan'] }}</td>
            </tr>
            <tr>
                <td>Pencatat</td>
                <td>: {{ $data['pencatat'] }}</td>
            </tr>
            <tr>
                <td>Peserta Rapat</td>
                <td>: Terlampir</td>
            </tr>
            <tr>
                <td>Kesimpulan</td>
                <td>: {!! $data['notulensi'] !!}</td>
            </tr>
        </table>
        <div class="signature">
            <p>Notulis</p>
            <p>{{ $data['notulis'] }}</p>
        </div>
    </div>
</body>
</html>
