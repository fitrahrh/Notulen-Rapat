@extends('template.main')
@section('title', 'Add Jadwal Rapat')
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
            <form class="needs-validation" novalidate action="{{ route('jadwal-rapat.store') }}" method="POST">
              @csrf
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name_rapat">Judul</label>
                      <input type="text" name="name_jadwal" class="form-control @error('name_jadwal') is-invalid @enderror" id="name_jadwal" placeholder="Judul Rapat" value="{{ old('name_jadwal') }}" required>
                      @error('name_jadwal')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="tanggal_jadwal">Tanggal dan Waktu</label>
                      <input type="datetime-local" name="tanggal_jadwal" class="form-control @error('tanggal_jadwal') is-invalid @enderror" id="tanggal_jadwal" placeholder="Pilih tanggal dan waktu" value="{{ old('tanggal_jadwal') }}" required>
                      @error('tanggal_jadwal')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="kegiatan_id">Jenis Kegiatan</label>
                    <select name="kegiatan_id" class="form-control @error('kegiatan_id') is-invalid @enderror" required>
                      <option value="all">Semua Jenis Kegiatan</option>
                      @foreach($kegiatans as $kegiatan)
                        <option value="{{ $kegiatan->kegiatan_id }}">{{ $kegiatan->name_kegiatan }}</option>
                      @endforeach
                    </select>
                    @error('kegiatan_id')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="divisi_bagian_id">Divisi Bagian</label>
                    <select name="divisi_bagian_id" class="form-control @error('divisi_bagian_id') is-invalid @enderror" required>
                      <option value="all">Semua Divisi Bagian</option>
                      @foreach($divisiBagians as $divisiBagian)
                        <option value="{{ $divisiBagian->divisi_bagian_id }}">{{ $divisiBagian->name_divisi_bagian }}</option>
                      @endforeach
                    </select>
                    @error('divisi_bagian_id')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="MBIS">MBIS</label>
                      <input type="text" name="MBIS" class="form-control @error('MBIS') is-invalid @enderror" id="MBIS" placeholder="MBIS" value="{{ old('MBIS') }}" required>
                      @error('MBIS')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="Rolan">Rolan</label>
                      <input type="text" name="Rolan" class="form-control @error('Rolan') is-invalid @enderror" id="Rolan" placeholder="Rolan" value="{{ old('Rolan') }}" required>
                      @error('Rolan')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="Verifikasi">Verifikasi</label>
                      <input type="text" name="Verifikasi" class="form-control @error('Verifikasi') is-invalid @enderror" id="Verifikasi" placeholder="Verifikasi" value="{{ old('Verifikasi') }}" required>
                      @error('Verifikasi')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="keterangan">keterangan</label>
                      <input type="text" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" placeholder="keterangan" value="{{ old('keterangan') }}" required>
                      @error('keterangan')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-dark mr-1" type="reset">
                  <i class="fa-solid fa-arrows-rotate"></i> Reset
                </button>
                <button class="btn btn-success" type="submit">
                  <i class="fa-solid fa-floppy-disk"></i> Save
                </button>
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