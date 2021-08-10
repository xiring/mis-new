@extends('layouts.school_admin')

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
            <table class="table table-striped" width="100%" id="table_summary">
                <thead>
                    <th>Name</th>
                    <th>Detail</th>
                </thead>
                <tbody>
                    @php
                        $n = 0;
                        $amount = array();
                    @endphp
                    @foreach($categories as $row)
                        <tr>
                            <td>{{ $row->name }}</td>
                            <td>
                                @foreach($row->invoices as $inv)
                                    {{ $inv->amount }}
                                    @php array_push($amount, $inv->amount) @endphp
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="1">Total</th>
                        <td>{{ array_sum($amount) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('customScript')
    @include('school_admin.partials.datatable')
    <script type="text/javascript">

        jQuery(document).ready(function($)
        {
            var datatable = $('#table_summary').dataTable({
                'paging'      : false,
                'lengthChange': false,
                'searching'   : false,
                'ordering'    : false,
                'info'        : false,
                'autoWidth'   : true,
                "dom": 'lfrBtip',
                "buttons": ['excel', 'pdf', 'print']
            });
        });

    </script>
@endsection