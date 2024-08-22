@extends('template.main')
@section('title', 'Add Penanggung Jawab')
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
                            <h3 class="card-title">Add Penanggung Jawab</h3>
                            <div class="text-right">
                                <a href="/penanggung-jawab" class="btn btn-warning btn-sm">
                                    <i class="fa-solid fa-arrow-rotate-left"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body col-lg-3">
                            <form action="{{ route('penanggung-jawab.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name_penanggung_jawab">Nama Penanggung Jawab</label>
                                    <input type="text" name="name_penanggung_jawab" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Penanggung Jawab</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
