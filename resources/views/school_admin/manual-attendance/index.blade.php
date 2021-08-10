@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">{{ $page }}</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Manual</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
            <form method="get" action="{{ route('manual.attendace.index') }}">
                <div class="form-group">
                    <label class="col-form-label">Exam</label>
                    <input type="hidden" name="school_id" value="{{ $school->id }}">
                    <select class="form-check-inline col-md-12 select2" name="exam_id">
                        <option>Please Select Exam</option>
                        @foreach($exams as $row)
                            <option value="{{ $row->id }}" {{ ($row->id == @$exam->id) ? 'selected' : '' }}>{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Class</label>
                    <select class="form-check-inline col-md-12 select2" name="class_id" onchange="getClassSections(this.value);">
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
                    <button type="submit" class="btn btn-rounded btn-outline-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    @if(count($enrolls)> 0)
        <div class="card">
            <div class="card-header text-center">
                <h3>Attendance For {{ $exam->name }}</h3>
                Class : {{ $class->name }} - {{ $section->name }}
            </div>
            <div class="card-body table-responsive">
                @if(count($atteds) > 0)
                    {{ Form::open(['route' => 'manual.attendace.update' , 'files' => true]) }}
                @else
                    {{ Form::open(['route' => 'manual.attendace.store' , 'files' => true]) }}
                @endif
                    <div class="form-group">

                        <label class="col-form-label">Total School Days</label>
                        @if($atteds)
                            @php
                                $values = App\Models\ManualAttentace::where('exam_id', $exam->id)->where('class_id', $class->id)->where('year', $school->detail->running_session)->where('section_id', $section->id)->whereIn('student_id', $enrolls->pluck('id'))->get();
                            @endphp
                            <input class="form-control" type="number" value="{{ @$values[0]->total_days }}" min="1" required name="total_days">
                        @else
                            <input class="form-control" type="number" min="1" required name="total_days">
                        @endif
                    </div>
                    <input type="hidden" name="school_id" value="{{ $school->id }}">
                    <input type="hidden" name="class_id" value="{{ $class->id }}">
                    <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                    <input type="hidden" name="section_id" value="{{ $section->id }}">
                    <table class="table table-bordered">
                        <thead>
                            <th>Roll Number</th>
                            <th>Name</th>
                            <th>Number Of Days</th>
                        </thead>
                        <tbody>
                            @foreach($enrolls as $enroll)
                                <tr>
                                    <td>{{ $enroll->roll_number }}</td>
                                    <td>{{ $enroll->student->user->name }}<input type="hidden" name="student_ids[]" value="{{ $enroll->student->id }}"></td>
                                    <td>
                                        @if($atteds)
                                            @php
                                                $value = App\Models\ManualAttentace::where('exam_id', $exam->id)->where('class_id', $class->id)->where('year', $school->detail->running_session)->where('section_id', $section->id)->where('student_id', $enroll->student->id)->first();
                                            @endphp
                                            <input class="form-control" type="number" min="0" value="{{ @$value->number_of_days }}" required name="number_of_days[]">
                                        @else
                                            <input class="form-control" type="number" min="0" required name="number_of_days[]">
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br />
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-rounded btn-outline-primary">Save Changes</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    @endif
@endsection
@section('customScript')
<script type="text/javascript">
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
</script>
@endsection
