@extends('template.main')
@section('title', 'Uraian Editor')
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
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addUraianModal"><i class="fa-solid fa-plus"></i> Add Uraian</button>
                            </div>
                        </div>
                        <div class="card-body">
                                <div class="table-scroll">
                                <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Uraian</th>
                                            <th>Kegiatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($uraian as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name_uraian }}</td>
                                            <td>{{ $item->kegiatan->name_kegiatan }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#editUraianModal{{ $item->uraian_id }}">
                                                    <i class="fa-solid fa-pen"></i> Edit
                                                </button>
                                                <form action="{{ route('uraian.destroy', $item->uraian_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit Uraian -->
                                        <div class="modal fade" id="editUraianModal{{ $item->uraian_id }}" tabindex="-1" role="dialog" aria-labelledby="editUraianModalLabel{{ $item->uraian_id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editUraianModalLabel{{ $item->uraian_id }}">Edit Uraian</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('uraian.update', $item->uraian_id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="name_uraian">Nama Uraian</label>
                                                                <input type="text" name="name_uraian" class="form-control" value="{{ old('name_uraian', $item->name_uraian) }}" required>
                                                            </div>  
                                                            <div class="form-group">
                                                                <label for="kegiatan_id">Kegiatan</label>
                                                                <select name="kegiatan_id" class="form-control" required>
                                                                    @foreach ($kegiatan as $bdg)
                                                                    <option value="{{ $bdg->kegiatan_id }}" {{ $item->kegiatan_id == $bdg->kegiatan_id ? 'selected' : '' }}>{{ $bdg->name_kegiatan }}</option>
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
                    </div>

                    <!-- Modal Add Uraian -->
                    <div class="modal fade" id="addUraianModal" tabindex="-1" role="dialog" aria-labelledby="addUraianModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addUraianModalLabel">Add Uraian</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="addUraianForm" action="{{ route('uraian.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name_uraian">Nama Uraian</label>
                                            <input type="text" name="name_uraian" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="kegiatan_id">Kegiatan</label>
                                            <select name="kegiatan_id" class="form-control" required>
                                                <option value="">Select Kegiatan</option>
                                                @foreach ($kegiatan as $bdg)
                                                <option value="{{ $bdg->kegiatan_id }}">{{ $bdg->name_kegiatan }}</option>
                                                @endforeach
                                            </select>
                                        </div>                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add Uraian</button>
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

@section('styles')
<style>
.table-scroll {
    overflow-x: auto;
}
</style>
@endsection

@section('scripts')
<script>
    $('#addUraianModal').on('hidden.bs.modal', function () {
        $('#addUraianForm')[0].reset();
    });
</script>
@endsection