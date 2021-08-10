@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Manage {{ $page }}</h2>
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
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="card-header"><i class="fas fa-plus"></i>&nbsp;Admission Form </div>
                    <div class="card-body">
                        {{ Form::open(['route' => 'student.admit.store' , 'files' => true]) }}
                            <div class="container-fluid">
                                <input type="hidden" value="{{ Auth::user()->school->id }}" name="school_id">
                                <div class="form-group">
                                    <label class="col-form-label">Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Parent</label>
                                    <select class="form-control select2" name="parent_id"required>
                                        <option></option>
                                        @foreach($parents as $parent)
                                            <option value="{{ $parent->id }}">{{ $parent->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Class</label>
                                    <select class="form-control select2" name="class_id"required>
                                        <option></option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Section</label>
                                    <select class="form-control select2" name="section_id" required>
                                        <option></option>
                                        @foreach($classes as $class)
                                            <optgroup label="{{ $class->name }}"></optgroup>
                                            @foreach($class->sections as $section)
                                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                                             @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Roll</label>
                                    <input type="text" class="form-control" name="roll_number" required>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Date Of Birth</label>
                                    <input type="date" class="form-control" name="date_of_birth" required>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Gender</label>
                                    <select class="form-control" name="gender">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Religion</label>
                                    <input type="text" class="form-control" name="religion">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Address</label>
                                    <input type="text" class="form-control" name="address" required>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Transport</label>
                                    <select class="form-control select2" name="transport_id">
                                        <option></option>
                                        @foreach($transport as $transport)
                                            <option value="{{ $transport->id }}">{{ $transport->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                   <button type="submit" class="btn btn-rounded btn-primary">Submit</button>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body bg-info">
                            <strong>Student Admission Notes</strong>
                            <p>Admitting new students will automatically create an enrollment to the selected class in the running session. Please check and recheck the informations you have inserted because once you admit new student, you won't be able to edit his/her class,roll,section without promoting to the next session.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection