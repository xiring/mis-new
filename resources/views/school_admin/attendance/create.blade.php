@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Manage {{ $page }}</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Attendance</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
            <form method="get" action="{{ route('attendance.create') }}">
                <div class="form-group">
                    <label class="col-form-label">Choose Class</label>
                    <select class="form-check-inline col-md-12 select2" name="class_id" onchange="getClassSections(this.value);">
                        <option>Please Select Class</option>
                        @foreach($classes as $row)
                            <option value="{{ $row->id }}" {{ ($row->id == @$class->id) ? 'selected' : '' }}>{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Choose Section</label>
                    <select class="form-check-inline col-md-12 select2" name="section_id" id="section_holder" onchange="getSectionRoutine(this.value);">
                        <option>Please Select Class First</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Choose Class Routine</label>
                    <select class="form-check-inline col-md-12 select2" name="class_routine_id" id="routine_holder">
                        <option>Please Select Section First</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Date</label>
                    <input type="date" class="form-control" name="date" value="{{ \Carbon\Carbon::now()->parse()->format('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-rounded btn-outline-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    @if($enrolls)
        <div class="card">
            <div class="card-body table-responsive">
                <div class="card-header text-center">
                    <h3>Attendance Of Class {{ $class->name }}</h3>
                    Section {{ $section->name }}<br />
                    {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                </div>
            </div>
            <center>
                <a class="btn btn-xs btn-rounded btn-outline-primary" onclick="mark_all_present()">
                    <i class="fas fa-check"></i>Mark All Present
                </a>
                <a class="btn btn-xs btn-rounded btn-outline-danger"  onclick="mark_all_absent()">
                    <i class="fas fa-times"></i>Mark All Absent
                </a>
            </center>
            {{ Form::open(['route' => 'attendance.store' , 'files' => true]) }}
            <div class="card-body">
                <input type="hidden" name="class_id" value="{{ $class->id }}">
                <input type="hidden" name="section_id" value="{{ $section->id }}">
                <input type="hidden" name="class_routine_id" value="{{ $class_routine_id }}">
                <input type="hidden" name="date" value="{{ $date }}">
                <table class="table table-bordered">
                    <thead>
                    <th>Roll Number</th>
                    <th>Name</th>
                    <th>Status</th>
                    </thead>
                    <tbody>
                    @php $count = 0; @endphp   
                    @foreach($enrolls as $enroll)
                        <tr>
                            <td>{{ $enroll->roll_number }}</td>
                            <td><input type="hidden" name="student_ids[]" value="{{ $enroll->student->id }}">{{ $enroll->student->user->name }}</td>
                            <td>
                                <select class="form-control" name="status[]" id="status_{{ $count++ }}">
                                    <option value="2">Undefined</option>
                                    <option value="1">Present</option>
                                    <option value="0">Absent</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <br />
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-rounded btn-outline-success">Save</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    @endif

    @if($attendances)
        <div class="card">
            <div class="card-header text-center">
                <h3>Attendance Of Class {{ $class->name }}</h3>
                Section {{ $section->name }}<br />
                {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
            </div>
            <div class="card-body table-responsive">
                {{ Form::open(['route' => 'attendance.update' , 'files' => true]) }}
                    <input type="hidden" name="class_id" value="{{ $class->id }}">
                    <input type="hidden" name="section_id" value="{{ $section->id }}">
                    <input type="hidden" name="class_routine_id" value="{{ $attendances[0]->class_routine_id }}">
                    <input type="hidden" name="date" value="{{ $date }}">
                    <table class="table table-bordered">
                        <thead>
                        <th>Roll Number</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Change Status</th>
                        </thead>
                        <tbody>
                        @foreach($attendances as $attend)
                            <tr>
                                <td>{{ $attend->student->enroll->roll_number }}</td>
                                <td><input type="hidden" name="student_ids[]" value="{{ $attend->student_id }}">{{ $attend->student->user->name }}</td>
                                <td>
                                    @if($attend->status == '1')
                                        Present
                                    @elseif($attend->status == '2')
                                        N/a
                                    @else
                                        Absent
                                    @endif
                                </td>
                                <td>
                                    <select class="form-control test" name="status[]">
                                        <option value="2" {{ ($attend->status == 2) ? 'selected' : '' }}>Undefined</option>
                                        <option value="1" {{ ($attend->status == 1) ? 'selected' : '' }}>Present</option>
                                        <option value="0" {{ ($attend->status == 0) ? 'selected' : '' }}>Absent</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <br />
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-rounded btn-outline-success">Update</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    @endif
@endsection

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

    function getSectionRoutine(section_id) {
        if (section_id !== '') {
            $.ajax({
                url: '{{ url('/school/dashboard/class/section/routine') }}'+'/'+ section_id ,
                success: function(response)
                {
                    jQuery('#routine_holder').html(response);
                }
            });
        }
    }
</script>
@section('customScript')
    @include('school_admin.partials.datatable')
    <script type="text/javascript">


        function mark_all_present() {
           var count = {{ count($enrolls) }};

            for(var i = 0; i < count; i++)
                $('#status_' + i).val("1");
        }

        function mark_all_absent() {
           var count = {{ count($enrolls) }};

            for(var i = 0; i < count; i++)
                $('#status_' + i).val("0");
        }

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
                buttons: [
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'colvis'
                ],
                columnDefs: [ {
                    targets: -1,
                    visible: false
                } ]
            });
        });

    </script>
@endsection