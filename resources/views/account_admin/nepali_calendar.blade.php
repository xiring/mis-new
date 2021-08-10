@extends('layouts.account_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Nepali Calendar</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Nepali Calendar</a></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="ecommerce-widget">
        <div class="col-md-12">
            {{--<div class="card">
                <div class="card-body">--}}
            <iframe src="https://www.hamropatro.com/widgets/calender-full.php" frameborder="0" scrolling="no" marginwidth="0" marginheight="0"
                    style="border:none; overflow:hidden; width:100%; height:840px;" allowtransparency="true"></iframe>
            {{--</div>
        </div>--}}
        </div>
    </div>
@endsection