<!DOCTYPE html>
<html>
<head>
    <title>Notulen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        h1, h2, h3, h4, h5, h6 {
            font-weight: bold;
        }
        p {
            margin: 10px 0;
        }
        ul, ol {
            margin: 10px 0 10px 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100%;
            height: auto;
        }

        .header, .content {
            text-align: center;
        }
        .header h1, .header h3 {
            margin: 0;
        }
        .content p {
            margin: 5px 0;
        }
        .content p strong {
            display: inline-block;
            width: 150px;
            text-align: left;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature p {
            margin: 0;
        }
        .ttd {
            margin-top: 10px;
        }
        .ttd img {
            width: 150px; /* Sesuaikan ukuran gambar */
            height: auto;
        }
        .content, .footer {
            text-align: left;
        }
        .footer {
            position: absolute;
            bottom: 40px;
            right: 40px;
        }
        .footer p {
            margin-left: 25px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>NOTULEN</h1>
        <h3>RAPAT DOMAIN APLIKASI</h3>
    </div>
    <div class="content">
        <p><strong>Rapat:</strong> {{ $notulen->jadwal->name_rapat }}</p>
        <p><strong>Hari/Tanggal:</strong> {{ \Carbon\Carbon::parse($notulen->jadwal->tanggal)->isoFormat('dddd, D MMMM Y') }}</p>
        <p><strong>Waktu Sidang/Rapat:</strong> {{ $notulen->jadwal->jam_mulai }} - {{ $notulen->jadwal->jam_selesai }}</p>
        <p><strong>Tempat:</strong> {{ $notulen->jadwal->tempat_rapat }}</p>
        <p><strong>Pimpinan Rapat:</strong></p>
        <p><strong>Ketua:</strong> {{ $notulen->penanggung_jawab->nama_pegawai }}</p>
        <p><strong>Pencatat:</strong> {{ $notulen->pencatat->nama_pegawai }}</p>
        <p><strong>Peserta Rapat:</strong> Daftar Terlampir</p>
        <p><strong>Kesimpulan:</strong></p>
        <div>{!! $notulen->text !!}</div>
    </div>
    <div class="footer">
    <p>Notulis</p>
    <div class="ttd">
        @php
            $ttdDefault = public_path('images/default-ttd.jpg');
        @endphp
        @if($notulen->pic && $notulen->pic->user && $notulen->pic->user->ttd)
            @php
                $ttdPath = public_path('images/ttd/' . $notulen->pic->user->ttd);
            @endphp
            @if(file_exists($ttdPath))
                <img src="file://{{ $ttdPath }}" alt="Pencatat Signature">
            @else
                <img src="file://{{ $ttdDefault }}" alt="Default Signature">
            @endif
        @else
            <img src="file://{{ $ttdDefault }}" alt="Default Signature">
        @endif
    </div>
    <p>{{ $notulen->pic ? $notulen->pic->nama_pegawai : 'N/A' }}</p>
</div>
</body>
</html>
