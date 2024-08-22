@extends('template.main')
@section('title', 'Pegawai')
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
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addPegawaiModal"><i class="fa-solid fa-plus"></i> Add Pegawai</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pegawai</th>
                                        <th>NIP</th>
                                        <th>Jabatan</th>
                                        <th>Bidang</th>
                                        <th>Alamat</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No HP</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pegawais as $pegawai)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pegawai->nama_pegawai }}</td>
                                        <td>{{ $pegawai->nip }}</td>
                                        <td>{{ $pegawai->jabatan }}</td>
                                        <td>{{ $pegawai->bidang->name_bidang ?? '-' }}</td>
                                        <td>{{ $pegawai->alamat }}</td>
                                        <td>{{ $pegawai->jenis_kelamin }}</td>
                                        <td>{{ $pegawai->no_hp }}</td>
                                        <td>{{ $pegawai->email }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editPegawaiModal{{ $pegawai->pegawai_id }}"><i class="fa fa-edit"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm delete-button" data-id="{{ $pegawai->pegawai_id }}"><i class="fa fa-trash"></i></button>
                                            <form id="delete-form-{{ $pegawai->pegawai_id }}" action="{{ route('pegawai.destroy', $pegawai->pegawai_id) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editPegawaiModal{{ $pegawai->pegawai_id }}" tabindex="-1" aria-labelledby="editPegawaiModalLabel{{ $pegawai->pegawai_id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editPegawaiModalLabel{{ $pegawai->pegawai_id }}">Edit Pegawai</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('pegawai.update', $pegawai->pegawai_id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                    <div class="form-row">
                                                        <div class="form-group col-4">
                                                                <label for="nama_pegawai">Nama Pegawai *</label>
                                                                <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" value="{{ $pegawai->nama_pegawai }}" required>
                                                        </div>
                                                        <div class="form-group col-4">
                                                                <label for="nip">NIP *</label>
                                                                <input type="text" class="form-control" id="nip" name="nip" value="{{ $pegawai->nip }}" required>
                                                        </div>
                                                        <div class="form-group col-4">
                                                                <label for="jabatan">Jabatan *</label>
                                                                <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $pegawai->jabatan }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-4">
                                                            <label for="bidang_id">Bidang *</label>
                                                            <select class="form-control" id="bidang_id" name="bidang_id">
                                                                <option value="">Pilih Bidang</option>
                                                                @foreach($bidangs as $bidang)
                                                                    <option value="{{ $bidang->bidang_id }}" {{ $pegawai->bidang_id == $bidang->bidang_id ? 'selected' : '' }}>{{ $bidang->name_bidang }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-4">
                                                            <label for="email">Email *</label>
                                                            <input type="email" class="form-control" id="email" name="email" value="{{ $pegawai->email }}" required>
                                                        </div>
                                                        <div class="form-group col-4">
                                                            <label for="jenis_kelamin">Jenis Kelamin *</label>
                                                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                                                <option value="Laki-laki" {{ $pegawai->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                                <option value="Perempuan" {{ $pegawai->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-4">
                                                            <label for="no_hp">No HP *</label>
                                                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $pegawai->no_hp }}" required>
                                                        </div>
                                                        <div class="form-group col-8">
                                                            <label for="alamat">Alamat *</label>
                                                            <textarea class="form-control" id="alamat" name="alamat" required>{{ $pegawai->alamat }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-4">
                                                            <label for="password">Password *</label>
                                                            <input type="password" class="form-control" id="password" name="password" placeholder="Optional">
                                                        </div>
                                                        <div class="form-group col-4">
                                                            <label for="password_confirmation">Confirm Password *</label>
                                                            <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat Password">
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

                    <!-- Add Modal -->
                    <div class="modal fade" id="addPegawaiModal" tabindex="-1" aria-labelledby="addPegawaiModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addPegawaiModalLabel">Add Pegawai</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="add-pegawai-form" action="{{ route('pegawai.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-row">
                                            <div class="form-group col-4">
                                                <label for="nama_pegawai">Nama Pegawai <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" required>
                                            </div>
                                            <div class="form-group col-4">
                                                <label for="nip">NIP <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="nip" name="nip" required>
                                            </div>
                                            <div class="form-group col-4">
                                                <label for="jabatan">Jabatan <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-4">
                                            <label for="bidang_id">Bidang <span class="text-danger">*</span></label>
                                            <select class="form-control" id="bidang_id" name="bidang_id">
                                                <option value="">Pilih Bidang</option>
                                                @foreach($bidangs as $bidang)
                                                    <option value="{{ $bidang->bidang_id }}">{{ $bidang->name_bidang }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                            <div class="form-group col-4">
                                                <label for="email">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                            <div class="form-group col-4">
                                                <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                                    <option value="Laki-laki">Laki-laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-4">
                                                <label for="no_hp">No HP <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                                            </div>
                                            <div class="form-group col-8">
                                                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                                            </div>
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
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#example1').DataTable();

        $('.delete-button').on('click', function () {
            var pegawaiId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form-' + pegawaiId).submit();
                }
            });
        });
    });
</script>
@endpush
