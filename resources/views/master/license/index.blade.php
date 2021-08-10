@extends('layouts.master')

@section('content')
    <div class="card-header">All Licenses</div>

    <div class="card-body">
        <table id="data-table-list" class="table table-bordered table-striped">
            <a href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#licenseCreate"><i class="fas fa-plus-square"></i></a><br /><br />
            <thead>
                <th>S.N</th>
                <th>Name</th>
                <th>Key</th>
                <th>Number Of User</th>
                <th>Status</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @php $n=0; @endphp
                @foreach($licenses as $row)
                    <tr>
                        <td>{{ ++$n }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->key }}</td>
                        <td>{{ $row->number_of_user }}</td>
                        <td>
                            <?=($row->is_active == 0)?
                                '<span class="badge badge-danger">Deleted</span>'
                                :
                                '<span class="badge badge-success">Active</span>'
                            ;?>
                        </td>
                        <td>
                            @if($row->is_active == 0)
                                <a href="{{ route('license.restore', $row->id)}}" class="btn btn-sm btn-info"><i class="fas fa-undo"></i></a>
                            @else
                                <a href="" data-toggle="modal" data-target="#licenseEdit{{ $row->id }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a></a>
                                <a href="{{ route('license.delete', $row->id)}}" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="licenseCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title" id="myModalLabel">Add License</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                {{ Form::open(['route' => 'license.store' , 'files' => true]) }}
                    <div class="container-fluid">
                    <div class="form-group">
                        <label class="col-form-label text-md-right" for="name">Name <b style="color: red;">*</b></label>
                        <input type="text" name="name" class="form-control" required >
                    </div>
                    <div class="form-group">
                        <label class="col-form-label text-md-right" for="name">Number Of Users <b style="color: red;">*</b></label>
                        <input type="number" class="form-control" name="number_of_user" required>
                    </div>
                </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i></button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    @foreach($licenses as $row)
        <div class="modal fade" id="licenseEdit{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title" id="myModalLabel">Edit License</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    {{ Form::open(['route' => 'license.update' , 'files' => true]) }}
                    <div class="container-fluid">
                        <div class="form-group">
                            <label class="col-form-label text-md-right" for="name">Name <b style="color: red;">*</b></label>
                            <input type="hidden" value="{{ $row->id }}" name="id">
                            <input type="text" name="name" value="{{ $row->name }}" class="form-control" required >
                        </div>
                        <div class="form-group">
                            <label class="col-form-label text-md-right" for="name">Number Of Users <b style="color: red;">*</b></label>
                            <input type="number" class="form-control" value="{{ $row->number_of_user }}" name="number_of_user" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i></button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    @endforeach
@endsection