@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Dashboard</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Class - {{  $class->name }}</a></li>
                    <li class="breadcrumb-item active"><a href="#" class="breadcrumb-link">{{  $page }}s</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <a href="" class="btn btn-sm btn-rounded btn-primary-link" data-toggle="modal" data-target="#addSection"><i class="fas fa-plus-square"></i> Add New Section </a>
        </div>
        <div class="card-body">
            <div class="card-body table-responsive">
                <table class="table table-striped" width="100%" id="datatable">
                    <thead>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Teacher</th>
                        <th>Status</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        @php $n = 0 @endphp
                        @foreach($sections as $row)
                            <tr>
                                <td>{{ ++$n }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->teacher->user->name }}</td>
                                <td>
                                    <?=($row->is_active == 0)?
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
                                            @if($row->is_active == 1)
                                                <a href="" data-toggle="modal" data-target="#editSection{{ $row->id }}" class="dropdown-item">Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a href="{{ route('section.delete', $row->id) }}" class="dropdown-item">Delete</a>
                                            @else
                                                <a href="{{ route('section.restore', $row->id) }}" class="dropdown-item">Restore</a>
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

    <div class="modal fade" id="addSection" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Section : {{  $class->name }}</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'section.store' , 'files' => true]) }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label">Name</label>
                            <input type="hidden" name="class_id" value="{{ $class->id  }}">
                            <input type="hidden" name="school_id" value="{{ $class->school_id  }}">
                            <input type="text" class="form-control" name="name" required autofocus>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label">Select Class Teacher</label>
                            <select class="form-control" name="teacher_id">
                                @foreach ($teachers as $teacher)
                                    <option value="{{  $teacher->id }}">{{ $teacher->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-outline-primary">Save</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    @foreach($sections as $section)
        <div class="modal fade" id="editSection{{ $section->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Section : {{ $section->class->name }}</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    {{ Form::open(['route' => 'section.update' , 'files' => true]) }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label">Name</label>
                            <input type="hidden" name="id" value="{{ $section->id }}">
                            <input type="hidden" name="class_id" value="{{ $section->class->id  }}">
                            <input type="hidden" name="school_id" value="{{ $section->school->id  }}">
                            <input type="text" class="form-control" name="name" value="{{ $section->name }}" required autofocus>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label">Select Class Teacher</label>
                            <select class="form-control" name="teacher_id">
                                @foreach ($teachers as $teacher)
                                    <option value="{{  $teacher->id }}" {{ ($section->teacher_id == $teacher->id) ? 'selected' : '' }}>{{ $teacher->user->name }}</option>
                                @endforeach
                            </select>
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
