@extends('layouts.master')

@section('content')
    <div class="card-header">All Schools</div>

    <div class="card-body">
        <table id="data-table-list" class="table table-bordered table-striped">
            <a href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#schoolCreate"><i class="fas fa-plus-square"></i></a><br /><br />
            <thead>
                <th>S.N</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Contact Number</th>
                <th>Contact Person</th>
                <th>Logo</th>
                <th>License</th>
                <th>Status</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @php $n=0; @endphp
                @foreach($schools as $row)
                    <tr>
                        <td>{{ ++$n }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->address }}</td>
                        <td>{{ $row->contact_number }}</td>
                        <td>{{ $row->contact_person }}</td>
                        <td><img src="{{ asset($row->logo) }}" class="img-thumbnail" width="100px" height="100px"></td>
                        <td>{{ @$row->schoolLicense->license->name }}</td>
                        <td>
                            <?=($row->is_active == 0)?
                                '<span class="badge badge-danger">Deleted</span>'
                                :
                                '<span class="badge badge-success">Active</span>'
                            ;?>
                        </td>
                        <td>
                            @if($row->is_active == 0)
                                <a href="{{ route('school.restore', $row->id)}}" class="btn btn-sm btn-info"><i class="fas fa-undo"></i></a>
                            @else
                                <a href="" data-toggle="modal" data-target="#licenseAdd" data-id="{{ $row->id }}" data-license="{{ $row->schoolLicense->id }}" data-li="{{ $row->schoolLicense->license_id }}" class="btn btn-sm btn-info"><i class="fas fa-key"></i></a></a>
                                <a href="{{ route('school.delete', $row->id)}}" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="schoolCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title" id="myModalLabel">Add School</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                {{ Form::open(['route' => 'school.store' , 'files' => true]) }}
                    <div class="container-fluid">
                        <div class="form-group">
                            <label class="col-form-label text-md-right" for="name">Name <b style="color: red;">*</b></label>
                            <input type="text" name="name" class="form-control" required >
                        </div>
                        <div class="form-group">
                            <label class="col-form-label text-md-right" for="name">Email <b style="color: red;">*</b></label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label text-md-right" for="name">Address <b style="color: red;">*</b></label>
                            <input type="text" class="form-control" name="address" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label text-md-right" for="name">Contact Number <b style="color: red;">*</b></label>
                            <input type="text" class="form-control" name="contact_number" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label text-md-right" for="name">Contact Person <b style="color: red;">*</b></label>
                            <input type="text" class="form-control" name="contact_person" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label text-md-right" for="name">Logo <b style="color: red;">*</b></label>
                            <input type="file" accept="image/*" class="form-control-file" name="logo" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i></button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="licenseAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title" id="myModalLabel">Update License</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                {{ Form::open(['route' => 'school.license.update' , 'files' => true]) }}
                    <div class="container-fluid">
                        <div class="form-group">
                            <label class="col-form-label text-md-right" for="name">License <b style="color: red;">*</b></label>
                            <input type="hidden" id="id" name="school_id">
                            <input type="hidden" id="school_license_id" name="school_license_id">
                            <select class="form-control" name="licens_id" id="license_id">
                                @foreach($licenses as $li)
                                    <option value="{{ $li->id }}">{{ $li->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i></button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
@section('customScript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#licenseAdd').on('show.bs.modal', function(e) {
                var  school_id= $(e.relatedTarget).data('id');
                var  school_licens_id= $(e.relatedTarget).data('license');
                var license_id = $(e.relatedTarget).data('li');

                $("#id").val(school_id);
                $("#school_license_id").val(school_licens_id);
                $("#license_id").val(license_id);
            });
        });
    </script>
@endsection