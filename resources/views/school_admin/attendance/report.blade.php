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
            <form method="get" action="{{ route('attendance.report') }}">
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
                    <label class="col-form-label">Date</label>
                    <input type="date" class="form-control" name="date" value="{{ @$date }}" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-rounded btn-outline-primary">Submit</button>
                </div>
            </form>
            @if(count(@$attendances) > 0)
                <br />
                <table class="table table-striped" width="100%" id="datatable">
                    <thead>
                        <th>S.N</th>
                        <th>Date</th>
                        <th>Class</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        @php $n = 0 @endphp
                        @foreach($attendances->unique('date') as $row)
                            <tr>
                                <td>{{ ++$n }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
                                <td>{{ $row->classW->name }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-rounded btn-outline-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Options
                                        </a>
                                        @php 
                                            $class_sections = @App\Models\ClassSection::where('class_id', $row->class_id)->where('is_active', 1)->get(); 
                                        @endphp
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @foreach($class_sections as $section)
                                                <a target="_blank" href="{{ url('/school/dashboard/attendance/view/'.$row->class_id.'/'.$section->id.'/'. \Carbon\Carbon::parse($row->date)->format('Y-m-d')) }}" class="dropdown-item">Edit {{ $section->name }}</a>
                                                 <a target="_blank" href="{{ url('/school/dashboard/attendance/report-view/'.$row->class_id.'/'.$section->id.'/'. \Carbon\Carbon::parse($row->date)->format('Y-m-d')) }}" class="dropdown-item">View {{ $section->name }}</a>
                                            @endforeach    
                                        </div>
                                    </div>
                                </td>
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
@endsection
