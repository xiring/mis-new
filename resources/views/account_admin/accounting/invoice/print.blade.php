@extends('layouts.account_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">{{ $page }}</h2>
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
        <div class="card-body table-responsive">
            <form method="get" action="{{ route('accountant.invoice.print.bulk') }}">
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
            @if(count(@$invoices) > 0)
                <br />
                <div class="col-md-12">
                    <form method="post" action="{{ route('accountant.invoice.print.bulk.all', $class->id) }}">
                        @csrf
                        <hr />
                        <div class="form-group">
                            <input type="checkbox" id="checkAll" > Check All
                            <br />
                            <b><i style="color: red">Note: Please select at least one invoice before submitting form </i></b>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-rounded btn-outline-primary">Print Selected</button>
                        </div>
                        <hr />
                        <div class="row">
                            @foreach($invoices as $invoice)
                                <div class="card col-md-4" style="background-color: #f0f0f0">
                                    <input type="checkbox" id="checkItem" value="{{ $invoice->id }}" name="invoice_ids[]">
                                    <div class="card-body">
                                        <div class="card-header text-center">
                                            #inv-id-{{ str_pad($invoice->id,6, '0', STR_PAD_LEFT) }}<br />
                                            {{ $invoice->student->user->name }}<br />
                                            {{ $invoice->amount }}<br />
                                            <?=($invoice->status == 0)?
                                                '<span class="badge badge-danger">Un-paid</span>'
                                                :
                                                '<span class="badge badge-success">Paid</span>'
                                            ;?>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('customScript')
    <script type="text/javascript">
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection