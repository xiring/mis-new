@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Manage {{ $page }}</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                     <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
           <a href="" class="btn btn-sm btn-rounded btn-primary-link" data-toggle="modal" data-target="#addTeacher"><i class="fas fa-plus-square"></i> Add New Teacher </a><br /><br />
           <a href="{{ route('teacher.import.bulk') }}" class="btn btn-sm btn-rounded btn-primary-link" >Bulk Import </a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped" width="100%" id="datatable">
                <thead>
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Options</th>
                </thead>
                <tbody>
                    @php $n = 0 @endphp
                    @foreach($teachers as $row)
                        <tr>
                            <td>{{ ++$n }}</td>
                            <td>{{ $row->user->name }}</td>
                            <td>{{ $row->user->email }}</td>
                            <td>
                                <?=($row->user->is_active == 0)?
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
                                        @if($row->user->is_active == 1)
                                            <a href="" data-toggle="modal" data-target="#editTeacher{{ $row->id }}" class="dropdown-item">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('teacher.delete', $row->user->id) }}" class="dropdown-item">Delete</a>
                                        @else
                                            <a href="{{ route('teacher.restore', $row->user->id) }}" class="dropdown-item">Restore</a>
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

    <div class="modal fade" id="addTeacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Teacher</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'teacher.store' , 'files' => true]) }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label">Name</label>
                            <input type="text" class="form-control" name="name" required autofocus>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Designation</label>
                            <input type="text" class="form-control" name="designation" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Hired Date</label>
                            <input type="date" class="form-control" name="hired_date" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Date Of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Gender</label>
                            <select class="form-control" name="gender" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Address</label>
                            <input type="text" class="form-control" name="address" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Photo</label>
                            <input type="file" name="photo" class="form-control-file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-outline-primary">Save</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    @foreach($teachers as $row)
        <div class="modal fade" id="editTeacher{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Teacher : {{ $row->user->name }}</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    {{ Form::open(['route' => 'teacher.update' , 'files' => true]) }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label">Name</label>
                            <input type="hidden" value="{{ $row->user->id }}" name="user_id">
                            <input type="text" class="form-control" name="name" value="{{ $row->user->name }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Designation</label>
                            <input type="text" class="form-control" name="designation" value="{{ $row->designation }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Hired Date</label>
                            <input type="date" class="form-control" name="hired_date" value="{{ \Carbon\Carbon::parse($row->hired_date)->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Date Of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth" value="{{ \Carbon\Carbon::parse($row->date_of_birth)->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Email</label>
                            <input type="email" class="form-control" name="email" disabled="disabled" value="{{ $row->user->email }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Gender</label>
                            <select class="form-control" name="gender" required>
                                <option value="male" {{ ($row->gender == 'male') ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ ($row->gender == 'female') ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Address</label>
                            <input type="text" class="form-control" name="address" value="{{ $row->addresss }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" value="{{ $row->phone }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Photo</label>
                            <input type="file" name="photo" class="form-control-file">
                            @if($row->photo)
                                <br />
                                <img src="{{ asset($row->photo) }}" class="img-thumbnail" height="100px" width="100px">
                            @endif
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
