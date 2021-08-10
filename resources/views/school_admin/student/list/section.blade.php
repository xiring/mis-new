@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Dashboard</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">{{ $page }}</li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $class->name  }} ( {{ $section ->name }} )</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <a href="{{ route('student.admit') }}" target="_blank" class="btn btn-sm btn-rounded btn-primary-link"><i class="fas fa-plus-square"></i> Add New Student</a>
        </div>
        <div class="card-body">
            <div class="pills-regular">
                <ul class="nav nav-pills mb-1" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('class.student.index', $class->id) }}">All Students</a>
                    </li>
                    @foreach($class->sections as $section)
                        <li class="nav-item">
                            <a class="nav-link {{ ($section->id == $section_id) ? 'active' : '' }}" href="{{ route('class.student.section.index', [$section->class_id, $section->id]) }}">Section ({{ $section->name }})</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <hr>
            <table class="table table-striped data_table" width="100%">
            <thead>
                <th>S.N</th>
                <th>Roll</th>
                <th>Name</th>
                <th>Address</th>
                <th>House</th>
                <th>Date Of Admission</th>
                <th>Status</th>
                <th>Options</th>
            </thead>
            <tbody>
                @php $n = 0;@endphp
                @foreach($enroll_sections as $enroll)
                    <tr>
                        <td>{{ ++$n }}</td>
                        <td>{{ $enroll->roll_number }}</td>
                        <td>{{ $enroll->student->user->name }}</td>
                        <td>{{ $enroll->student->address }}</td>
                        <td>{{ $enroll->student->house }}</td>
                        <td>{{ Carbon\Carbon::parse($enroll->created_at)->format('Y-m-d') }}</td>
                        <td>
                            <?=($enroll->student->user->is_active == 0)?
                                '<span class="badge badge-danger">Deleted</span>'
                                :
                                '<span class="badge badge-success">Active</span>'
                            ;?>
                        </td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-sm btn-rounded btn-outline-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Options
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if($enroll->student->user->is_active == 1)
                                        <a href="" data-toggle="modal" data-target="#editStudent" data-date="{{ \Carbon\Carbon::parse($enroll->student->date_of_birth)->format('Y-m-d')  }}" data-religion="{{ $enroll->student->religion }}" data-gender="{{ $enroll->student->gender }}" data-id="{{ $enroll->id }}" data-roll="{{ $enroll->roll_number }}" data-name="{{ $enroll->student->user->name }}" data-address="{{ $enroll->student->address }}" data-email="{{ $enroll->student->user->email }}" data-class="{{ $enroll->class_id }}" data-section="{{ $enroll->section_id }}" data-parent="{{ $enroll->student->parent_id }}" data-transport="{{ $enroll->student->transport_id }}" data-house="{{ $enroll->student->house }}" class="dropdown-item">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ route('student.view', $enroll->id) }}" class="dropdown-item">View</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="" data-toggle="modal" data-target="#scholarshipStudent" data-id="{{ $enroll->student->id }}" data-scholarship="{{ $enroll->student->scholarship_id }}" class="dropdown-item">Assign Scholarship</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ route('student.delete', $enroll->student->user->id) }}" class="dropdown-item">Delete</a>
                                    @else
                                        <a href="{{ route('student.restore', $enroll->student->user->id) }}" class="dropdown-item">Restore</a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>

    <div class="modal fade" id="editStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Student : <span id="student_name"></span></h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'student.update' , 'files' => true]) }}
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group">
                                <label class="col-form-label">Name</label>
                                <input type="hidden" id="id" name="id">
                                <input type="text" class="form-control" id="name" name="name" required autofocus>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Parent</label>
                                <select class="form-control" name="parent_id" id="parent_id" required>
                                    <option></option>
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}">{{ $parent->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Class</label>
                                <select class="form-control" name="class_id" id="class_id" required>
                                    <option></option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Section</label>
                                <select class="form-control" name="section_id" id="section_id" required>
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
                                <input type="text" class="form-control" name="roll_number" id="roll_number" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Email</label>
                                <input type="email" class="form-control" id="email" disabled name="email" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Date Of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Gender</label>
                                <select class="form-control" name="gender" id="gender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Religion</label>
                                <input type="text" class="form-control" id="religion" name="religion">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Transport</label>
                                <select class="form-control" name="transport_id" id="transport_id">
                                    <option></option>
                                    @foreach($transport as $transport)
                                        <option value="{{ $transport->id }}">{{ $transport->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">House</label>
                                <input type="text" class="form-control" id="house" name="house">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-outline-primary">Update</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="scholarshipStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assign Scholarship</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'student.scholarship.update' , 'files' => true]) }}
                <div class="modal-body">
                    <div class="container-fluid">
                        <input type="hidden" id="id_student" name="id">
                        <div class="form-group">
                            <label class="col-form-label">Scholarship</label>
                            <select class="form-control" name="scholarship_id" id="scholarship_id" required>
                                @foreach($scholarships as $scholarship)
                                    <option value="{{ $scholarship->id }}">{{ $scholarship->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-rounded btn-outline-primary">Update</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
@section('customScript')
    @include('school_admin.partials.datatable')
    <script>
        $(document).ready(function() {

            $('#editStudent').on('show.bs.modal', function(e) {
                var  id= $(e.relatedTarget).data('id');
                var  name= $(e.relatedTarget).data('name');
                var parent = $(e.relatedTarget).data('parent');
                var class_id = $(e.relatedTarget).data('class');
                var transport  = $(e.relatedTarget).data('transport');
                var section_id  = $(e.relatedTarget).data('section');
                var roll_number  = $(e.relatedTarget).data('roll');
                var address  = $(e.relatedTarget).data('address');
                var email  = $(e.relatedTarget).data('email');
                var date  = $(e.relatedTarget).data('date');
                var religion  = $(e.relatedTarget).data('religion');
                var gender  = $(e.relatedTarget).data('gender');

                $("#id").val(id);
                $("#student_name").html(name);
                $("#name").val(name);
                $("#parent_id").val(parent);
                $("#class_id").val(class_id);
                $("#transport_id").val(transport);
                $("#section_id").val(section_id);
                $("#roll_number").val(roll_number);
                $("#address").val(address);
                $("#email").val(email);
                $("#date_of_birth").val(date);
                $("#religion").val(religion);
                $("#gender").val(gender);
            });

            $('#scholarshipStudent').on('show.bs.modal', function(e) {
                var  id= $(e.relatedTarget).data('id');
                var scholarship = $(e.relatedTarget).data('scholarship');

                $("#id_student").val(id);
                $("#scholarship_id").val(scholarship);
            });
        });

    </script>
@endsection
