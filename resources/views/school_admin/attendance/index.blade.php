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
        <div class="card-header">
            <a href="{{ route('attendance.form') }}" target="_blank" class="btn btn-sm btn-rounded btn-primary-link"><i class="fas fa-plus-square"></i> Add</a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped" width="100%" id="datatable">
                <thead>
                    <th>S.N</th>
                    <th>Date</th>
                    <th>Class</th>
                    <th>Options</th>
                </thead>
                <tbody>
                    @php $n = 0 @endphp
                    @foreach($attendance->unique('class_id') as $row)
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
                                            <a target="_blank" href="{{ url('/school/dashboard/attendance/view/'.$row->class_id.'/'.$section->id.'/'. \Carbon\Carbon::parse($row->date)->format('Y-m-d')) }}" class="dropdown-item">View {{ $section->name }}</a>
                                        @endforeach    
                                    </div>
                                </div>
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
@endsection
