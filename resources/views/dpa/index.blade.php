@extends('template.main')
@section('title', 'DPA Editor')
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
                                <button class="btn btn-primary" data-toggle="modal" data-target="#adddpaModal"><i class="fa-solid fa-plus"></i> Add DPA</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>DPA</th>
                                        <th>Bidang</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dpa as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name_dpa }}</td>
                                        <td>{{ $item->bidang->name_bidang }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#editdpaModal{{ $item->dpa_id }}">
                                                <i class="fa-solid fa-pen"></i> Edit
                                            </button>
                                            <form action="{{ route('dpa.destroy', $item->dpa_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Divisi Bagian -->
                                    <div class="modal fade" id="editdpaModal{{ $item->dpa_id }}" tabindex="-1" role="dialog" aria-labelledby="editdpaModalLabel{{ $item->dpa_id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editdpaModalLabel{{ $item->dpa_id }}">Edit DPA</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('dpa.update', $item->dpa_id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name_dpa">Name</label>
                                                            <input type="text" name="name_dpa" class="form-control" value="{{ old('name_dpa', $item->name_dpa) }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="bidang_id">Bidang</label>
                                                            <select name="bidang_id" class="form-control" required>
                                                                @foreach ($bidang as $bdg)
                                                                <option value="{{ $bdg->bidang_id }}" {{ $item->bidang_id == $bdg->bidang_id ? 'selected' : '' }}>{{ $bdg->name_bidang }}</option>
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

                    <!-- Modal Add Bidang Bagian -->
                    <div class="modal fade" id="adddpaModal" tabindex="-1" role="dialog" aria-labelledby="adddpaModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="adddpaModalLabel">Add DPA</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="adddpaForm" action="{{ route('dpa.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name_dpa">Name</label>
                                            <input type="text" name="name_dpa" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="bidang_id">Bidang</label>
                                            <select name="bidang_id" class="form-control" required>
                                                <option value="">Select Bidang</option>
                                                @foreach ($bidang as $bdg)
                                                <option value="{{ $bdg->bidang_id }}">{{ $bdg->name_bidang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add DPA</button>
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
    $('#adddpaModal').on('hidden.bs.modal', function () {
        $('#adddpaForm')[0].reset();
    });
</script>
@endsection