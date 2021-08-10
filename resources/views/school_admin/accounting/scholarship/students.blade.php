@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Manage {{ $page }}</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Accounting</a></li>
                    <li class="breadcrumb-item" aria-current="page">{{ $page }}</li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $scholarship->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped" width="100%" id="datable1">
                <thead>
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Options</th>
                </thead>
                <tbody>
                    @php $n = 0 @endphp
                    @foreach($students as $row)
                        <tr>
                            <td>{{ ++$n }}</td>
                            <td>{{ $row->user->name }}</td>
                            <td>{{ $row->enroll->class->name }} ({{ $row->enroll->section->name }})</td>
                            <td><a class="btn btn-link" href="{{ route('scholarship.remove.student', $row->id) }}"><i class="fas fa-trash"></i> Remove</a> </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('customScript')
    @include('school_admin.partials.datatable')
    <script>
        $('#datable1').dataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            'order'       : [[0,"desc"]],
            'buttons'     : ['excel', 'pdf'],
            "lengthMenu": [[20, 30, 40, 50, 100, -1], [20, 30, 40, 50, 100, "All"]],
            dom: 'lfBrtip'
        });
    </script>
@endsection