@extends('template.main')
@section('title', 'User Editor')
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
                                <div class="text-right">
                                    <a href="{{ route('user-editor.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add User</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Divisi</th>
                                            <th>Divisi Bagian</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->divisi ? $user->divisi->name_divisi : 'No Divisi Assigned' }}</td>
                                                <td>{{ $user->divisiBagian ? $user->divisiBagian->name_divisi_bagian : 'No Divisi Bagian Assigned' }}</td>
                                                <td>
                                                    <a href="{{ route('user-editor.edit', $user->id_user) }}" class="btn btn-success btn-sm mr-1">
                                                        <i class="fa-solid fa-pen"></i> Edit
                                                    </a>
                                                    <form action="{{ route('user-editor.destroy', $user->id_user) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
