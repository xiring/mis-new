@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Report {{ $page }}</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Accounting</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page }} By Date</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped" width="100%" id="datatable">
                <thead>
                <th>S.N</th>
                <th>Invoice Id</th>
                <th>Student</th>
                <th>Class</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Options</th>
                </thead>
                <tbody>
                @php
                    $n = 0;
                    $amount = array();
                @endphp
                @foreach($invoice_items as $row)
                    <tr>
                        <td>{{ ++$n }}</td>
                        <td>#inv-id-{{ str_pad($row->invoice_id,6, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $row->invoice->student->user->name }}</td>
                        <td>{{ $row->invoice->student->enroll->class->name}}</td>
                        <td>
                            @php
                                $mn = App\Models\InvoiceItems::where('invoice_id', $row->invoice_id)->where('fee_category_id', $row->fee_category_id)->first();
                                $amt = $row->invoice->student->scholarship->percentage / 100 * ($mn->quantity * $row->fee->amount)
                            @endphp
                            {{ $amt }}
                            @php array_push($amount, $amt) @endphp
                        </td>
                        <td>{{ \Carbon\Carbon::parse($row->invoice->invoice_date)->format('d M, Y') }}</td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-sm btn-rounded btn-outline-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Options
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a href="{{ route('invoice.view', $row->invoice->id) }}" target="_blank" class="dropdown-item">View Invoice</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <br />
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
        </div>
    </div>
@endsection
@section('customScript')
    @include('school_admin.partials.datatable')
@endsection