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
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addJadwalModal"><i class="fa-solid fa-plus"></i> Add Jadwal</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Rapat</th>
                                        <th>DPA</th>
                                        <th>Jenis Rapat</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Tempat</th>
                                        <th>kegiatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jadwal as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name_rapat }}</td>
                                        <td>{{ $item->dpa->name_dpa }}</td>
                                        <td>{{ $item->jenis_rapat->jenis_rapat }}</td>
                                        <td>{{ $item->tanggal }}</td>
                                        <td>{{ $item->jam_mulai . ' - ' .$item->jam_selesai }}</td>
                                        <td>{{ $item->tempat_rapat }}</td>
                                        <td>{{ $item->kegiatan->name_kegiatan }}</td>
                                        <td>
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
                                                            <input type="text" name="name_rapat" class="form-control" value="{{ old('name_rapat', $item->name_rapat) }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="jenis_rapat_id">Jenis Rapat</label>
                                                            <select name="jenis_rapat_id" class="form-control" required>
                                                                @foreach ($jenis as $jr)
                                                                <option value="{{ $jr->jenis_rapat_id }}" {{ $item->jenis_rapat_id == $jr->jenis_rapat_id  ? 'selected' : ''}}>{{$jr->jenis_rapat}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tanggal">Tanggal</label>
                                                            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $item->tanggal) }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="jam_mulai">Jam Mulai</label>
                                                            <input type="time" name="jam_mulai" class="form-control" value="{{ old('jam_mulai', \Carbon\Carbon::parse($item->jam_mulai)->format('H:i')) }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="jam_selesai">Jam Selesai</label>
                                                            <input type="time" name="jam_selesai" class="form-control" value="{{ old('jam_selesai', \Carbon\Carbon::parse($item->jam_selesai)->format('H:i')) }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tempat_rapat">Tempat</label>
                                                            <input type="text" name="tempat_rapat" class="form-control" value="{{ old('tempat_rapat', $item->tempat_rapat) }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="keterangan">Keterangan</label>
                                                            <textarea name="keterangan" class="form-control" required>{{ old('keterangan', $item->keterangan) }}</textarea>
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
                                            <label for="jam_mulai">Jam Mulai</label>
                                            <input type="time" name="jam_mulai" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jam_selesai">Jam Selesai</label>
                                            <input type="time" name="jam_selesai" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="tempat_rapat">Tempat</label>
                                            <input type="text" name="tempat_rapat" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan</label>
                                            <textarea name="keterangan" class="form-control" required></textarea>
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