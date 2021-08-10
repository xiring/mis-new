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
                    <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <form method="get" action="{{ route('report.particular') }}">
                <div class="form-group">
                    <label class="col-form-label">Fee Category</label>
                    <select class="form-control select2" name="fee_category_id[]" multiple>
                        <option></option>
                        @foreach($fee_categories as $row)
                            <option value="{{ $row->id }}">{{ $row->name }} - {{ $row->class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-rounded btn-outline-primary">Submit</button>
                </div>
            </form>
            <br />
            @if($invoice_items)
                <table class="table table-striped" width="100%" id="datatable">
                    <thead>
                        <th>S.N</th>
                        <th>Invoice Id</th>
                        <th>Class</th>
                        <th>Student</th>
                        <th>Particular</th>
                        <th>Number Of Month</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </thead>
                    <tbody>
                        @php
                            $n = 0;
                            $amount = array();
                        @endphp
                        @foreach($invoice_items as $row)
                            <tr>
                                <td>{{ ++$n }}</td>
                                <td>#inv-id-{{ str_pad($row->invoice->id,6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $row->invoice->student->enroll->class->name }}</td>
                                <td>{{ $row->invoice->student->user->name }}</td>
                                <td>{{ $row->fee->name }}</td>
                                <td>
                                    @if($row->is_half == 1)
                                        {{ $row->quantity }}x{{ $row->halfFee->half_amount }}
                                    @else
                                        {{ $row->quantity }}x{{ $row->fee->amount }}
                                    @endif
                                </td>
                                <td>
                                    @if($row->is_half == 1)
                                        {{ $row->quantity * $row->halfFee->half_amount }}
                                        @php array_push($amount,  $row->quantity * $row->halfFee->half_amount) @endphp
                                    @else
                                        {{ $row->quantity * $row->fee->amount }}
                                        @php array_push($amount,  $row->quantity * $row->fee->amount) @endphp
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($row->invoice->invoice_date)->format('d M, Y') }}</td>
                            </tr>
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