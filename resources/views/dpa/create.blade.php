@extends('template.main')
@section('title', 'Add Divisi Bagian')
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
                            <h3 class="card-title">Add Divisi Bagian</h3>
                            <div class="text-right">
                                <a href="/divisi-bagian" class="btn btn-warning btn-sm">
                                <i class="fa-solid fa-arrow-rotate-left"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('divisi-bagian.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name_divisi_bagian">Name</label>
                                    <input type="text" name="name_divisi_bagian" class="form-control" value="{{ old('name_divisi_bagian') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="divisi_id">Divisi</label>
                                    <select name="divisi_id" class="form-control" required>
                                        <option value="">Select Divisi</option>
                                        @foreach ($divisis as $divisi)
                                            <option value="{{ $divisi->divisi_id }}">{{ $divisi->name_divisi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Divisi Bagian</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
