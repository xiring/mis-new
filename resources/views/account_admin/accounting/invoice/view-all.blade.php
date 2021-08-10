@extends('layouts.account_admin')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <a class="btn btn-sm btn-rounded btn-info" onClick="PrintElem('#invoice_print')"><i class="fas fa-print"></i> Print All</a>
            </div>
            <div class="card-body">
                <div id ="invoice_print">
                    @foreach($invoices as $invoice)
                        <div id="invoice_print1" style="page-break-after: always;">
                            <table width="100%" border="0">
                                <tr>
                                    <td align="left"><img src="https://samayapathshala.edu.np/uploads/logo.png" alt="..." height="50px" width="70px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td>
                                        <h4>{{ $system_settings->name }}</h4>
                                        <h4>{{ $system_settings->address }}<h4>
                                        <h4>{{ $system_settings->contact_number }}<h4>
                                    </td>
                                    <td align="right">&nbsp;&nbsp;</td>
                                </tr>
                            </table>
                            <table width="100%" border="0" style="margin-top: -25px;">
                                <tr>
                                    <td align="left">Invoice No: {{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT)  }}</td>
                                    <td align="right">
                                        @if(is_null($invoice->payment_date_nepali))
                                            <h5>Date : {{ \Carbon\Carbon::parse($invoice->invoice_date_nepali)->format('Y-m-d') }}</h5>
                                        @else
                                            <h5>Date : {{ \Carbon\Carbon::parse($invoice->payment_date_nepali)->format('Y-m-d') }}</h5>
                                        @endif
                                        <h5>Title : Fees</h5>
                                        <h5>{{ ($invoice->status == 0) ? 'Un-paid' : 'Paid' }}</h5>
                                    </td>
                                </tr>
                            </table>
                            <hr>
                            <table width="100%" border="0" style="margin-top: -18px;">
                                <tr>
                                    <td align="left"><h4>Bill To</h4></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top">
                                        {{ $invoice->student->user->name }}<br/>
                                        {{ $invoice->classW->name }}<br />
                                    </td>
                                </tr>
                            </table>
                            <table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $n = 0 @endphp
                                    @foreach($invoice->invoiceItems as $item)
                                        <tr>
                                            <td>{{ ++$n  }}</td>
                                            <td>
                                                {{ $item->fee->name }}
                                                @if($item->discounted_or_not == 1)
                                                    @php
                                                        $mn = App\Models\InvoiceItems::where('invoice_id', $item->invoice->id)->where('discounted_or_not', 1)->where('fee_category_id', $monthly_fee_category->id)->first();
                                                        $amt = $item->invoice->student->scholarship->percentage / 100 * ($mn->quantity * $item->fee->amount)
                                                    @endphp
                                                    (Less {{ $amt }})
                                                @endif
                                            </td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>
                                                @if($invoice->id == '1444' && $item->fee_category_id == '106')
                                                    {{ $item->quantity * 675 }}
                                                @else
                                                    @if($item->is_half == 1)
                                                        {{ $item->quantity * $item->halfFee->half_amount }}
                                                    @else
                                                        {{ $item->quantity * $item->fee->amount }}
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($invoice->student->transport_id != 0 && @$invoice->invoiceTransport->quantity >0 && !is_null($invoice->invoiceTransport))
                                        <tr>
                                            <td></td>
                                            <td>Transportation Fee</td>
                                            <td>{{ $invoice->invoiceTransport->quantity }}</td>
                                            <td>{{ $invoice->invoiceTransport->quantity * $invoice->student->transport->fare }}</td>
                                        </tr>
                                    @endif
                                    @if(!is_null($invoice->previous_year_amount))
                                        <tr>
                                            <td></td>
                                            <td>Previous Year Fee</td>
                                            <td>1</td>
                                            <td>{{ $invoice->previous_year_amount }}</td>
                                        </tr>
                                    @endif
                                    @if($invoice->previous_invoice_id != 0)
                                        <tr>
                                            <td></td>
                                            <td>Previous Invoice Billed Date :{{ \Carbon\Carbon::parse($invoice->prevInv->invoice_date_nepali)->format('Y-m-d') }}</td>
                                            <td>1</td>
                                            <td>{{ $invoice->prevInv->due }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
                                <tr>
                                    <td align="left">Amount in words:</td>
                                    <td alight="left" width="50%">{{ $invoice->amount_in_words }}</td>
                                    <td align="right" width="30%">Total Amount :</td>
                                    <td align="right">{{ $invoice->amount }}</td>
                                </tr>
                                <tr>
                                    <td align="left">Remarks:</td>
                                    <td align="left" width="50%">{{ $invoice->remarks }}</td>
                                    <td align="right" width="30%"><h4>Amount Paid :</h4></td>
                                    <td align="right"><h4>{{ $invoice->amount_paid }}</h4></td>
                                </tr>
                                @if($invoice->due > 0)
                                    <tr>
                                        <td align="left"></td>
                                        <td align="left"></td>
                                        <td align="right" width="80%"><h4>Due :</h4></td>
                                        <td align="right"><h4>{{ $invoice->due }}</h4></td>
                                    </tr>
                                @endif
                            </table>
                            <table class="table" width="100%" style="border-collapse: collapse;" border="0">
                                <tr>
                                    <td><br />...................................................<br />Accountant Sign</td>
                                </tr>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customScript')
    <script type="text/javascript">

        // print invoice function
        function PrintElem(elem)
        {
            Popup($(elem).html());
        }

        function Popup(data)
        {
            var mywindow = window.open('', 'invoice', 'height=420,width=595');
            mywindow.document.write('<html><head><title>Invoice</title>');
            mywindow.document.write('</head><body>');
            mywindow.document.write(data);
            mywindow.document.write('</body></html>');

            mywindow.print();
            mywindow.close();

            return true;
        }

    </script>
@endsection
