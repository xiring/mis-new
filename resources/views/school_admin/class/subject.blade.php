@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Dashboard</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Class - {{  $class->name }}</a></li>
                    <li class="breadcrumb-item active"><a href="#" class="breadcrumb-link">{{  $page }}</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <a href="" class="btn btn-sm btn-rounded btn-primary-link" data-toggle="modal" data-target="#addSubject"><i class="fas fa-plus-square"></i> Add New Subject </a>
        </div>
        <div class="card-body">
            <div class="card-body table-responsive">
                <table class="table table-striped" width="100%" id="datatable">
                    <thead>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Teacher</th>
                        <th>Type</th>
                        <th>Full Marks</th>
                        <th>Theory</th>
                        <th>Practical</th>
                        <th>Status</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        @php $n = 0 @endphp
                        @foreach($subjects as $row)
                            <tr>
                                <td>{{ ++$n }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->teacher->user->name }}</td>
                                <td>{{ $row->type }}</td>
                                <td>{{ $row->full_marks }}</td>
                                <td>{{ $row->full_marks_theory }}</td>
                                <td>{{ $row->full_marks_practical }}</td>
                                <td>
                                    <?=($row->is_active == 0)?
                                        '<span class="badge badge-danger">Deleted</span>'
                                        :
                                        '<span class="badge badge-success">Active</span>'
                                    ;?>

                                   @if($system_settings->id == 2)
                                       <?=($row->mark_optional == 0)?
                                            '<span class="badge badge-success">Optional</span>'
                                            :
                                            '<span class="badge badge-success">Primary</span>'
                                        ;?>
                                   @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-rounded btn-outline-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Options
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if($row->is_active == 1)
                                                <a href="" data-toggle="modal" data-target="#editSubject{{ $row->id }}" class="dropdown-item">Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a href="{{ route('subject.delete', $row->id) }}" class="dropdown-item">Delete</a>
                                            @else
                                                <a href="{{ route('subject.restore', $row->id) }}" class="dropdown-item">Restore</a>
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
    </div>

    <div class="modal fade" id="addSubject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Subject : {{  $class->name }}</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'subject.store' , 'files' => true]) }}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Name</label>
                        <input type="hidden" name="class_id" value="{{ $class->id  }}">
                        <input type="hidden" name="school_id" value="{{ $class->school_id  }}">
                        <input type="text" class="form-control" name="name" required autofocus>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Select Class Teacher</label>
                        <select class="form-control" name="teacher_id">
                            @foreach ($teachers as $teacher)
                                <option value="{{  $teacher->id }}">{{ $teacher->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Select Subject Type</label>
                        <select class="form-control" name="type">
                            <option value="is_oral_written">Is Oral & Written</option>
                            <option value="is_none">Is None</option>
                        </select>
                    </div>
                    @if($system_settings->id == 2)
                        <div class="form-group">
                            <label class="col-form-label">Primary/ Optional</label>
                            <select class="form-control" name="mark_optional">
                                <option value="1">Primary</option>
                                <option value="0">Optional</option>
                            </select>
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="col-form-label">Full Marks</label>
                        <input type="number" class="form-control" name="full_marks" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Full Marks Therory</label>
                        <input type="number" class="form-control" name="full_marks_theory">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Full Marks Practical</label>
                        <input type="number" class="form-control" name="full_marks_practical">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-rounded btn-outline-primary">Save</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    @foreach($subjects as $subject)
        <div class="modal fade" id="editSubject{{ $subject->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Subject : {{  $subject->name }}</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    {{ Form::open(['route' => 'subject.update' , 'files' => true]) }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label">Name</label>
                            <input type="hidden" name="id" value="{{ $subject->id }}">
                            <input type="hidden" name="class_id" value="{{ $subject->class->id  }}">
                            <input type="hidden" name="school_id" value="{{ $subject->school->id  }}">
                            <input type="text" class="form-control" value="{{ $subject->name }}" name="name" required autofocus>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Select Class Teacher</label>
                            <select class="form-control" name="teacher_id">
                                @foreach ($teachers as $teacher)
                                    <option value="{{  $teacher->id }}" {{ ($teacher->id == $subject->teacher_id) ? 'selected' : '' }}>{{ $teacher->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Select Subject Type</label>
                            <select class="form-control" name="type">
                                <option value="is_oral_written" {{ ($subject->type == 'is_oral_written') ? 'selected' : '' }}>Is Oral & Written</option>
                                <option value="is_none" {{ ($subject->type == 'is_none') ? 'selected' : '' }}>Is None</option>
                            </select>
                        </div>
                        @if($system_settings->id == 2)
                            <div class="form-group">
                                <label class="col-form-label">Primary/ Optional</label>
                                <select class="form-control" name="mark_optional">
                                    <option value="1" {{ ($subject->mark_optional == 1) ? 'selected' : '' }}>Primary</option>
                                    <option value="0" {{ ($subject->mark_optional == 0) ? 'selected' : '' }}>Optional</option>
                                </select>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="col-form-label">Full Marks</label>
                            <input type="number" class="form-control" value="{{ $subject->full_marks }}" name="full_marks" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Full Marks Therory</label>
                            <input type="number" class="form-control" name="full_marks_theory" value="{{ $subject->full_marks_theory }}">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Full Marks Practical</label>
                            <input type="number" class="form-control" name="full_marks_practical" value="{{ $subject->full_marks_practical }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-outline-primary">Update</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    @endforeach
@endsection
@section('customScript')
    @include('school_admin.partials.datatable')
@endsection
