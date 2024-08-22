@extends('template.main')
@section('title', 'Reports')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@yield('title')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="text-right">
                                <a href="{{ route('reports.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add Report</a>
                                <a href="#" class="btn btn-secondary"><i class="fa-solid fa-file-pdf"></i> Download PDF</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul Rapat</th>
                                        <th>Hari/Tanggal</th>
                                        <th>Waktu Sidang/Rapat</th>
                                        <th>Tempat</th>
                                        <th>Pimpinan Rapat Ketua</th>
                                        <th>Bagian</th>
                                        <th>Kegiatan</th>
                                        <th>Pencatat</th>
                                        <th>Notulis</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reports as $report)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $report->judul }}</td>
                                            <td>{{ $report->tanggal }}</td>
                                            <td>{{ $report->waktu }}</td>
                                            <td>{{ $report->tempat }}</td>
                                            <td>{{ $report->pimpinan }}</td>
                                            <td>{{ $report->bagian }}</td>
                                            <td>{{ $report->kegiatan }}</td>
                                            <td>{{ $report->pencatat }}</td>
                                            <td>{{ $report->notulis }}</td>
                                            <td>
<<<<<<< HEAD:resources/views/reports/index.blade.php
                                                <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-success btn-sm mr-1">
                                                    <i class="fa-solid fa-pen"></i> Edit
                                                </a>
                                                <form class="d-inline" action="{{ route('reports.destroy', $report->id) }}" method="POST">
=======
                                                <form class="d-inline" action="/jadwal-rapat/{{ $data->id }}/edit" method="GET">
                                                    <button type="submit" class="btn btn-success btn-sm mr-1">
                                                        <i class="fa-solid fa-pen"></i> Edit
                                                    </button>
                                                </form>
                                                <form class="d-inline" action="/jadwal-rapat/{{ $data->id }}" method="POST">
>>>>>>> 6f227ab31cdaf4fa065503d55ddae65d7fc64aa8:resources/views/jadwal-rapat/index.blade.php
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-sm" id="btn-delete"><i class="fa-solid fa-trash-can"></i> Delete
                                                    </button>
                                                </form>


                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
