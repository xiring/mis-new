@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Dashboard</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">{{ $page }}</li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $class->name  }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="pills-regular">
                <ul class="nav nav-pills mb-1" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" target="_blank" href="#">
                           Left Students
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                        <div class="card-body table-responsive">
                            <table class="table table-striped" width="100%" id="datatable">
                                <thead>
                                    <th>S.N</th>
                                    <th>Roll</th>
                                    <th>Section</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Parent Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @php $n = 0 @endphp
                                    @foreach($enrolls as $enroll)
                                        <tr>
                                            <td>{{ ++$n }}</td>
                                            <td>{{ $enroll->roll_number }}</td>
                                            <td>{{ $enroll->section->name }}</td>
                                            <td>{{ $enroll->student->user->name }}</td>
                                            <td>{{ $enroll->student->address }}</td>
                                            <td>{{ $enroll->student->user->email }}</td>
                                            <td>{{ $enroll->student->parent->user->name }}</td>
                                            <td>
                                                 <a href="{{ route('student.mark.unleft', $enroll->id) }}" class="btn btn-link">Mark Un-left</a>
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
@endsection
@section('customScript')
    @include('school_admin.partials.datatable')
@endsection    