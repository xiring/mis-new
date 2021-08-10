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
            <a href="" class="btn btn-sm btn-rounded btn-primary-link" data-toggle="modal" data-target="#addAccoutant"><i class="fas fa-plus-square"></i> Add New Accountant </a>
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
                @foreach($accountants as $row)
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
                                        <a href="" data-toggle="modal" data-target="#editAccoutant" data-id="{{ $row->id }}" data-user="{{ $row->user->id }}" data-name="{{ $row->user->name }}" data-email="{{ $row->user->email }}" class="dropdown-item">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ route('accountant.delete', $row->user->id) }}" class="dropdown-item">Delete</a>
                                    @else
                                        <a href="{{ route('accountant.restore', $row->user->id) }}" class="dropdown-item">Restore</a>
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

    <div class="modal fade" id="addAccoutant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Accountant</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'accountant.store' , 'files' => true]) }}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Name</label>
                        <input type="hidden" name="school_id" value="{{ Auth::user()->school->id }}">
                        <input type="text" class="form-control" name="name" required autofocus>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-rounded btn-outline-primary">Save</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="editAccoutant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Accountant : <span id="accountant_name"></span></h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'accountant.update' , 'files' => true]) }}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Name</label>
                        <input type="hidden" name="user_id" id="user_id">
                        <input type="hidden" name="id" id="id">
                        <input type="text" class="form-control" id="name" name="name" required autofocus>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" disabled="disabled" required>
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

            $('#editAccoutant').on('show.bs.modal', function(e) {
                var  id= $(e.relatedTarget).data('id');
                var  name= $(e.relatedTarget).data('name');
                var user_id  = $(e.relatedTarget).data('user');
                var email  = $(e.relatedTarget).data('email');

                $("#id").val(id);
                $("#accountant_name").html(name);
                $("#name").val(name);
                $("#user_id").val(user_id);
                $("#email").val(email);
            });
        });

    </script>
@endsection