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
            <form method="get" action="{{ route('marks.print') }}">
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
    @if($marks)
        <div class="card">
            <div class="card-header text-center">
                <h3>Mark Sheet</h3>
                Class : {{ $class->name }} {{ $exam->name }}
            </div>
            <div class="card-body table-responsive">
                <form method="post" action="{{ route('marks.print.all') }}">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $class->id }}">
                    <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                    <div class="form-group">
                        <button type="submit" class="btn btn-rounded btn-outline-primary">Print Selected</button>
                    </div>
                    <table class="table table-striped" id="datatable" width="100%">
                        <thead>
                            <td><input type="checkbox" id="checkAll" > Select All</td>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Options</th>
                        </thead>
                        <tbody>
                            @php $n = 0 @endphp
                            @foreach($marks->unique('student_id') as $row)
                                <tr>
                                    <td><input type="checkbox" class="form-conrole" name="studentids[]" value="{{ $row->student_id }}"></td>
                                    <td>{{ ++$n }}</td>
                                    <td>{{ $row->student->user->name }}</td>
                                    <td>
                                        <a href="{{ url('school/dashboard/mark/sheet/view/'.$row->exam_id.'/'.$row->class_id.'/'.$row->student_id) }}" class="btn btn-primary btn-sm btn-rounded" target="_blank"><i class="fas fa-eye"></i> Mark Sheet</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    @endif
@endsection
@section('customScript')
    @include('school_admin.partials.datatable')
    @section('customScript')
    <script type="text/javascript">
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection
@endsection