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
            <form method="get" action="{{ route('attendance.report.month') }}">
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
                    <label class="col-form-label">Section</label>
                    <select class="form-control select2" name="section_id" id="section_holder">
                        <option>Please Select Class First</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Date</label>
                    <input type="month" class="form-control" name="date" value="{{ @$date }}" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-rounded btn-outline-primary">Submit</button>
                </div>
            </form>
            @if(count(@$attendances) > 0)
                <br />
                <table class="table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <td>
                                Students <i class="fas fa-angle-down"> {{-- | Date  <i class="fas fa-angle-right"> --}}
                                {{-- {{ Carbon\Carbon::now()->daysInMonth }}     --}}
                            </td> 
                            @php
                                //$month = Carbon\Carbon::parse($date);
                                $month =  Carbon\Carbon::parse($date);
                               /* $start = Carbon\Carbon::parse($month)->startOfMonth();
                                $end = Carbon\Carbon::parse($month)->endOfMonth();
                                $dates = [];
                                while ($start->lte($end)) {
                                     $dates[] = $start->copy();
                                     $start->addDay();
                                }
                                echo "<pre>", print_r($dates), "</pre>";*/
                                $month_dates = [];
                                $days = cal_days_in_month(CAL_GREGORIAN, $month->format('m'), $month->year);

                            @endphp
                            {{-- @for($i = 1; $i <= $days; $i++)
                                <td><b>{{ $i }}</b></td>
                            @endfor --}}
                        </tr>
                        <tbody>
                            @php
                                $enrolls = $class->enroll()->where('is_active',1)->orderBy('created_at', 'ASC')->where('year', Auth::user()->school->detail->running_session)->where('section_id', $section_id)->get();
                            @endphp
                            @foreach($enrolls as $enroll)
                                <tr>
                                    <td>
                                        {{ $enroll->student->user->name }}
                                    </td>
                                    <?php
                                        $status = 0;
                                        for ($i = 1; $i <= $days; $i++){
                                            $timestamp = $month->year . '-' . $month->format('m') . '-' . $i;
                                             //echo $timestamp. '<br /> ';
                                            $attendancess = App\Models\Attendance::where('school_id', Auth::user()->school->id)->where('section_id', $section_id)->where('class_id', $class->id)->where('year', Auth::user()->school->detail->running_session)->where('date', $timestamp)->where('student_id',$enroll->student->id)->get();

                                            //echo $timestamp.'<br/>';
                                            ?>
                                            @foreach($attendancess as $attendance)

                                                @if(Carbon\Carbon::parse($attendance->date)->format('d') == $i)
                                                    <td style="text-align: center;">
                                                        <?php if ($attendance->status == 1) { ?>
                                                           <i class="fas fa-circle" style="color: green"></i></i> <br /> {{ $timestamp }}
                                                        <?php  }elseif($attendance->status == 2)  { ?>
                                                            <i class="fas fa-circle" style="color: red"></i> <br />  {{ $timestamp }}
                                                        <?php }else{ ?>
                                                            <i class="fas fa-circle" style="color: yellow"></i> <br />{{ $timestamp }}   
                                                        <?php  } ?>
                                                    </td> 
                                                @else
                                                    <td>{{ $timestamp }}</td>    
                                                @endif    
                                            @endforeach      

                                        <?php }
                                        //exit();
                                    ?>    
                                </tr>
                            @endforeach
                        </tbody>
                    </thead>
                </table>
            @endif
        </div>
    </div>
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
    </script>
@endsection    
