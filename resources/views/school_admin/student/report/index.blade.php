@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">{{ $page }}</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="#" class="breadcrumb-link">Student Reports</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
            <form method="get" action="{{ route('student.report.class') }}">
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
            @if($enrolls)
                <br />
                <table class="table table-striped" width="100%" id="datatable123">
                    <thead>
                        <th>S.N</th>
                        <th>Student' Name</th>
                        <th>Class</th>
                        <th>Roll No.</th>
                        <th>Section</th>
                        <th>Gender</th>
                        <th>DOB</th>
                        <th>Parent's Name</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Date Of Admission</th>
                    </thead>
                    <tbody>
                        @php $n = 0 @endphp
                        @foreach($enrolls as $enroll)
                            <tr>
                                <td>{{ ++$n }}</td>
                                <td>{{ $enroll->student->user->name }}</td>
                                <td>{{ $enroll->class->name }}</td>
                                <td>{{ $enroll->roll_number }}</td>
                                <td>{{ $enroll->section->name }}</td>
                                <td>{{ $enroll->student->gender }}</td>
                                <td>{{ $enroll->student->dob_nepali }}</td>
                                <td>{{ $enroll->student->parent->user->name }}</td>
                                <td>{{ $enroll->student->parent->phone }}</td>
                                <td>{{ $enroll->student->parent->address }}</td>
                                <td>{{ Carbon\Carbon::parse($enroll->created_at)->format('Y-m-d') }}</td>
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
    <script>
    $(function () {
        $('#datatable123').dataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            'order'       : [[0,"asc"]],
            'buttons'     : ['excel', 'pdf'],
            "lengthMenu": [[30, 40, 50, 100, -1], [30, 40, 50, 100, "All"]],
            dom: 'lfBrtip'
        });

    });
</script>

@endsection
