@extends('layouts.account_admin')

@section('content')
    <div class="page-header" id="top">
        <h2 class="pageheader-title">Manage {{ $page }}</h2>
        <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Accounting</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
            {{ Form::open(['route' => 'accountant.invoice.store' , 'files' => true]) }}
                <div class="card">
                    <div class="card-header">
                        Invoice Information's
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="col-form-label">Class</label>
                            <input type="hidden" name="school_id" value="{{ Session::get('school_id') }}">
                            <select class="form-control select2" name="class_id" onchange="getClassStudents(this.value); getClassFees(this.value);getClassFeesHalf(this.value);">
                                <option>Pleas Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Student</label>
                            <select class="form-control select2" name="student_id" id="student_holder" onchange="getStudentTrans(this.value); getScholarship(this.value); getPreviousInvoice(this.value); ">
                                <option>Please Select Class First</option>
                            </select>
                        </div>
                        <div id="transportation_fee">
                        </div>
                        <div id="previous_invoice">
                        </div>
                        <div class="form-group">
                            <span class='col-form-label' id="scholarship_label" style="color:red"></span>
                        </div>
                        <div class="form-group">
                            <table class="table table-bordered" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Particulars</th>
                                        <th>Qty</th>
                                        <th>Amount</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody id="patriculars_amount">
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="form-group">
                            <table class="table table-bordered" id="myTable1">
                                <thead>
                                <tr>
                                    <th>Particulars</th>
                                    <th>Qty</th>
                                    <th>Half Amount</th>
                                    <th>Option</th>
                                </tr>
                                </thead>
                                <tbody id="patriculars_half_amount">
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Date</label>
                            <input type="date" name="invoice_date" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        Payment Information's
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="col-form-label">Amount</label>
                            <input type="number" name="amount" step="any" class="form-control" required placeholder="Enter Payment Amount">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Remarks</label>
                            <input type="text" class="form-control" name="remarks" required placeholder="Enter Remarks">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Status</label>
                            <select class="form-control" name="status">
                                <option value="1">Paid</option>
                                <option value="0">Un-Paid</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-rounded btn-primary submit-monthly"><i class="fas fa-save"></i></button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
@section('customScript')
    <script>
        function getClassStudents(class_id) {
            if (class_id !== '') {
                $.ajax({
                    url: '{{ url('/accountant/dashboard/student') }}'+'/'+ class_id ,
                    success: function(response)
                    {
                        jQuery('#student_holder').html(response);
                    }
                });
            }
        }

        function getClassFees(class_id) {
            if (class_id !== '') {
                $.ajax({
                    url: '{{ url('/accountant/dashboard/class/fee') }}'+'/'+ class_id ,
                    success: function(response)
                    {
                        jQuery('#patriculars_amount').html(response);
                    }
                });
            }
        }

        function getClassFeesHalf(class_id) {
            if (class_id !== '') {
                $.ajax({
                    url: '{{ url('/accountant/dashboard/class/fee/half') }}'+'/'+ class_id ,
                    success: function(response)
                    {
                        jQuery('#patriculars_half_amount').html(response);
                    }
                });
            }
        }

        function getStudentTrans(student_id) {
            if (student_id !== '') {
                $.ajax({
                    url: '{{ url('/accountant/dashboard/student/transport') }}'+'/'+ student_id ,
                    success: function(response)
                    {
                        jQuery('#transportation_fee').html(response);
                    }
                });
            }
        }

        function getScholarship(student_id) {
            if (student_id !== '') {
                $.ajax({
                    url: '{{ url('/accountant/dashboard/student/scholarship') }}'+'/'+ student_id ,
                    success: function(response)
                    {
                        jQuery('#scholarship_label').html(response);
                    }
                });
            }
        }

        function getPreviousInvoice(student_id) {
            if (student_id !== '') {
                $.ajax({
                    url: '{{ url('/accountant/dashboard/student/previous/invoice') }}'+'/'+ student_id ,
                    success: function(response)
                    {
                        jQuery('#previous_invoice').html(response);
                    }
                });
            }
        }
    </script>
    <script>
        function deleteRow(i){
            document.getElementById('myTable').deleteRow(i)
        }
    </script>
    <script>
        function deleteRow1(i){
            document.getElementById('myTable1').deleteRow(i)
        }
    </script>

    <script type="text/javascript">

        function select() {
            var chk = $('.check');
            for (i = 0; i < chk.length; i++) {
                chk[i].checked = true ;
            }
        }
        function unselect() {
            var chk = $('.check');
            for (i = 0; i < chk.length; i++) {
                chk[i].checked = false ;
            }
        }
    </script>
@endsection
