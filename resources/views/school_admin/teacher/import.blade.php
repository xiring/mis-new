@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Manage {{ $page }}</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">{{ $page }}</li>
                    <li class="breadcrumb-item active"><a href="#" class="breadcrumb-link">Import</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Import Teacher
        </div>
        <div class="card-body">
            {{ Form::open(['route' => 'teacher.import.bulk.store' , 'files' => true]) }}
                <div class="form-group">
                    <label class="col-form-label">File</label>
                    <input type="file" name="file" class="form-control-file" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-xs btn-rounded btn-primary">Import</button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection    