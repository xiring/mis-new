@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Manage {{ $page }}</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Exam</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <a href="" class="btn btn-sm btn-rounded btn-primary-link" data-toggle="modal" data-target="#addexam"><i class="fas fa-plus-square"></i> Add New Exam</a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped" width="100%" id="datatable">
                    <thead>
                    <th>S.N</th>
                    <th>Exam Name</th>
                    <th>Date</th>
                    <th>Result Date</th>
                    <th>Status</th>
                    <th>Options</th>
                </thead>
                <tbody>
                    @php $n = 0 @endphp
                    @foreach($exams as $row)
                        <tr>
                            <td>{{ ++$n }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->result_date)->format('d/m/Y') }}</td>
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
                                            <a href="" data-toggle="modal" data-target="#editexam" data-id="{{ $row->id }}" data-name="{{ $row->name }}" data-date="{{ \Carbon\Carbon::parse($row->date)->format('Y-m-d') }}" data-result="{{ \Carbon\Carbon::parse($row->result_date)->format('Y-m-d') }}" class="dropdown-item">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('exam.delete', $row->id) }}" class="dropdown-item">Delete</a>
                                        @else
                                            <a href="{{ route('exam.restore', $row->id) }}" class="dropdown-item">Restore</a>
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

    <div class="modal fade" id="addexam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Exam</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'exam.store' , 'files' => true]) }}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Exam Name</label>
                        <input type="hidden" name="school_id" value="{{ Auth::user()->school->id }}">
                        <input type="text" class="form-control" name="name" required autofocus>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Date</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Result Date</label>
                        <input type="date" class="form-control" name="result_date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-rounded btn-outline-primary">Save</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="editexam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Exam : <span id="exam_name"></span></h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'exam.update' , 'files' => true]) }}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Name</label>
                        <input type="hidden" name="id" id="id">
                        <input type="text" class="form-control" id="name" name="name" required autofocus>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date"readonly>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Result Date</label>
                        <input type="date" class="form-control" id="result_date" name="result_date" required>
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

            $('#editexam').on('show.bs.modal', function(e) {
                var  id= $(e.relatedTarget).data('id');
                var  name= $(e.relatedTarget).data('name');
                var date  = $(e.relatedTarget).data('date');
                var result_date  = $(e.relatedTarget).data('result');

                $("#id").val(id);
                $("#exam_name").html(name);
                $("#name").val(name);
                $("#date").val(date);
                $("#result_date").val(result_date);
            });
        });

    </script>
@endsection
