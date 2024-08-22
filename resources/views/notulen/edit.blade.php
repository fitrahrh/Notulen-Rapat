@extends('template.main')
@section('title', 'Edit Notulen')
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
                                <a href="{{ route('notulen.index') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('notulen.update', $notulen->notulen_id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="text">Notulen Text</label>
                                    <textarea name="text" id="text" class="form-control" rows="5" required>{{ $notulen->text }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="jadwal_id">Jadwal</label>
                                    <select name="jadwal_id" id="jadwal_id" class="form-control" required>
                                        @foreach ($jadwals as $jadwal)
                                            <option value="{{ $jadwal->jadwal_id }}" {{ $notulen->jadwal_id == $jadwal->jadwal_id ? 'selected' : '' }}>{{ $jadwal->jadwal_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="id_user">User</label>
                                    <select name="id_user" id="id_user" class="form-control" required>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ $notulen->id_user == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="foto">Upload Foto</label>
                                    <input type="file" name="foto" id="foto" class="form-control-file">
                                    <img src="{{ Storage::url($notulen->foto) }}" alt="Foto" class="mt-2" width="100">
                                </div>
                                <div class="form-group">
                                    <label for="undangan">Upload Undangan</label>
                                    <input type="file" name="undangan" id="undangan" class="form-control-file">
                                    <a href="{{ Storage::url($notulen->undangan) }}" target="_blank" class="mt-2 d-block">Current File</a>
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
