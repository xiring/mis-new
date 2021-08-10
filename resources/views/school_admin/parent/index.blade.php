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
            <a href="" class="btn btn-sm btn-rounded btn-primary-link" data-toggle="modal" data-target="#addParent"><i class="fas fa-plus-square"></i> Add New Parent </a>
            <br /><br />
           <a href="{{ route('parent.import.bulk') }}" class="btn btn-sm btn-rounded btn-primary-link" >Bulk Import </a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped" width="100%" id="datatable">
                <thead>
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Proffession</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Options</th>
                </thead>
                <tbody>
                    @php $n = 0 @endphp
                    @foreach($parents as $row)
                    <tr>
                        <td>{{ ++$n }}</td>
                        <td>{{ $row->user->name }}</td>
                        <td>{{ $row->user->email }}</td>
                        <td>{{ $row->phone }}</td>
                        <td>{{ $row->profession }}</td>
                        <td>{{ $row->address }}</td>
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
                                        <a href="" data-toggle="modal" data-target="#editParent{{ $row->id }}" class="dropdown-item">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ route('parent.delete', $row->id) }}" class="dropdown-item">Delete</a>
                                    @else
                                        <a href="{{ route('parent.restore', $row->id) }}" class="dropdown-item">Restore</a>
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

    <div class="modal fade" id="addParent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Parent</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'parent.store' , 'files' => true]) }}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Name</label>
                        <input type="hidden" name="school_id" value="{{ $system_settings->id }}">
                        <input type="text" class="form-control" name="name" required autofocus>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Proffession</label>
                        <input type="text" class="form-control" name="profession" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Address</label>
                        <input type="text" class="form-control" name="address" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-rounded btn-outline-primary">Save</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    @foreach($parents as $row)
        <div class="modal fade" id="editParent{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Parent : {{ $row->user->name }}</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    {{ Form::open(['route' => 'parent.update' , 'files' => true]) }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label">Name</label>
                            <input type="hidden" name="user_id" value="{{ $row->user_id }}">
                            <input type="text" class="form-control" name="name" value="{{ $row->user->name }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $row->user->email }}" disabled name="email" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Phone</label>
                            <input type="text" class="form-control" value="{{ $row->phone }}" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Proffession</label>
                            <input type="text" class="form-control" value="{{ $row->profession }}" name="profession" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Address</label>
                            <input type="text" class="form-control" value="{{ $row->address }}" name="address" required>
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
