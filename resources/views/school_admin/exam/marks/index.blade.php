@extends('layouts.school_admin')

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
            <form method="get" action="{{ route('marks.manage.create') }}">
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
                    <select class="form-check-inline col-md-12 select2" name="class_id" onchange="getClassSections(this.value);getClassSubject(this.value);">
                        <option>Please Select Class</option>
                        @foreach($classes as $row)
                            <option value="{{ $row->id }}" {{ ($row->id == @$class->id) ? 'selected' : '' }}>{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Section</label>
                    <select class="form-check-inline col-md-12 select2" name="section_id" id="section_holder">
                        <option>Please Select Class First</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Subject</label>
                    <select class="form-check-inline col-md-12 select2" name="subject_id" id="subject_holder">
                        <option>Please Select Class First</option>
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
                <h3>Marks For {{ $exam->name }}</h3>
                Class : {{ $class->name }} {{ $section->name }}<br />
                Subject : {{ $subject->name }}<br />
                Subject Type : {{ $subject->type }}
            </div>
            <div class="card-body table-responsive">
                @if($subject->mark_optional == 1)
                {{ Form::open(['route' => 'marks.manage.update' , 'files' => true]) }}
                    <input type="hidden" name="school_id" value="{{ $school->id }}">
                    <input type="hidden" name="class_id" value="{{ $class->id }}">
                    <input type="hidden" name="section_id" value="{{ $section->id }}">
                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                    <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                    <table class="table table-bordered">
                        <thead>
                            <th>Roll Number</th>
                            <th>Name</th>
                            <th>Marks Obtained</th>
                        </thead>
                        <tbody>
                            @foreach($marks as $mark)
                                <tr>
                                    <td>{{ @$mark->student->enroll->roll_number }}</td>
                                    <td>
                                        <input type="hidden" name="student_ids[]" value="{{ @$mark->student_id }}">
                                        {{ @$mark->student->user->name }}
                                    </td>
                                    <td>
                                        @if(@$mark->subject->type == 'is_none')
                                            <input class="form-control" type="number" value="{{ @$mark->marks_obtained }}" name="marks_obtained[]">
                                        @else
                                            <div class="form-group">
                                                <label class="col-form-label">Theory Mark</label>
                                                <input class="form-control" type="number" value="{{ @$mark->marks_obtained_theory }}" name="marks_obtained_theory[]">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Practical Mark</label>
                                                <input class="form-control" type="number" value="{{ @$mark->marks_obtained_practical }}" name="marks_obtained_practical[]">
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br/>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-rounded btn-outline-primary">Save Changes</button>
                    </div>
                {{ Form::close() }}
                @endif
            </div>
        </div>
    @endif
@endsection
@section('customScript')
    <script>
        function getClassSections(class_id) {
            if (class_id !== '') {
                $.ajax({
                    url: '{{ url('/school/dashboard/class/sections') }}'+'/'+ class_id ,
                    success: function(response)
                    {
                        jQuery('#section_holder').html(response);
                    }
                });
            }
        }

        function getClassSubject(class_id) {
            if (class_id !== '') {
                $.ajax({
                    url: '{{ url('/school/dashboard/class/subjects') }}'+'/'+ class_id ,
                    success: function(response)
                    {
                        jQuery('#subject_holder').html(response);
                    }
                });
            }
        }
    </script>
@endsection