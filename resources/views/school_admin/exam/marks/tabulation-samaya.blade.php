@extends('layouts.school_admin')
@php
    $grades = App\Models\ExamGrade::where('school_id', Auth::user()->school->id)->get();
@endphp
@include('school_admin.grade')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">{{ $page }}</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Exam</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
            <form method="get" action="{{ route('marks.tabulation.sheet') }}">
                <div class="form-group">
                    <label class="col-form-label">Exam</label>
                    <input type="hidden" name="school_id" value="{{ Auth::user()->school->id }}">
                    <select class="form-check-inline col-md-12 select2" name="exam_id">
                        <option>Please Select Exam</option>
                        @foreach($exams as $row)
                            <option value="{{ $row->id }}" {{ ($row->id == @$exam->id) ? 'selected' : '' }}>{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Class</label>
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
        </div>
    </div>
    @if($students)
        <div class="card">
            <div class="card-header text-center">
                <h3>Tabulation Sheet of {{ $exam->name }}</h3>
                Class : {{ $class->name }}
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped" id="datatable1" width="100%">
                    <thead>
                        <th>Roll Number</th>
                        <th>Name</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->enroll->roll_number }} </td>
                                <td>{{ $student->user->name }} ({{ $student->enroll->section->name }})</td>
                                <td>
                                    <a href="" data-toggle="modal" data-target="#view{{ $student->id }}" class="btn btn-rounded btn-outline-primary">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @foreach($students as $student)
            <div class="modal fade" id="view{{ $student->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">View / Update Marks</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered table-striped" width="100%">
                                <thead>
                                    <th>Subject</th>
                                    <th>Marks</th>
                                </thead>
                                <tbody>
                                    @php
                                        $datas = App\Models\ExamMark::where('school_id', $school->id)->where('year', $school->detail->running_session)->where('class_id', $class->id)->Where('exam_id', $exam->id)->where('student_id', $student->id)->get();
                                        $total = 0;
                                    @endphp
                                    @foreach($datas as $data)
                                        <tr>
                                            <td>{{ $data->subject->name }}</td>
                                            <td>
                                                <input type="hidden" name="mark_ids[]" value="{{ $data->id }}">
                                                @if($data->subject->type == 'is_none')
                                                    <input type="text" disabled="disabled" name="mark_obtained[]" value="{{ $data->marks_obtained }}" class="form-control" required> 
                                                    @php $total += $data->marks_obtained @endphp
                                                @else
                                                    <div class="form-group">
                                                        <label class="col-form-label">Theory Mark</label>
                                                        <input class="form-control" disabled="disabled" type="number" value="{{ $data->marks_obtained_theory }}" name="marks_obtained_theory[]">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label">Practical Mark</label>
                                                        <input class="form-control" disabled="disabled" type="number" value="{{ $data->marks_obtained_practical }}" name="marks_obtained_practical[]">
                                                    </div>
                                                    @php
                                                        $mark_total = $data->marks_obtained_theory + $data->marks_obtained_practical;
                                                        $total += $mark_total;
                                                    @endphp
                                                @endif    
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th>Total</th>
                                        <td>{{ $total }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
@section('customScript')
    @include('school_admin.partials.datatable')
    <script type="text/javascript">
        $('#datatable1').dataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            'order'       : [[0,"desc"]],
            "lengthMenu": [[10, 20, 30, 40, 50, 100, -1], [10, 20, 30, 40, 50, 100, "All"]],
            dom: 'lfrtip'
        });
    </script>
@endsection