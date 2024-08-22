@extends('template.main')
@section('title', 'bidang Editor')
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
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addbidangModal"><i class="fa-solid fa-plus"></i> Add bidang</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bidang as $bidang)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $bidang->name_bidang }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#editbidangModal{{ $bidang->bidang_id }}">
                                                <i class="fa-solid fa-pen"></i> Edit
                                            </button>
                                            <form action="{{ route('bidang.destroy', $bidang->bidang_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit bidang -->
                                    <div class="modal fade" id="editbidangModal{{ $bidang->bidang_id }}" tabindex="-1" role="dialog" aria-labelledby="editbidangModalLabel{{ $bidang->bidang_id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editbidangModalLabel{{ $bidang->bidang_id }}">Edit bidang</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('bidang.update', $bidang->bidang_id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name_bidang">Name</label>
                                                            <input type="text" name="name_bidang" class="form-control" value="{{ old('name_bidang', $bidang->name_bidang) }}" required>
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

                    <!-- Modal Add bidang -->
                    <div class="modal fade" id="addbidangModal" tabindex="-1" role="dialog" aria-labelledby="addbidangModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addbidangModalLabel">Add bidang</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="addbidangForm" action="{{ route('bidang.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name_bidang">Name</label>
                                            <input type="text" name="name_bidang" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add bidang</button>
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
    $('#addbidangModal').on('hidden.bs.modal', function () {
        $('#addbidangForm')[0].reset();
    });
</script>
@endsection