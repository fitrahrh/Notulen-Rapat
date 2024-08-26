@extends('template.main')
@section('title', 'Notulen')
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
                                <a href="jadwal-rapat" class="btn btn-warning btn-sm">
                                <i class="fa-solid fa-arrow-rotate-left"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Jadwal</th>
                                        <th>Jenis Surat</th>
                                        <th>Nomor Surat</th>
                                        <th>PIC</th>
                                        <th>Penanggung Jawab</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notulen as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->jadwal->tanggal)->isoFormat('dddd, D MMMM Y') }}</td>
                                        <td>{{ $data->jenis_surat }}</td>
                                        <td>{{ $data->nomor_surat }}</td>
                                        <td>{{ $data->pic->nama_pegawai }}</td>
                                        <td>{{ $data->penanggung_jawab->nama_pegawai }}</td>
                                        <td>
                                            <form action="{{ route('notulen.destroy', $data->notulen_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Delete</button>
                                            </form>
                                            <button class="btn btn-info btn-sm" onclick="previewPDF('{{ route('notulen.generatePDF', $data->notulen_id) }}')"><i class="fa-solid fa-eye"></i> Preview PDF</button>
                                            <button class="btn btn-warning btn-sm" onclick="editNotulen({{ $data->notulen_id }})"><i class="fa-solid fa-edit"></i> Edit</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Modal Add Notulen -->
                    <div class="modal fade" id="addNotulenModal" tabindex="-1" role="dialog" aria-labelledby="addNotulenModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addNotulenModalLabel">Add Notulen</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="addNotulenForm" action="{{ route('notulen.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="text">Text</label>
                                            <div id="editor" style="height: 200px;">{!! old('text') !!}</div>
                                            <textarea name="text" id="hiddenInput" style="display:none"></textarea>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="jadwal_id">Jadwal</label>
                                                    <select name="jadwal_id" class="form-control" required>
                                                        <option value="">Select Jadwal</option>
                                                        @foreach ($jadwal as $schedule)
                                                        <option value="{{ $schedule->jadwal_id }}">{{ $schedule->name_rapat }} [{{ $schedule->tanggal }}] [{{ $schedule->jam_mulai }} s.d {{ $schedule->jam_selesai }}]</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="jenis_surat">Jenis Surat</label>
                                                <input type="text" name="jenis_surat" class="form-control" value="{{ old('jenis_surat') }}" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="nomor_surat">Nomor Surat</label>
                                                <input type="text" name="nomor_surat" class="form-control" value="{{ old('nomor_surat') }}" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                            <label for="pic_id">PIC</label>
                                            <select name="pic_id" class="form-control" style="width: 100%;" required>
                                                    <option value="">Select PIC</option>
                                                    @foreach ($pegawai as $person)
                                                    <option value="{{ $person->pegawai_id }}">{{ $person->nama_pegawai }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="penanggung_jawab_id">Penanggung Jawab</label>
                                                <select name="penanggung_jawab_id" class="form-control" required>
                                                    <option value="">Select Penanggung Jawab</option>
                                                    @foreach ($pegawai as $person)
                                                    <option value="{{ $person->pegawai_id }}">{{ $person->nama_pegawai }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="pencatat_id">Pencatat</label>
                                                <select name="pencatat_id" class="form-control" required>
                                                    <option value="">Select Pencatat</option>
                                                    @foreach ($pegawai as $person)
                                                    <option value="{{ $person->pegawai_id }}">{{ $person->nama_pegawai }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-6">
                                                <label for="surat_undangan">Surat Undangan (PDF)</label>
                                                <input type="file" name="surat_undangan" class="form-control" accept=".pdf" required>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="berkas_absen">Berkas Absen (PDF)</label>
                                                <input type="file" name="berkas_absen" class="form-control" accept=".pdf" required>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="berkas_spt">Berkas SPT (PDF)</label>
                                                <input type="file" name="berkas_spt" class="form-control" accept=".pdf" required>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="berkas_dokumentasi">Berkas Dokumentasi (Photo)</label>
                                                <input type="file" name="berkas_dokumentasi" class="form-control" accept="image/*" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add Notulen</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit Notulen -->
                    <div class="modal fade" id="editNotulenModal" tabindex="-1" role="dialog" aria-labelledby="editNotulenModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editNotulenModalLabel">Edit Notulen</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="editNotulenForm" action="" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="form-group">
            <label for="editText">Text</label>
            <textarea id="editText" style="display:none"></textarea>
            <textarea name="text" id="editHiddenInput" style="display:none"></textarea>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="editJenisSurat">Jenis Surat</label>
                <input type="text" name="jenis_surat" id="editJenisSurat" class="form-control" required>
            </div>
            <div class="form-group col-md-4">
                <label for="editNomorSurat">Nomor Surat</label>
                <input type="text" name="nomor_surat" id="editNomorSurat" class="form-control" required>
            </div>
            <div class="form-group col-md-4">
                <label for="editJadwalId">Jadwal</label>
                <select name="jadwal_id" id="editJadwalId" class="form-control" required>
                    @foreach($jadwal as $item)
                        <option value="{{ $item->jadwal_id }}">{{ $item->name_rapat }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="editPicId">PIC</label>
                <select name="pic_id" id="editPicId" class="form-control" required>
                    @foreach($pegawai as $item)
                        <option value="{{ $item->pegawai_id }}">{{ $item->nama_pegawai }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="editPenanggungJawabId">Penanggung Jawab</label>
                <select name="penanggung_jawab_id" id="editPenanggungJawabId" class="form-control" required>
                    @foreach($pegawai as $item)
                        <option value="{{ $item->pegawai_id }}">{{ $item->nama_pegawai }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="editPencatatId">Pencatat</label>
                <select name="pencatat_id" id="editPencatatId" class="form-control" required>
                    @foreach($pegawai as $item)
                        <option value="{{ $item->pegawai_id }}">{{ $item->nama_pegawai }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update Notulen</button>
    </div>
</form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for PDF Preview -->
                    <div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog" aria-labelledby="pdfPreviewModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pdfPreviewModalLabel">PDF Preview</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <iframe id="pdf-preview-frame" src="" style="width: 100%; height: 500px;" frameborder="0"></iframe>
                                </div>
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
<link href="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/css/suneditor.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/suneditor.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/suneditor@latest/src/lang/ko.js"></script>
<script>
const editor = SUNEDITOR.create((document.querySelector('#editor') || '#editor'), {
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

document.getElementById('addNotulenForm').addEventListener('submit', function() {
    document.getElementById('hiddenInput').value = editor.getContents();
});

// Initialize SunEditor for Edit Notulen
const editEditor = SUNEDITOR.create((document.querySelector('#editText') || '#editText'), {
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
        ['preview', 'print']
    ]
});

// Function to handle the edit button click
function editNotulen(id) {
    $.get('/notulen/' + id, function(data) {
        $('#editNotulenForm').attr('action', '/notulen/' + id);
        editEditor.setContents(data.text); // Populate SunEditor with existing data
        $('#editJenisSurat').val(data.jenis_surat);
        $('#editNomorSurat').val(data.nomor_surat);
        $('#editJadwalId').val(data.jadwal_id);
        $('#editPicId').val(data.pic_id);
        $('#editPenanggungJawabId').val(data.penanggung_jawab_id);
        $('#editPencatatId').val(data.pencatat_id);
        $('#editNotulenModal').modal('show');
    });
}

// Ensure the hidden input is updated before form submission
document.getElementById('editNotulenForm').addEventListener('submit', function() {
    document.getElementById('editHiddenInput').value = editEditor.getContents();
});

</script>
@endpush

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.5.136/pdf_viewer.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.5.136/pdf.min.mjs"></script>

<script src="{{ asset('assets/js/pdf.mjs') }}"></script>
<script src="{{ asset('assets/js/pdf.worker.mjs') }}"></script>
<script>
function previewPDF(url) {
    $('#pdfPreviewModal').modal('show');
    const canvas = document.getElementById('pdf-canvas');
    const ctx = canvas.getContext('2d');

    pdfjsLib.GlobalWorkerOptions.workerSrc = '{{ asset('js/pdf.worker.js') }}';

    pdfjsLib.getDocument(url).promise.then(function(pdfDoc) {
        pdfDoc.getPage(1).then(function(page) {
            const viewport = page.getViewport({scale: 1.5});
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            page.render(renderContext);
        });
    });
}
</script>
<script>
function previewPDF(url) {
    $('#pdf-preview-frame').attr('src', url);
    $('#pdfPreviewModal').modal('show');
}
</script>
@endpush
