@extends('layouts.school_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Report {{ $page }}</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Accounting</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Reports</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped" width="100%" id="table_summary">
                <thead>
                    <th>Name</th>
                    <th>Amount</th>
                </thead>
                <tbody>
                <tr>
                    <td>Monthly Fee</td>
                    <td>{{ $monthly_fee }}</td>
                </tr>
                <tr>
                    <td>Annual Fee</td>
                    <td>{{ $annual_fee }}</td>
                </tr>
                <tr>
                    <td>Identity card fee</td>
                    <td>{{ $id_card_fee }}</td>
                </tr>
                <tr>
                    <td>Exam Fee </td>
                    <td>{{ $exam_fee }}</td>
                </tr>
                <tr>
                    <td>Stationary (Whole Year)</td>
                    <td>{{ $stationary }}</td>
                </tr>
                <tr>
                    <td>Computer Fee </td>
                    <td>{{ $computer_fee }}</td>
                </tr>
                <tr>
                    <td>Belt</td>
                    <td>{{ $belt }}</td>
                </tr>
                <tr>
                    <td>Calendar</td>
                    <td>{{ $calendar }}</td>
                </tr>
                <tr>
                    <td>Diary</td>
                    <td>{{ $diary }}</td>
                </tr>
                <tr>
                    <td>Bow Tie</td>
                    <td>{{ $bow_tie }}</td>
                </tr>
                <tr>
                    <td>Tie Short </td>
                    <td>{{ $tie_short }}</td>
                </tr>
                <tr>
                    <td>Book SET</td>
                    <td>{{ $book_lkg + $book_ukg + $book_nursery }}</td>
                </tr>
                <tr>
                    <td>Track-Suit (All Sizes)</td>
                    <td>{{ $trac }}</td>
                </tr>
                <tr>
                    <td>Extra Tuition Class (Monthly)</td>
                    <td>{{ $trac_extra_tution }}</td>
                </tr>
                <tr>
                    <td>Day Boader's</td>
                    <td>{{ $day_boarders }}</td>
                </tr>
                <tr>
                    <td>H-W copy set </td>
                    <td>{{ $h_w_copy_set }}</td>
                </tr>
                <tr>
                    <td>Extra Coaching Class (Monthly)</td>
                    <td>{{ $extrac_coaching }}</td>
                </tr>
                <tr>
                    <td>Sweater (All Sizes)</td>
                    <td>{{ $sweater }}</td>
                </tr>
                <tr>
                    <td>Cap</td>
                    <td>{{ $cap }}</td>
                </tr>
                <tr>
                    <td>Muffler</td>
                    <td>{{ $muffler }}</td>
                </tr>
                <tr>
                    <td>Transportaion Fee</td>
                    <td>{{ $transport }}</td>
                </tr>
                <tr>
                    <td>Hostel Fee</td>
                    <td>{{ $hostel_fee }}</td>
                </tr>
                <tr>
                    <td>Stocking Socks</td>
                    <td>{{ $stocking_socks }}</td>
                </tr>
                <tr>
                    <td>Festival Kids H/W Copy</td>
                    <td>{{ $festival_kids_h_w_copy }}</td>
                </tr>
                <tr>
                    <td>Copy</td>
                    <td>{{ $copy + $school_copy }}</td>
                </tr>
                <tr>
                    <td>Stationary Items</td>
                    <td>{{ $pencil + $sharpner + $eraser_pencil_sharpener + $eraser + $book + $stationery_half_year }}</td>
                </tr>
                <tr>
                    <td>Mask</td>
                    <td>{{ $mask }}</td>
                </tr>
                <tr>
                    <td>Tie/Belt/Sweater/Track suit</td>
                    <td>{{ $tie_belt_sweater_track_suit }}</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td>{{ $total }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('customScript')
    @include('school_admin.partials.datatable')
    <script type="text/javascript">

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
                "buttons": ['excel', 'pdf', 'print']
            });
        });

    </script>
@endsection
