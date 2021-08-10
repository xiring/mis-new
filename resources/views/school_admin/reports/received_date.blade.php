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
                    <li class="breadcrumb-item active" aria-current="page">Invoice {{ $page }} : {{ \Carbon\Carbon::parse(@$from)->format('Y/m/d') }} - {{ \Carbon\Carbon::parse(@$to)->format('Y/m/d') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <form method="get" action="{{ route('report.payment.received.date') }}">
                <div class="form-group">
                    <label class="col-form-label">From</label>
                    <input type="date" class="form-control" name="from" value="{{ \Carbon\Carbon::parse(@$from)->format('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label class="col-form-label">To</label>
                    <input type="date" class="form-control" name="to" value="{{ \Carbon\Carbon::parse(@$to)->format('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-rounded btn-outline-primary">Submit</button>
                </div>
            </form>
            @if($invoices)
                <br />
                <table class="table table-striped" width="100%" id="datatable">
                    <thead>
                    <th>S.N</th>
                    <th>Invoice Id</th>
                    <th>Student</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                    </thead>
                    <tbody>
                    @php
                        $n = 0;
                        $amount = array();
                    @endphp
                    @foreach($invoices as $row)
                        @if($row->amount_paid > 0)
                            <tr>
                                <td>{{ ++$n }}</td>
                                <td>#inv-id-{{ str_pad($row->id,6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $row->student->user->name }}</td>
                                <td>
                                    {{ $row->amount_paid }}
                                    @php array_push($amount,  $row->amount_paid) @endphp
                                </td>
                                <td>{{ \Carbon\Carbon::parse($row->updated_at)->format('d M, Y') }}</td>
                                <td>
                                    <?=($row->status == 0)?
                                        '<span class="badge badge-danger">Un-paid</span>'
                                        :
                                        '<span class="badge badge-success">Paid</span>'
                                    ;?>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                    <br />
                    <div class="card">
                        <div class="card-body bg-info-light">
                            <div class="d-inline-block">
                                <h5 class="text">Total</h5>
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
