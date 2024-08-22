@extends('template.main')
@section('title', 'Penanggung Jawab')
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
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addPenanggungJawabModal"><i class="fa-solid fa-plus"></i> Add Penanggung Jawab</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Penanggung Jawab</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penanggungJawabs as $penanggungJawab)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $penanggungJawab->name_penanggung_jawab }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#editPenanggungJawabModal{{ $penanggungJawab->id_penanggung_jawab }}">
                                                <i class="fa-solid fa-pen"></i> Edit
                                            </button>
                                            <form action="{{ route('penanggung-jawab.destroy', $penanggungJawab->id_penanggung_jawab) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Penanggung Jawab -->
                                    <div class="modal fade" id="editPenanggungJawabModal{{ $penanggungJawab->id_penanggung_jawab }}" tabindex="-1" role="dialog" aria-labelledby="editPenanggungJawabModalLabel{{ $penanggungJawab->id_penanggung_jawab }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editPenanggungJawabModalLabel{{ $penanggungJawab->id_penanggung_jawab }}">Edit Penanggung Jawab</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('penanggung-jawab.update', $penanggungJawab->id_penanggung_jawab) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name_penanggung_jawab">Nama Penanggung Jawab</label>
                                                            <input type="text" name="name_penanggung_jawab" class="form-control" value="{{ old('name_penanggung_jawab', $penanggungJawab->name_penanggung_jawab) }}" required>
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

                    <!-- Modal Add Penanggung Jawab -->
                    <div class="modal fade" id="addPenanggungJawabModal" tabindex="-1" role="dialog" aria-labelledby="addPenanggungJawabModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addPenanggungJawabModalLabel">Add Penanggung Jawab</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="addPenanggungJawabForm" action="{{ route('penanggung-jawab.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name_penanggung_jawab">Nama Penanggung Jawab</label>
                                            <input type="text" name="name_penanggung_jawab" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add Penanggung Jawab</button>
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
    $('#addPenanggungJawabModal').on('hidden.bs.modal', function () {
        $('#addPenanggungJawabForm')[0].reset();
    });
</script>
@endsection
