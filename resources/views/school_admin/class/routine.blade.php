@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Dashboard</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Class - {{  $class->name }}</a></li>
                    <li class="breadcrumb-item active"><a href="#" class="breadcrumb-link">{{  $page }}s</a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <a href="" class="btn btn-sm btn-rounded btn-primary-link" data-toggle="modal" data-target="#addRoutine"><i class="fas fa-plus-square"></i> Add New Routine </a>
        </div>
        <div class="card-body">
            <div class="card-body table-responsive">
                @foreach($sections as $section)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header text-center"><strong>Class - {{ $section->class->name }} : {{ $section->name }}</strong>&nbsp;&nbsp;<a href="{{ route('routine.print', $section->id) }}"class="btn btn-primary btn-xs" target="_blank"><i class="fas fa-print"></i> Print</a></div>
                               <div class="card-body">
                                   <table cellpadding="0" cellspacing="0" border="0"  class="table table-bordered">
                                       <tbody>
                                           {{-- @foreach($days as $day)--}}
                                                <tr>
                                                    <td width="100">Sunday</td>
                                                    <td>
                                                        @foreach($class_routines->where('section_id', $section->id)->get() as $routine)
                                                            <div class="dropdown">
                                                                <a class="btn btn-primary-link btn-rounded dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    {{ $routine->subject->name }}
                                                                    ({{ $routine->time_start }} : {{ $routine->time_start_min }} {{ $routine->start_am_pm }}- {{ $routine->time_end }} : {{ $routine->time_end_min }} {{ $routine->end_am_pm }})
                                                                    <div class="dropdown-menu">
                                                                        <a href="" data-toggle="modal" data-target="#editRoutine"
                                                                           data-id="{{ $routine->id }}"
                                                                           data-section="{{ $routine->section_id }}"
                                                                           data-subject="{{ $routine->subject->id }}"
                                                                           data-1="{{ $routine->time_start }}"
                                                                           data-2 = "{{ $routine->time_start_min }}"
                                                                           data-3 = "{{ $routine->start_am_pm }}"
                                                                           data-4 = "{{ $routine->time_end }}"
                                                                           data-5 = "{{ $routine->time_end_min }}"
                                                                           data-6 = "{{ $routine->end_am_pm }}"
                                                                           data-day = {{ $routine->day }}
                                                                                   class="dropdown-item">
                                                                            Edit
                                                                        </a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a href="{{ route('routine.delete', $routine->id) }}" class="dropdown-item">Delete</a>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="100">Monday</td>
                                                    <td>
                                                        @foreach($monday_class_routines->where('section_id', $section->id)->get() as $monday)
                                                            <div class="dropdown">
                                                                <a class="btn btn-primary-link btn-rounded dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    {{ $monday->subject->name }}
                                                                    ({{ $monday->time_start }} : {{ $monday->time_start_min }} {{ $monday->start_am_pm }}- {{ $monday->time_end }} : {{ $monday->time_end_min }} {{ $monday->end_am_pm }})
                                                                    <div class="dropdown-menu">
                                                                        <a href="" data-toggle="modal" data-target="#editRoutine"
                                                                           data-id="{{ $monday->id }}"
                                                                           data-section="{{ $monday->section_id }}"
                                                                           data-subject="{{ $monday->subject->id }}"
                                                                           data-1="{{ $monday->time_start }}"
                                                                           data-2 = "{{ $monday->time_start_min }}"
                                                                           data-3 = "{{ $monday->start_am_pm }}"
                                                                           data-4 = "{{ $monday->time_end }}"
                                                                           data-5 = "{{ $monday->time_end_min }}"
                                                                           data-6 = "{{ $monday->end_am_pm }}"
                                                                           data-day = {{ $monday->day }}
                                                                                   class="dropdown-item">
                                                                            Edit
                                                                        </a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a href="{{ route('routine.delete', $monday->id) }}" class="dropdown-item">Delete</a>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="100">Tuesday</td>
                                                    <td>
                                                        @foreach($tuesday_class_routines->where('section_id', $section->id)->get() as $routine)
                                                            <div class="dropdown">
                                                                <a class="btn btn-primary-link btn-rounded dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    {{ $routine->subject->name }}
                                                                    ({{ $routine->time_start }} : {{ $routine->time_start_min }} {{ $routine->start_am_pm }}- {{ $routine->time_end }} : {{ $routine->time_end_min }} {{ $routine->end_am_pm }})
                                                                    <div class="dropdown-menu">
                                                                        <a href="" data-toggle="modal" data-target="#editRoutine"
                                                                           data-id="{{ $routine->id }}"
                                                                           data-section="{{ $routine->section_id }}"
                                                                           data-subject="{{ $routine->subject->id }}"
                                                                           data-1="{{ $routine->time_start }}"
                                                                           data-2 = "{{ $routine->time_start_min }}"
                                                                           data-3 = "{{ $routine->start_am_pm }}"
                                                                           data-4 = "{{ $routine->time_end }}"
                                                                           data-5 = "{{ $routine->time_end_min }}"
                                                                           data-6 = "{{ $routine->end_am_pm }}"
                                                                           data-day = {{ $routine->day }}
                                                                                   class="dropdown-item">
                                                                            Edit
                                                                        </a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a href="{{ route('routine.delete', $routine->id) }}" class="dropdown-item">Delete</a>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="100">Wednesday</td>
                                                    <td>
                                                        @foreach($wed_class_routines->where('section_id', $section->id)->get() as $routine)
                                                            <div class="dropdown">
                                                                <a class="btn btn-primary-link btn-rounded dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    {{ $routine->subject->name }}
                                                                    ({{ $routine->time_start }} : {{ $routine->time_start_min }} {{ $routine->start_am_pm }}- {{ $routine->time_end }} : {{ $routine->time_end_min }} {{ $routine->end_am_pm }})
                                                                    <div class="dropdown-menu">
                                                                        <a href="" data-toggle="modal" data-target="#editRoutine"
                                                                           data-id="{{ $routine->id }}"
                                                                           data-section="{{ $routine->section_id }}"
                                                                           data-subject="{{ $routine->subject->id }}"
                                                                           data-1="{{ $routine->time_start }}"
                                                                           data-2 = "{{ $routine->time_start_min }}"
                                                                           data-3 = "{{ $routine->start_am_pm }}"
                                                                           data-4 = "{{ $routine->time_end }}"
                                                                           data-5 = "{{ $routine->time_end_min }}"
                                                                           data-6 = "{{ $routine->end_am_pm }}"
                                                                           data-day = {{ $routine->day }}
                                                                                   class="dropdown-item">
                                                                            Edit
                                                                        </a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a href="{{ route('routine.delete', $routine->id) }}" class="dropdown-item">Delete</a>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="100">Thursday</td>
                                                    <td>
                                                        @foreach($thu_class_routines->where('section_id', $section->id)->get() as $routine)
                                                            <div class="dropdown">
                                                                <a class="btn btn-primary-link btn-rounded dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    {{ $routine->subject->name }}
                                                                    ({{ $routine->time_start }} : {{ $routine->time_start_min }} {{ $routine->start_am_pm }}- {{ $routine->time_end }} : {{ $routine->time_end_min }} {{ $routine->end_am_pm }})
                                                                    <div class="dropdown-menu">
                                                                        <a href="" data-toggle="modal" data-target="#editRoutine"
                                                                           data-id="{{ $routine->id }}"
                                                                           data-section="{{ $routine->section_id }}"
                                                                           data-subject="{{ $routine->subject->id }}"
                                                                           data-1="{{ $routine->time_start }}"
                                                                           data-2 = "{{ $routine->time_start_min }}"
                                                                           data-3 = "{{ $routine->start_am_pm }}"
                                                                           data-4 = "{{ $routine->time_end }}"
                                                                           data-5 = "{{ $routine->time_end_min }}"
                                                                           data-6 = "{{ $routine->end_am_pm }}"
                                                                           data-day = {{ $routine->day }}
                                                                                   class="dropdown-item">
                                                                            Edit
                                                                        </a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a href="{{ route('routine.delete', $routine->id) }}" class="dropdown-item">Delete</a>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="100">Friday</td>
                                                    <td>
                                                        @foreach($fri_class_routines->where('section_id', $section->id)->get() as $routine)
                                                            <div class="dropdown">
                                                                <a class="btn btn-primary-link btn-rounded dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    {{ $routine->subject->name }}
                                                                    ({{ $routine->time_start }} : {{ $routine->time_start_min }} {{ $routine->start_am_pm }}- {{ $routine->time_end }} : {{ $routine->time_end_min }} {{ $routine->end_am_pm }})
                                                                    <div class="dropdown-menu">
                                                                        <a href="" data-toggle="modal" data-target="#editRoutine"
                                                                           data-id="{{ $routine->id }}"
                                                                           data-section="{{ $routine->section_id }}"
                                                                           data-subject="{{ $routine->subject->id }}"
                                                                           data-1="{{ $routine->time_start }}"
                                                                           data-2 = "{{ $routine->time_start_min }}"
                                                                           data-3 = "{{ $routine->start_am_pm }}"
                                                                           data-4 = "{{ $routine->time_end }}"
                                                                           data-5 = "{{ $routine->time_end_min }}"
                                                                           data-6 = "{{ $routine->end_am_pm }}"
                                                                           data-day = {{ $routine->day }}
                                                                                   class="dropdown-item">
                                                                            Edit
                                                                        </a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a href="{{ route('routine.delete', $routine->id) }}" class="dropdown-item">Delete</a>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                       {{-- @foreach($class_routines->where('section_id', $section->id)->where('day', $day->day)->get() as $routine)
                                                            <div class="dropdown">
                                                                <a class="btn btn-primary-link btn-rounded dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    {{ $routine->subject->name }}
                                                                    ({{ $routine->time_start }} : {{ $routine->time_start_min }} {{ $routine->start_am_pm }}- {{ $routine->time_end }} : {{ $routine->time_end_min }} {{ $routine->end_am_pm }})
                                                                    <div class="dropdown-menu">
                                                                        <a href="" data-toggle="modal" data-target="#editRoutine"
                                                                           data-id="{{ $routine->id }}"
                                                                           data-section="{{ $routine->section_id }}"
                                                                           data-subject="{{ $routine->subject->id }}"
                                                                           data-1="{{ $routine->time_start }}"
                                                                           data-2 = "{{ $routine->time_start_min }}"
                                                                           data-3 = "{{ $routine->start_am_pm }}"
                                                                           data-4 = "{{ $routine->time_end }}"
                                                                           data-5 = "{{ $routine->time_end_min }}"
                                                                           data-6 = "{{ $routine->end_am_pm }}"
                                                                           data-day = {{ $routine->day }}
                                                                                   class="dropdown-item">
                                                                            Edit
                                                                        </a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a href="{{ route('routine.delete', $routine->id) }}" class="dropdown-item">Delete</a>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        @endforeach--}}
                                            {{--@endforeach--}}
                                       </tbody>
                                   </table>
                               </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <div class="modal fade" id="addRoutine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Routine : {{  $class->name }}</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'routine.store' , 'files' => true]) }}
                    <div class="modal-body">
                        <input type="hidden" name="class_id" value="{{ $class->id  }}">
                        <div class="form-group">
                            <label class="col-form-label">Select Section</label>
                            <select class="form-control" name="section_id">
                                @foreach ($sections as $row)
                                    <option value="{{  $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Select Subject</label>
                            <select class="form-control" name="subject_id">
                                @foreach ($subjects as $row)
                                    <option value="{{  $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class=control-label">Day</label>
                            <select name="day" class="form-control">
                                <option value="sunday">sunday</option>
                                <option value="monday">monday</option>
                                <option value="tuesday">tuesday</option>
                                <option value="wednesday">wednesday</option>
                                <option value="thursday">thursday</option>
                                <option value="friday">friday</option>
                                <option value="saturday">saturday</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Stating Time</label>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-check-inline" name="time_start">
                                            <option>Hour</option>
                                            @for($i = 0; $i <= 12 ; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-check-inline" name="time_start_min">
                                            <option>Minutes</option>
                                            @for($i = 0; $i <= 11 ; $i++)
                                                <option value="{{ $i *5 }}">{{ $i *5 }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="start_am_pm" class="form-control-inline">
                                            <option value="am">am</option>
                                            <option value="pm">pm</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Ending Time</label>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-check-inline" name="time_end">
                                            <option>Hour</option>
                                            @for($i = 0; $i <= 12 ; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-check-inline" name="time_end_min">
                                            <option>Minutes</option>
                                            @for($i = 0; $i <= 11 ; $i++)
                                                <option value="{{ $i *5 }}">{{ $i *5 }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="end_am_pm" class="form-control-inline">
                                            <option value="am">am</option>
                                            <option value="pm">pm</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-rounded btn-outline-primary">Save</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="editRoutine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Routine : {{  $class->name }}</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => 'routine.update' , 'files' => true]) }}
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label class="col-form-label">Select Section</label>
                        <select class="form-control" name="section_id" id="section_id">
                            @foreach ($sections as $row)
                                <option value="{{  $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Select Subject</label>
                        <select class="form-control" name="subject_id" id="subject_id">
                            @foreach ($subjects as $row)
                                <option value="{{  $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class=control-label">Day</label>
                        <select name="day" class="form-control" id="day">
                            <option value="sunday">sunday</option>
                            <option value="monday">monday</option>
                            <option value="tuesday">tuesday</option>
                            <option value="wednesday">wednesday</option>
                            <option value="thursday">thursday</option>
                            <option value="friday">friday</option>
                            <option value="saturday">saturday</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Stating Time</label>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-3">
                                    <select class="form-check-inline" name="time_start" id="time_start">
                                        <option>Hour</option>
                                        @for($i = 0; $i <= 12 ; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-check-inline" name="time_start_min" id="time_start_min">
                                        <option>Minutes</option>
                                        @for($i = 0; $i <= 11 ; $i++)
                                            <option value="{{ $i *5 }}">{{ $i *5 }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="start_am_pm" id="start_am_pm" class="form-control-inline">
                                        <option value="am">am</option>
                                        <option value="pm">pm</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Ending Time</label>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-3">
                                    <select class="form-check-inline" name="time_end" id="time_end">
                                        <option>Hour</option>
                                        @for($i = 0; $i <= 12 ; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-check-inline" name="time_end_min" id="time_end_min">
                                        <option>Minutes</option>
                                        @for($i = 0; $i <= 11 ; $i++)
                                            <option value="{{ $i *5 }}">{{ $i *5 }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="end_am_pm" id="end_am_pm" class="form-control-inline">
                                        <option value="am">am</option>
                                        <option value="pm">pm</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-rounded btn-outline-primary">Update</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection
@section('customScript')
    <script>
        $(document).ready(function() {

            $('#editRoutine').on('show.bs.modal', function(e) {
                var  id= $(e.relatedTarget).data('id');
                var  section= $(e.relatedTarget).data('section');
                var subject  = $(e.relatedTarget).data('subject');
                var time_start  = $(e.relatedTarget).data('1');
                var time_start_min  = $(e.relatedTarget).data('2');
                var start_am_pm  = $(e.relatedTarget).data('3');
                var time_end  = $(e.relatedTarget).data('4');
                var time_end_min  = $(e.relatedTarget).data('5');
                var end_am_pm  = $(e.relatedTarget).data('6');
                var day  = $(e.relatedTarget).data('day');

                $("#id").val(id);
                $("#section_id").val(section);
                $("#subject_id").val(subject);
                $("#time_start").val(time_start);
                $("#time_start_min").val(time_start_min);
                $("#start_am_pm").val(start_am_pm);
                $("#time_end").val(time_end);
                $("#time_end_min").val(time_end_min);
                $("#end_am_pm").val(end_am_pm);
                $("#day").val(day);
            });
        });

    </script>
@endsection
