@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">{{ $page }}</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Student</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><i class="fas fa-plus"></i>&nbsp;Admit Bulk </div>
        <div class="card-body">
            {{ Form::open(['route' => 'student.admit.bulk.store' , 'files' => true]) }}
                <div class="form-group">
                    <label class="col-form-label">Class</label>
                    <input type="hidden" name="school_id" value="{{ Auth::user()->school->id }}">
                    <select class="form-control select2" name="class_id" onchange="getClassSections(this.value);">
                        <option>Pleas Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Section</label>
                    <select class="form-control select2" name="section_id" id="section_holder">
                        <option>Pleas Select Class First</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Excel File</label>
                    <input type="file" name="uploaded_file" class="form-control-file" required>
                    <br />
                    <a href="{{ route('student.download.csv') }}" target="_blank">Download CSV Flie </a>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-rounded btn-primary submit-monthly"><i class="fas fa-save"></i></button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
@section('customScript')
    <script>
        function getClassSections(class_id) {
            if (class_id !== '') {
                $.ajax({
                    url: '{{ url('/school/dashboard/class/sections') }}'+'/'+ class_id ,
                    success: function(response)
                    {
                        jQuery('#section_holder').html(response);
                    }
                });
            }
        }
    </script>
@endsection        