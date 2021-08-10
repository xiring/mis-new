@extends('layouts.school_admin')
@php
    $grades = App\Models\ExamGrade::where('school_id', Auth::user()->school->id)->get();
@endphp

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
            <form method="get" action="{{ route('marks.sheet.print.tabulation') }}">
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
    @if($exam)
        <div class="card">
            <div class="card-header text-center">
                <h3>Tabulation Sheet of {{ $exam->name }}</h3>
                Class : {{ $class->name }}
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped" id="datatable1" width="100%">
                    <thead>
                        <th>Exam</th>
                        <th>Options</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $exam->name }}</td>
                            <td>
                                @foreach ($class->sections as $section)
                                    <a href="{{ url('school/dashboard/tabulation/sheet/print/all/'.$exam->id.'/'.$class->id.'/'.$section->id) }}" target="_blank" class="btn btn-primary btn-sm btn-rounded"><i class="fas fa-eye"></i> Print Of Section {{  $section->name }}</a>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
