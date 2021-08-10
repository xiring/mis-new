@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Dashboard</h2>
        {{--<p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>--}}
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Settings</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            {{ Form::open(['route' => 'school.setting.update' , 'files' => true]) }}
                <div class="form-group">
                    <input type="hidden" name="id" id="id" value="{{ $school->id }}">
                    <label class="col-form-label">Institution Name</label>
                    <input type="text" name="name" value="{{ $school->name }}" class="form-control" required >
                </div>
                <div class="form-group">
                    <label class="col-form-label">Email</label>
                    <input type="email" name="email" value="{{ $school->email }}" class="form-control" required >
                </div>
                <div class="form-group">
                    <label class="col-form-label">Address</label>
                    <input type="text" name="address" value="{{ $school->address }}" class="form-control" required >
                </div>
                <div class="form-group">
                    <label class="col-form-label">Contact Number</label>
                    <input type="text" name="contact_number" value="{{ $school->contact_number }}" class="form-control" required >
                </div>
                <div class="form-group">
                    <label class="col-form-label">Currency</label>
                    <input type="text" name="currency" value="{{ $school->detail->currency}}" class="form-control" required >
                </div>
                <div class="form-group">
                    <label class="col-form-label">Running Session</label>
                    <select class="form-control" name="running_session">
                        <option value="" disabled="true">Select Running Session</option>
                        @for($i = 0; $i < 20; $i++)
                            <option value="{{  2070 + $i }}-{{ 2070+$i+1 }}" <?php if($school->detail->running_session == (2070+$i).'-'.(2070+$i+1)) echo 'selected';?>>
                                {{  2070 + $i }}-{{ 2070+$i+1 }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Logo</label>
                    <input type="file" name="logo" class="form-control-file" >
                    @if($school->logo)
                        Current Logo<br/>
                        <img src="{{  asset($school->logo) }}" class="img-thumbnail" height="100px" width="100px"/>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-rounded btn-primary"><i class="fas fa-save"></i></button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
    {{--<div class="card-header">System Settings</div>

    <div class="card-body">
        {
    </div>--}}
@endsection
