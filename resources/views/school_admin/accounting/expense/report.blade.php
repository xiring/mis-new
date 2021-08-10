@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">{{ $page }}</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Accounting</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page }} : {{ @$category->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <form method="get" action="{{ route('expense.report') }}">
                <div class="form-group">
                    <label class="col-form-label">Choose Expense Category</label>
                    <select class="form-control select2" name="expense_category_id">
                        <option>Please Select Expense Category</option>
                        @foreach($categories as $row)
                            <option value="{{ $row->id }}" {{ ($row->id == @$category->id) ? 'selected' : '' }}>{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-rounded btn-outline-primary">Submit</button>
                </div>
            </form>
            @if($invoices)
                <table class="table table-striped" width="100%" id="datatable">
                    <thead>
                        <th>S.N</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </thead>
                    <tbody>
                        @php $n = 0; $amount = array(); @endphp
                        @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ ++$n }}</td>
                                <td>{{ $invoice->title }}</td>
                                <td>{{ $invoice->category->name }}</td>
                                <td>{{ $invoice->amount }} @php array_push($amount , $invoice->amount) @endphp</td>
                                <td>{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <div class="card">
                        <div class="card-body bg-primary-light">
                            <div class="d-inline-block">
                                <h5 class="text">Total Amount</h5>
                                <h2 class="mb-0"> {{ array_sum($amount)  }}</h2>
                            </div>
                            <div class="float-right icon-circle-medium  icon-box-lg mt-1">
                                <i class="fa fa-money-bill-alt fa-fw fa-sm text-info"></i>
                            </div>
                        </div>
                    </div>
                </table>
            @endif
        </div>
    </div>
@endsection
@section('customScript')
    @include('school_admin.partials.datatable')
@endsection