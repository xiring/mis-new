@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Report of {{ $page }} Invoices</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Accounting</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page }} Invoices Of {{ @$class->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <form method="get" action="{{ route('report.due.class') }}">
                <div class="form-group">
                    <label class="col-form-label">Choose Class</label>
                    <select class="form-check-inline col-md-12 select2" name="class_id">
                        <option>Please Select Class</option>
                        @foreach($classes as $row)
                            <option value="{{ $row->id }}" {{ ($row->id == @$class->id) ? 'selected' : '' }}>{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-rounded btn-outline-primary">Submit</button>
                </div>
            </form>
            @if($invoices)
                <br/>
                <div class="card">
                    <div class="card-body bg-danger">
                        <div class="d-inline-block">
                            <h5 class="text">Total Due</h5>
                            <h2 class="mb-0"> {{ array_sum($total)  }}</h2>
                        </div>
                        <div class="float-right icon-circle-medium  icon-box-lg mt-1">
                            <i class="fa fa-money-bill-alt fa-fw fa-sm text-info"></i>
                        </div>
                    </div>
                </div>
                <br />

                <table class="table table-striped" width="100%" id="datatable">
                <thead>
                    <th>S.N</th>
                    <th>Invoice Id</th>
                    <th>Student</th>
                    <th>Total</th>
                    <th>Amount Paid</th>
                    <th>Date</th>
                    <th>Options</th>
                    </thead>
                <tbody>
                    @php $n = 0 @endphp
                    @foreach($invoices as $row)
                        <tr>
                            <td>{{ ++$n }}</td>
                            <td>#inv-id-{{ str_pad($row->id,6, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $row->student->user->name }}</td>
                            <td>{{ $row->amount }}</td>
                            <td>{{ $row->amount_paid }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->invoice_date)->format('d M, Y') }}</td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-rounded btn-outline-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Options
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a href="{{ route('invoice.view', $row->id) }}" class="dropdown-item">View Invoice</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="" data-toggle="modal" data-target="#takePayment" data-id="{{ $row->id }}" data-amount="{{ $row->amount }}" data-paid="{{ $row->amount_paid }}" data-due="{{ $row->due }}" class="dropdown-item">Take Payment</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ route('invoice.delete', $row->id) }}" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    <div class="modal fade" id="takePayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Take Payment: <span id="invoice_id_head"></span></h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'invoice.take.payment' , 'files' => true]) }}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Total Amount</label>
                        <input type="hidden" name="id" id="id">
                        <input type="number" class="form-control" id="amount" disabled>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Amount Paid</label>
                        <input type="number" class="form-control" id="amount_paid" disabled>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Due</label>
                        <input type="number" class="form-control" id="due" disabled>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Payment</label>
                        <input type="number" class="form-control" name="amount" placeholder="Enter Payment Amount" required autofocus>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Date</label>
                        <input type="date" class="form-control" name="payment_date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-rounded btn-outline-primary">Take Payment</button>
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

            $('#takePayment').on('show.bs.modal', function(e) {
                var  id= $(e.relatedTarget).data('id');
                var  amount= $(e.relatedTarget).data('amount');
                var paid  = $(e.relatedTarget).data('paid');
                var due  = $(e.relatedTarget).data('due');

                $("#id").val(id);
                $("#invoice_id_head").html(id);
                $("#amount").val(amount);
                $("#amount_paid").val(paid);
                $("#due").val(due);
            });
        });

    </script>
@endsection