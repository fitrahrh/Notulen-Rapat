@extends('template.main')
@section('title', 'Add Notulen Report')
@section('content')

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
            <li class="breadcrumb-item"><a href="/reports">Reports</a></li>
            <li class="breadcrumb-item active">@yield('title')</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="text-right">
                <a href="{{ route('reports.index') }}" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i> Back</a>
              </div>
            </div>
            <form class="needs-validation" novalidate action="{{ route('reports.store') }}" method="POST">
            @csrf
              <div class="card-body">
                <div class="form-group col-md-5">
                  <label for="judul">Judul Rapat</label>
                  <input type="text" name="judul" id="judul" class="form-control" required>
                </div>
                <div class="form-group col-md-2">
                  <label for="tanggal">Hari/Tanggal</label>
                  <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                </div>
                <div class="form-group col-md-2">
                  <label for="waktu">Waktu Sidang/Rapat</label>
                  <input type="time" name="waktu" id="waktu" class="form-control" required>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-2">
                    <label for="tempat">Tempat</label>
                    <input type="text" name="tempat" id="tempat" class="form-control" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="pimpinan">Pimpinan Rapat Ketua</label>
                    <input type="text" name="pimpinan" id="pimpinan" class="form-control" required>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="bagian">Bagian</label>
                    <select name="bagian" id="bagian" class="form-control" required>
                      <option value="">Pilih Bagian</option>
                      <option value="Aplikasi">Aplikasi</option>
                      <option value="Integrasi">Integrasi</option>
                      <option value="Tata Kelola">Tata Kelola</option>
                      <option value="Rutin">Rutin</option>
                      <option value="Rutin (Diluar Surat Keluar)">Rutin (Diluar Surat Keluar)</option>
                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="kegiatan">Kegiatan</label>
                    <select name="kegiatan" id="kegiatan" class="form-control" required>
                      <!-- Options will be populated dynamically using JavaScript -->
                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="pencatat">Pencatat</label>
                    <input type="text" name="pencatat" id="pencatat" class="form-control" required>
                  </div>
                </div>

                <div class="form-row mt-4">
                  <div class="form-group col-md-2">
                    <label for="notulis">Notulis:</label>
                    <input type="text" name="notulis" class="form-control @error('notulis') is-invalid @enderror" id="notulis" placeholder="Notulis" value="{{ old('notulis') }}" required>
                    @error('notulis')
                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <div class="form-row mt-4">
                  <div class="form-group col-md-12">
                    <label for="notulensi">Notulensi:</label>
                    <div id="toolbar-container">
                      <span class="ql-formats">
                        <select class="ql-font"></select>
                        <select class="ql-size"></select>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-bold"></button>
                        <button class="ql-italic"></button>
                        <button class="ql-underline"></button>
                        <button class="ql-strike"></button>
                      </span>
                      <span class="ql-formats">
                        <select class="ql-color"></select>
                        <select class="ql-background"></select>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-script" value="sub"></button>
                        <button class="ql-script" value="super"></button>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-header" value="1"></button>
                        <button class="ql-header" value="2"></button>
                        <button class="ql-blockquote"></button>
                        <button class="ql-code-block"></button>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-list" value="ordered"></button>
                        <button class="ql-list" value="bullet"></button>
                        <button class="ql-indent" value="-1"></button>
                        <button class="ql-indent" value="+1"></button>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-direction" value="rtl"></button>
                        <select class="ql-align"></select>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-link"></button>
                        <button class="ql-image"></button>
                        <button class="ql-video"></button>
                        <button class="ql-formula"></button>
                      </span>
                      <span class="ql-formats">
                        <button class="ql-clean"></button>
                      </span>
                    </div>
                    <div id="editor">
                    </div>
                    <input type="hidden" id="notulensi" name="notulensi">
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
      </div>
    </div>
  </div>
</div>
<style>
  #editor {
    height: 200px;
  }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const bagianSelect = document.getElementById('bagian');
    const kegiatanSelect = document.getElementById('kegiatan');

    const kegiatanOptions = {
        'Aplikasi': [
            'Pembuatan/Pengembangan Aplikasi',
            'Forum Group Discussion Terkait Aplikasi',
            'Sosialisasi/Survey Digital Talent',
            'Monitoring dan Evaluasi Terkait Aplikasi'
        ],
        'Integrasi': [
            'Implementasi Integrasi',
            'FGD Sinergi Transformasi Digital Triwulan I',
            'FGD Sinergi Transformasi Digital Triwulan IV',
            'Sosialisasi Satu Data'
        ],
        'Tata Kelola': [
            'Sosialisasi Penerapan SOP',
            'Penyusunan Kebijakan Arsitektur SPBE',
            'Penyusunan Kebijakan Peta Rencaan SPBE',
            'Penyusunan Kebijakan Standarisasi Data',
            'Operasional WANTIKDA',
            'RAPAT WANTIKDA',
            'Audit Aplikasi'
        ],
        'Rutin': [
            'Tata Kelola',
            'Rapat Bidang',
            'Aplikasi',
            'Integrasi'
        ],
        'Rutin (Diluar Surat Keluar)': [
            'Rutin',
            'Koordinasi'
        ]
    };

    bagianSelect.addEventListener('change', function () {
        const selectedBagian = bagianSelect.value;
        kegiatanSelect.innerHTML = '';

        if (kegiatanOptions[selectedBagian]) {
            kegiatanOptions[selectedBagian].forEach(function (kegiatan) {
                const option = document.createElement('option');
                option.value = kegiatan;
                option.textContent = kegiatan;
                kegiatanSelect.appendChild(option);
            });
        }
    });

    // Initialize Quill editor
    const quill = new Quill('#editor', {
        modules: {
          syntax: true,
          toolbar: '#toolbar-container',
        },
        placeholder: 'Compose an epic...',
        theme: 'snow',
    });

    // Populate hidden input field with Quill editor content
    const notulensiInput = document.getElementById('notulensi');
    quill.on('text-change', function() {
        notulensiInput.value = quill.root.innerHTML;
    });
});
</script>

@endsection
