@extends('template.main')
@section('title', 'Edit Jadwal Rapat')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@yield('title')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/jadwal-rapat">Jadwal Rapat</a></li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="text-right">
                                <a href="/jadwal-rapat" class="btn btn-warning btn-sm">
                                    <i class="fa-solid fa-arrow-rotate-left"></i> Back
                                </a>
                            </div>
                        </div>
                        <form class="needs-validation" novalidate action="/jadwal-rapat/{{ $jadwal->id}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="judul">Judul</label>
                                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" id="judul" placeholder="Judul Rapat" value="{{ old('judul', $jadwal->judul) }}" required>
                                            @error('judul')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="tempat">Tempat</label>
                                            <input type="text" name="tempat" class="form-control @error('tempat') is-invalid @enderror" id="tempat" placeholder="Tempat" value="{{ old('tempat', $jadwal->tempat) }}" required>
                                            @error('tempat')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="hari">Hari</label>
                                            <input type="text" name="hari" class="form-control @error('hari') is-invalid @enderror" id="hari" placeholder="Hari" value="{{ old('hari', $jadwal->hari) }}" required>
                                            @error('hari')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="pukul">Pukul</label>
                                            <input type="text" name="pukul" class="form-control @error('pukul') is-invalid @enderror" id="pukul" placeholder="Pukul" value="{{ old('pukul', $jadwal->pukul) }}" required>
                                            @error('pukul')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" value="{{ old('tanggal', $jadwal->tanggal) }}" required>
                                            @error('tanggal')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-dark mr-1" type="reset"><i class="fa-solid fa-arrows-rotate"></i> Reset</button>
                                <button class="btn btn-success" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.content -->
            </div>
        </div>
    </div>
</div>

@endsection
