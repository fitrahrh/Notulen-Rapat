@extends('template.main')
@section('title', 'Jadwal Rapat Editor')
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
                            <a href="{{ route('notulen.index') }}" class="btn btn-warning"><i class="fa-solid fa-file"></i> History Notulen</a>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addJadwalModal"><i class="fa-solid fa-plus"></i> Add Jadwal</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Rapat</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Tempat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jadwal as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name_rapat }}</td>
                                        <td>{{ $item->tanggal }}</td>
                                        <td>{{ $item->jam_mulai . ' - ' .$item->jam_selesai }}</td>
                                        <td>{{ $item->tempat_rapat }}</td>
                                        <td>
                                            <button class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#addNotulenModal{{ $item->jadwal_id }}"><i class="fa-solid fa-file"></i> Add Notulen</button>
                                            <button class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#editJadwalModal{{ $item->jadwal_id }}">
                                                <i class="fa-solid fa-pen"></i> Edit
                                            </button>
                                            <form action="{{ route('jadwal-rapat.destroy', $item->jadwal_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal Add Notulen -->
                                    <div class="modal fade" id="addNotulenModal{{ $item->jadwal_id }}" tabindex="-1" role="dialog" aria-labelledby="addNotulenModalLabel{{ $item->jadwal_id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addNotulenModalLabel{{ $item->jadwal_id }}">Add Notulen</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="addNotulenForm{{ $item->jadwal_id }}" action="{{ route('notulen.store') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="hidden" name="jadwal_id" value="{{ $item->jadwal_id }}">
                                                        <div class="form-group">
                                                            <label for="text">Text</label>
                                                            <textarea id="editor{{ $item->jadwal_id }}" name="text" style="display:none"></textarea>
                                                            <textarea name="text" id="hiddenInput{{ $item->jadwal_id }}" style="display:none"></textarea>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-4">
                                                                <label for="jenis_surat">Jenis Surat</label>
                                                                <input type="text" name="jenis_surat" class="form-control" required>
                                                            </div>
                                                            <div class="form-group col-4">
                                                                <label for="nomor_surat">Nomor Surat</label>
                                                                <input type="text" name="nomor_surat" class="form-control" required>
                                                            </div>
                                                            <div class="form-group col-4">
                                                                <label for="pic_id">PIC</label>
                                                                <select name="pic_id" class="form-control" required>
                                                                    @foreach($pegawai as $peg)
                                                                        <option value="{{ $peg->pegawai_id }}">{{ $peg->nama_pegawai }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-4">
                                                                <label for="penanggung_jawab_id">Penanggung Jawab</label>
                                                                <select name="penanggung_jawab_id" class="form-control" required>
                                                                    @foreach($pegawai as $peg)
                                                                        <option value="{{ $peg->pegawai_id }}">{{ $peg->nama_pegawai }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-4">
                                                                <label for="pencatat_id">Pencatat</label>
                                                                <select name="pencatat_id" class="form-control" required>
                                                                    @foreach($pegawai as $peg)
                                                                        <option value="{{ $peg->pegawai_id }}">{{ $peg->nama_pegawai }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-4">
                                                                <label for="surat_undangan">Surat Undangan (PDF)</label>
                                                                <input type="file" name="surat_undangan" class="form-control" accept=".pdf" required>
                                                            </div>
                                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-4">
                                                <label for="berkas_absen">Berkas Absen (PDF)</label>
                                                <input type="file" name="berkas_absen" class="form-control" accept=".pdf" required>
                                            </div>
                                            <div class="form-group col-4">
                                                <label for="berkas_spt">Berkas SPT (PDF)</label>
                                                <input type="file" name="berkas_spt" class="form-control" accept=".pdf" required>
                                            </div>
                                            <div class="form-group col-4">
                                                <label for="berkas_dokumentasi">Berkas Dokumentasi (Photo)</label>
                                                <input type="file" name="berkas_dokumentasi" class="form-control" accept="image/*" required>
                                            </div>
                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save Notulen</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Edit Jadwal -->
                                    <div class="modal fade" id="editJadwalModal{{ $item->jadwal_id }}" tabindex="-1" role="dialog" aria-labelledby="editJadwalModalLabel{{ $item->jadwal_id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editJadwalModalLabel{{ $item->jadwal_id }}">Edit Jadwal</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('jadwal-rapat.update', $item->jadwal_id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name_rapat">Nama Rapat</label>
                                                            <input type="text" name="name_rapat" class="form-control" value="{{ $item->name_rapat }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="jenis_rapat_id">Jenis Rapat</label>
                                                            <select name="jenis_rapat_id" class="form-control" required>
                                                                @foreach ($jenis as $jr)
                                                                <option value="{{ $jr->jenis_rapat_id }}" {{ $item->jenis_rapat_id == $jr->jenis_rapat_id ? 'selected' : '' }}>{{ $jr->jenis_rapat }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tanggal">Tanggal</label>
                                                            <input type="date" name="tanggal" class="form-control" value="{{ $item->tanggal }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="jam_mulai">Jam Mulai</label>
                                                            <input type="time" name="jam_mulai" class="form-control" value="{{ $item->jam_mulai }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="jam_selesai">Jam Selesai</label>
                                                            <input type="time" name="jam_selesai" class="form-control" value="{{ $item->jam_selesai }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tempat_rapat">Tempat Rapat</label>
                                                            <input type="text" name="tempat_rapat" class="form-control" value="{{ $item->tempat_rapat }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="keterangan">Keterangan</label>
                                                            <textarea name="keterangan" class="form-control">{{ $item->keterangan }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="uraian_id">Uraian</label>
                                                            <select name="uraian_id" class="form-control" required>
                                                                @foreach ($uraian as $ur)
                                                                <option value="{{ $ur->uraian_id }}" {{ $item->uraian_id == $ur->uraian_id ? 'selected' : '' }}>{{ $ur->name_uraian }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <!-- Modal Add Jadwal -->
                    <div class="modal fade" id="addJadwalModal" tabindex="-1" role="dialog" aria-labelledby="addJadwalModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addJadwalModalLabel">Add Jadwal</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('jadwal-rapat.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name_rapat">Nama Rapat</label>
                                            <input type="text" name="name_rapat" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_rapat_id">Jenis Rapat</label>
                                            <select name="jenis_rapat_id" class="form-control" required>
                                                @foreach ($jenis as $jr)
                                                <option value="{{ $jr->jenis_rapat_id }}">{{ $jr->jenis_rapat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input type="date" name="tanggal" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="peserta">Peserta Rapat</label><br>
                                            <select id="peserta" name="peserta[]" class="form-control" multiple="multiple" required>
                                                @foreach ($pegawai as $peg)
                                                <option value="{{ $peg->pegawai_id }}">{{ $peg->email }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="jam_mulai">Jam Mulai</label>
                                            <input type="time" name="jam_mulai" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jam_selesai">Jam Selesai</label>
                                            <input type="time" name="jam_selesai" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="tempat_rapat">Tempat Rapat</label>
                                            <input type="text" name="tempat_rapat" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan</label>
                                            <textarea name="keterangan" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="uraian_id">Uraian</label>
                                            <select name="uraian_id" class="form-control" required>
                                                @foreach ($uraian as $ur)
                                                <option value="{{ $ur->uraian_id }}">{{ $ur->name_uraian }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#peserta').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        allowClear: true,
        placeholder: "Cari nama peserta",
    });
});
</script>
@endpush

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/css/suneditor.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/suneditor.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/suneditor@latest/src/lang/ko.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
@foreach ($jadwal as $item)
const editor{{ $item->jadwal_id }} = SUNEDITOR.create((document.querySelector('#editor{{ $item->jadwal_id }}') || '#editor{{ $item->jadwal_id }}'), {
    lang: SUNEDITOR_LANG['en'],
    buttonList: [
        ['undo', 'redo'],
        ['font', 'fontSize', 'formatBlock'],
        ['paragraphStyle', 'blockquote'],
        ['bold', 'underline', 'italic', 'strike', 'subscript', 'superscript'],
        ['fontColor', 'hiliteColor', 'textStyle'],
        ['removeFormat'],
        ['outdent', 'indent'],
        ['align', 'horizontalRule', 'list', 'lineHeight'],
        ['table', 'link', 'image', 'video', 'audio'],
        ['fullScreen', 'showBlocks', 'codeView'],
        ['preview', 'print'],
        ['save', 'template']
    ]
});

document.getElementById('addNotulenForm{{ $item->jadwal_id }}').addEventListener('submit', function() {
    document.getElementById('hiddenInput{{ $item->jadwal_id }}').value = editor{{ $item->jadwal_id }}.getContents();
});
@endforeach
</script>
@endpush

