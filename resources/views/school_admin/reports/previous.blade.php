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
            <form method="get" action="{{ route('report.previous.class') }}">
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
                <br />
                <table class="table table-striped" width="100%" id="datatable">
                    <thead>
                        <th>S.N</th>
                        <th>Invoice Id</th>
                        <th>Student</th>
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
                                <td>{{ \Carbon\Carbon::parse($row->invoice_date)->format('d M, Y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-rounded btn-outline-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Options
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="{{ route('invoice.view', $row->id) }}" target="_parent" class="dropdown-item">View Invoice</a>
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

@endsection
@section('customScript')
    @include('school_admin.partials.datatable')
@endsection