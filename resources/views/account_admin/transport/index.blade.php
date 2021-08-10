@extends('layouts.account_admin')

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
            <a href="" class="btn btn-sm btn-rounded btn-primary-link" data-toggle="modal" data-target="#addTransport"><i class="fas fa-plus-square"></i> Add New Transport</a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped" width="100%" id="datatable">
                <thead>
                    <th>S.N</th>
                    <th>Route</th>
                    <th>Number Of Vehicle</th>
                    <th>Fare</th>
                    <th>Status</th>
                <th>Options</th>
                </thead>
                <tbody>
                    @php $n = 0 @endphp
                    @foreach($transports as $row)
                        <tr>
                            <td>{{ ++$n }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->number_of_vehicle }}</td>
                            <td>{{ $row->fare }}</td>
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
                                            <a href="" data-toggle="modal" data-target="#editTransport{{ $row->id }}" class="dropdown-item">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('transport.accountant.view.student', $row->id) }}" class="dropdown-item">View Students</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('transport.accountant.delete', $row->id) }}" class="dropdown-item">Delete</a>
                                        @else
                                            <a href="{{ route('transport.accountant.restore', $row->id) }}" class="dropdown-item">Restore</a>
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

    <div class="modal fade" id="addTransport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Transport</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'transport.accountant.store' , 'files' => true]) }}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Route</label>
                        <input type="hidden" value="{{ Session::get('school_id') }}" name="school_id">
                        <input type="text" class="form-control" name="name" required autofocus>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Number Of Vehicle</label>
                        <input type="number" class="form-control" name="number_of_vehicle" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Fare</label>
                        <input type="number" class="form-control" name="fare" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-rounded btn-outline-primary">Save</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    @foreach($transports as $row)
        <div class="modal fade" id="editTransport{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Transport : {{ $row->name }}</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    {{ Form::open(['route' => 'transport.accountant.update' , 'files' => true]) }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label">Route</label>
                            <input type="hidden" value="{{ $row->id }}" name="id">
                            <input type="text" class="form-control" name="name" value="{{ $row->name }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Number Of Vehicle</label>
                            <input type="number" class="form-control" name="number_of_vehicle" value="{{ $row->number_of_vehicle }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Fare</label>
                            <input type="number" class="form-control" name="fare" value="{{ $row->fare }}" required>
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
    @include('account_admin.partials.datatable')
@endsection
