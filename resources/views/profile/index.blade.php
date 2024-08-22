@extends('template.main')
@section('title', 'Profile')
@section('content')

<style>
.profile-image img {
    width: 150px; /* Atur lebar sesuai kebutuhan */
    height: 150px; /* Atur tinggi sesuai kebutuhan */
    object-fit: cover; /* Memastikan gambar memenuhi area dengan memotong bagian yang tidak diperlukan */
    border-radius: 50%; /* Membuat gambar berbentuk lingkaran */
}
.form-group-inline {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}
.form-group-inline .form-group {
    flex: 1;
    min-width: 250px;
}
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-header">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update Profile</h3>
                        </div>
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group-inline">
                                    <div class="form-group col-md-3">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Current password">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm password">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="nip">NIP</label>
                                        <input type="text" class="form-control" id="nip" name="nip" value="{{ $user->pegawai->nip }}" disabled>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $user->pegawai->alamat }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="no_hp">Nomor HP</label>
                                        <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $user->pegawai->no_hp }}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                            <option value="">Pilih</option>
                                            <option value="Laki-laki" {{ $user->pegawai->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ $user->pegawai->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="profile_image">Profile Image</label>
                                        <input type="file" class="form-control" id="profile_image" name="profile_image">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="ttd">Upload Tanda Tangan</label>
                                        <input type="file" class="form-control" id="ttd" name="ttd">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Profile Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <p>{{ $user->name }}</p>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <p>{{ $user->email }}</p>
                            </div>
                            <div class="profile-image">
                                <label>Profile Image</label><br>
                                @if ($user->profile_image)
                                    <img src="{{ asset('images/profile/' . $user->profile_image) }}" alt="Profile Image" id="profile_image_preview">
                                @else
                                    <img src="{{ asset('images/default-profile.png') }}" alt="Profile Image" id="profile_image_preview">
                                @endif
                            </div>
                            <div class="profile-image">
                                <label>Tanda Tangan</label><br>
                                @if ($user->ttd)
                                    <img src="{{ asset('images/ttd/' . $user->ttd) }}" alt="Tanda Tangan" id="ttd_image_preview">
                                @else
                                    <img src="{{ asset('images/default-ttd.png') }}" alt="Tanda Tangan" id="ttd_image_preview">
                                @endif
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
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/custom.js') }}"></script>
@endsection
