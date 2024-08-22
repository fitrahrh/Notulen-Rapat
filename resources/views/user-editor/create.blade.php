@extends('template.main')
@section('title', 'Add User')
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

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Add User</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('user-editor.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="divisi_id">Divisi</label>
                                        <select name="divisi_id" class="form-control" required>
                                            @foreach($divisis as $divisi)
                                                <option value="{{ $divisi->divisi_id }}">{{ $divisi->name_divisi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="divisi_bagian_id">Divisi Bagian</label>
                                        <select name="divisi_bagian_id" class="form-control" required>
                                            @foreach($divisiBagians as $divisiBagian)
                                                <option value="{{ $divisiBagian->divisi_bagian_id }}">{{ $divisiBagian->name_divisi_bagian }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add User</button>
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
