@extends('template.main')
@section('title', 'Kegiatan Editor')
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
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addKegiatanModal"><i class="fa-solid fa-plus"></i> Add Kegiatan</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Kegiatan</th>
                                        <th>DPA</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kegiatans as $kegiatan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $kegiatan->name_kegiatan }}</td>
                                        <td>{{ $kegiatan->dpa->name_dpa }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#editKegiatanModal{{ $kegiatan->kegiatan_id }}">
                                                <i class="fa-solid fa-pen"></i> Edit
                                            </button>
                                            <form action="{{ route('kegiatan.destroy', $kegiatan->kegiatan_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Kegiatan -->
                                    <div class="modal fade" id="editKegiatanModal{{ $kegiatan->kegiatan_id }}" tabindex="-1" role="dialog" aria-labelledby="editKegiatanModalLabel{{ $kegiatan->kegiatan_id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editKegiatanModalLabel{{ $kegiatan->kegiatan_id }}">Edit Kegiatan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('kegiatan.update', $kegiatan->kegiatan_id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name_kegiatan">Nama Kegiatan</label>
                                                            <input type="text" name="name_kegiatan" class="form-control" value="{{ old('name_kegiatan', $kegiatan->name_kegiatan) }}" required>
                                                        </div>  
                                                        <div class="form-group">
                                                            <label for="dpa_id">dpa</label>
                                                            <select name="dpa_id" class="form-control" required>
                                                                @foreach ($dpa as $bdg)
                                                                <option value="{{ $bdg->dpa_id }}" {{ $kegiatan->dpa_id == $bdg->dpa_id ? 'selected' : '' }}>{{ $bdg->name_dpa }}</option>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Modal Add Kegiatan -->
                    <div class="modal fade" id="addKegiatanModal" tabindex="-1" role="dialog" aria-labelledby="addKegiatanModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addKegiatanModalLabel">Add Kegiatan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="addKegiatanForm" action="{{ route('kegiatan.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name_kegiatan">Nama Kegiatan</label>
                                            <input type="text" name="name_kegiatan" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="bidang_id">dpa</label>
                                            <select name="dpa_id" class="form-control" required>
                                                <option value="">Select dpa</option>
                                                @foreach ($dpa as $bdg)
                                                <option value="{{ $bdg->dpa_id }}">{{ $bdg->name_dpa }}</option>
                                                @endforeach
                                            </select>
                                        </div>                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add Kegiatan</button>
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

@section('scripts')
<script>
    $('#addKegiatanModal').on('hidden.bs.modal', function () {
        $('#addKegiatanForm')[0].reset();
    });
</script>
@endsection