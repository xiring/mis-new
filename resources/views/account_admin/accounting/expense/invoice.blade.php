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
            <a href="" class="btn btn-sm btn-rounded btn-primary-link" data-toggle="modal" data-target="#addExpenseInv"><i class="fas fa-plus-square"></i> Add New Expense Invoice</a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped" width="100%" id="datatable">
                <thead>
                    <th>S.N</th>
                    <th>Invoice Id</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Options</th>
                </thead>
                <tbody>
                @php $n = 0 @endphp
                @foreach($invoices as $row)
                    <tr>
                        <td>{{ ++$n }}</td>
                        <td>#inv-id-{{ str_pad($row->id,5, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $row->title }}</td>
                        <td>{{ $row->category->name }}</td>
                        <td>{{ $row->amount }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
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
                                        <a href="" data-toggle="modal" data-target="#editExpenseInv" data-id="{{ $row->id }}" data-title="{{ $row->title }}" data-description="{{ $row->description }}" data-cat="{{ $row->expense_category_id }}" data-amount="{{ $row->amount }}" data-date="{{ \Carbon\Carbon::parse($row->date)->format('Y-m-d') }}" class="dropdown-item">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ route('accountant.expense.invoice.delete', $row->id) }}" class="dropdown-item">Delete</a>
                                    @else
                                        <a href="{{ route('accountant.expense.invoice.restore', $row->id) }}" class="dropdown-item">Restore</a>
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

    <div class="modal fade" id="addExpenseInv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Expense Invoice</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'accountant.expense.invoice.store' , 'files' => true]) }}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Expense Category</label><br />
                        <input type="hidden" name="school_id" value="{{ Session::get('school_id') }}">

                        <select style="width: 100% !important;" class="form-control-lg select2" name="expense_category_id" autofocus>
                            <option></option>
                            @foreach($categories as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Description</label>
                        <input type="text" class="form-control" name="description" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Amount</label>
                        <input type="number" step="any" class="form-control" name="amount" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Date</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-rounded btn-outline-primary">Save</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>


    <div class="modal fade" id="editExpenseInv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Expense Invoice</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'accountant.expense.invoice.update' , 'files' => true]) }}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Expense Category</label>
                        <input type="hidden" name="id" id="id">
                        <select class="form-control" name="expense_category_id" autofocus id="expense_category_id">
                            <option></option>
                            @foreach($categories as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Amount</label>
                        <input type="number" step="any" class="form-control" name="amount" id="amount" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
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

            $('#editExpenseInv').on('show.bs.modal', function(e) {
                var  id= $(e.relatedTarget).data('id');
                var  cat= $(e.relatedTarget).data('cat');
                var date = $(e.relatedTarget).data('date');
                var amount = $(e.relatedTarget).data('amount');
                var title = $(e.relatedTarget).data('title');
                var descrption = $(e.relatedTarget).data('description');

                $("#id").val(id);
                $("#expense_category_id").val(cat);
                $("#date").val(date);
                $("#amount").val(amount);
                $("#title").val(title);
                $("#description").val(descrption);
            });
        });

    </script>
@endsection