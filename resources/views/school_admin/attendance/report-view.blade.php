@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Manage {{ $page }}</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Attendance</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page }} of {{ $date }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered" width="100%" id="report-tbale">
                <thead>
                    <th>Roll Number</th>
                    <th>Student</th>
                    <th>Status</th>
                </thead>
                <tbody>
                    @foreach($attendances as $row)
                        <tr>
                            <td>{{ $row->student->enroll->roll_number }}</td>
                            <td>{{ $row->student->user->name }}</td>
                            <td>
                                @if($row->status == 1)
                                    Present
                                @elseif($row->status == 2)
                                    Absent
                                @else
                                    Undefined
                                @endif        
                            </td>
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
    $(function () {
        $('#report-tbale').dataTable({
            'paging'      : false,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : false,
            'autoWidth'   : true,
            'order'       : [[0,"asc"]],
            'buttons'     : ['excel', 'pdf', 'print'],
            "lengthMenu": [[10, 20, 30, 40, 50, 100, -1], [10, 20, 30, 40, 50, 100, "All"]],
            dom: 'lfBrtip'
        });

    });
</script>
@endsection    