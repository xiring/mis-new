@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">{{ $page }}</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Student</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Student Promotion</div>
        <div class="card-body bg-info">
            <strong>Student Promotion Notes</strong>
            <p>
                Promoting student from the present class to the next class will create an enrollment of that student to the next session. Make sure to select correct class options from the select menu before promoting.If you don't want to promote a student to the next class, please select that option. That will not promote the student to the next class but it will create an enrollment to the next session but in the same class.
            </p>
        </div>
        <div class="card-body">
            @php
                $running_year_array = explode("-", $system_settings->detail->running_session);
                $next_year_first_index          = $running_year_array[1];
                $next_year_second_index         = $running_year_array[1]+1;
                $next_year                      = $next_year_first_index. "-" .$next_year_second_index;
            @endphp
            {{ Form::open(['route' => 'student.promotion.store' , 'files' => true]) }}
                <div class="form-group">
                    <label class="col-form-label">Current Session</label>
                    <select class="form-control" name="current_session">
                        <option value="{{ $system_settings->detail->running_session }}"> {{ $system_settings->detail->running_session }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Promote To Session</label>
                    <select class="form-control" name="promote_to_session" id="promotion_year">
                        <option value="{{ $next_year }}">{{ $next_year }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Promote From Class</label>
                    <select class="form-control select2" id="from_class_id" name="promotion_from_class">
                        <option></option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Promote To Class</label>
                    <select class="form-control select2" id="to_class_id" name="promotion_to_class">
                        <option></option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-sm btn-primary" onclick="get_students_to_promote('{{ $system_settings->detail->running_session }}')">Manage Promotion</button>
                </div>
                <div id="students_for_promotion_holder"></div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
@section('customScript')
    <script type="text/javascript">

        function get_students_to_promote(running_year)
        {
            from_class_id   = $("#from_class_id").val();
            to_class_id     = $("#to_class_id").val();
            promotion_year  = $("#promotion_year").val();
            site_url = "{{  config('app.url') }}";

            $.ajax({
                url: site_url +'/school/dashboard/get_students_to_promote/' + from_class_id + '/' + to_class_id + '/' + running_year + '/' + promotion_year,
                success: function(response)
                {
                    jQuery('#students_for_promotion_holder').html(response);
                }
            });
            return false;
        }

    </script>
@endsection

