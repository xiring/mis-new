@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Dashboard</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">{{ $page }}</li>
                    <li class="breadcrumb-item active" aria-current="page">Search Results</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive" style="height: 300px;">
            <table class="table table-striped" width="100%" id="datatable">
                <thead>
                    <th>S.N</th>
                    <th>Roll</th>
                    <th>Class</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Parent Name</th>
                    <th>Contact Number</th>
                    <th>Birthday</th>
                    <th>Transport</th>
                    <th>Date Of Admission</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @php $n = 0 @endphp
                    @foreach($students as $student)
                        <tr>
                            <td>{{ ++$n }}</td>
                            <td>{{ $student->enroll->roll_number }}</td>
                            <td>{{ $student->enroll->class->name }} - {{ $student->enroll->section->name }}</td>
                            <td>{{ $student->user->name }}</td>
                            <td>{{ $student->address }}</td>
                            <td>{{ $student->parent->user->name }}</td>
                            <td>{{ $student->parent->phone }}</td>
                            <td>{{ $student->dob_nepali }}</td>
                            <td>{{ ($student->transport != null) ? $student->transport->name : 'n/a' }}</td>
                            <td>{{ Carbon\Carbon::parse($student->enroll->created_at)->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('student.view', $student->enroll->id) }}" class="btn btn-link">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
