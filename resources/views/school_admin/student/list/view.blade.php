@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Dashboard</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">{{ $page }}</li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $enroll->student->user->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
            <div class="col-md-12">
                <div class="row">
                    <div class="card col-md-6">
                        <div class="card-header bg-primary">Basic Info</div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $enroll->student->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Parent</th>
                                    <td>{{ $enroll->student->parent->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Class</th>
                                    <td>{{ $enroll->class->name }} ({{ $enroll->section->name }})</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $enroll->student->user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>{{ $enroll->student->gender }}</td>
                                </tr>
                                <tr>
                                    <th>Birthday</th>
                                    <td>{{ $enroll->student->dob_nepali }}</td>
                                </tr>
                                <tr>
                                    <th>Transport</th>
                                    <td>{{ @$enroll->student->transport->name }}</td>
                                </tr>
                                 <tr>
                                    <th>Scholarship</th>
                                    <td>{{ @$enroll->student->scholarship->name }} ({{ @$enroll->student->scholarship->percentage }} %) </td>
                                </tr>
                                <tr>
                                    <th>Date Pf Admission</th>
                                    <td>{{ Carbon\Carbon::parse($enroll->created_at)->format('Y-m-d') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card col-md-6">
                        <div class="card-header bg-primary">Parent Info</div>
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <td>{{ $enroll->student->parent->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $enroll->student->parent->user->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $enroll->student->parent->phone }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $enroll->student->parent->address }}</td>
                            </tr>
                            <tr>
                                <th>Profession</th>
                                <td>{{ $enroll->student->parent->profession }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
