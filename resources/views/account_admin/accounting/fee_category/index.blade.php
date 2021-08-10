@extends('layouts.account_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Manage {{ $page }}</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Accounting</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <a href="" class="btn btn-sm btn-rounded btn-primary-link" data-toggle="modal" data-target="#addCat"><i class="fas fa-plus-square"></i> Add New Fee Category</a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped" width="100%" id="datatable">
                <thead>
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Amount</th>
                    <th>Half</th>
                    <th>Status</th>
                    <th>Options</th>
                </thead>
                <tbody>
                    @php $n = 0 @endphp
                    @foreach($categories as $row)
                        <tr>
                            <td>{{ ++$n }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->class->name }}</td>
                            <td>{{ $row->amount }}</td>
                            <td>
                                {{ ($row->half_amount) ? $row->half_amount : '-' }}
                            </td>
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
                                            <a href="" data-toggle="modal" data-target="#editCat" data-id="{{ $row->id }}" data-class="{{ $row->class_id }}" data-name="{{ $row->name }}" data-amount="{{ $row->amount }}" data-has="{{ $row->has_half_amount }}" data-hm="{{ $row->half_amount }}" class="dropdown-item">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('accountant.fee.delete', $row->id) }}" class="dropdown-item">Delete</a>
                                        @else
                                            <a href="{{ route('accountant.fee.restore', $row->id) }}" class="dropdown-item">Restore</a>
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

    <div class="modal fade" id="addCat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Fee Category</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'accountant.fee.store' , 'files' => true]) }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label">Class</label>
                            <input type="hidden" name="school_id" value="{{ Session::get('school_id')  }}">
                            <select class="form-control" name="class_id">
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Name</label>
                            <input type="text" class="form-control" name="name" required autofocus>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Amount</label>
                            <input type="number" class="form-control" name="amount" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Amount</label>
                            <input type="number" class="form-control" name="amount" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Has Half Amount</label>
                            <select class="form-control" name="has_half_amount" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
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

    <div class="modal fade" id="editCat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Fee Category : <span id="fee_name"></span></h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'accountant.fee.update' , 'files' => true]) }}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Class</label>
                        <input id="id" name="id" type="hidden">
                        <select class="form-control" name="class_id" id="class_id">
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required autofocus>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Has Half Amount</label>
                        <select class="form-control" name="has_half_amount" id="has_half_amount" required>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Half Amount</label>
                        <input type="number" class="form-control" id="half_amount" name="half_amount">
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

            $('#editCat').on('show.bs.modal', function(e) {
                var  id= $(e.relatedTarget).data('id');
                var  name= $(e.relatedTarget).data('name');
                var class_id = $(e.relatedTarget).data('class');
                var amount  = $(e.relatedTarget).data('amount');
                var has_half_amount  = $(e.relatedTarget).data('has');
                var half_amount  = $(e.relatedTarget).data('hm');

                $("#id").val(id);
                $("#fee_name").html(name);
                $("#name").val(name);
                $("#class_id").val(class_id);
                $("#amount").val(amount);
                $("#has_half_amount").val(has_half_amount);
                $("#half_amount").val(half_amount);
            });
        });

    </script>
@endsection
