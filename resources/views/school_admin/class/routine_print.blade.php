<div id="print">

    <script src="{{ asset('assets/back/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <style type="text/css">
        td {
            padding: 5px;
        }
    </style>

    <center>
        <h3 style="font-weight: 100;"><?php echo $system_settings->name;?></h3>
        Class Routine<br>
        Class {{ $class->name }} : Section {{ $section->name }}<br>
    </center>
    <br>
    <table style="width:100%; border-collapse:collapse;border: 1px solid #eee; margin-top: 10px;" border="1">
        <tbody>
            <tr>
                <td width="100">Sunday</td>
                <td>
                    @foreach($routines as $routine)
                        <div style="float:left; padding:8px; margin:5px; background-color:#ccc;">
                            {{ $routine->subject->name }}
                            ({{ $routine->time_start }} : {{ $routine->time_start_min }} {{ $routine->start_am_pm }}- {{ $routine->time_end }} : {{ $routine->time_end_min }} {{ $routine->end_am_pm }})
                        </div>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td width="100">Monday</td>
                <td>
                    @foreach($monday_routines as $routine)
                        <div style="float:left; padding:8px; margin:5px; background-color:#ccc;">
                            {{ $routine->subject->name }}
                            ({{ $routine->time_start }} : {{ $routine->time_start_min }} {{ $routine->start_am_pm }}- {{ $routine->time_end }} : {{ $routine->time_end_min }} {{ $routine->end_am_pm }})
                        </div>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td width="100">Tuesday</td>
                <td>
                    @foreach($tue_routines as $routine)
                        <div style="float:left; padding:8px; margin:5px; background-color:#ccc;">
                            {{ $routine->subject->name }}
                            ({{ $routine->time_start }} : {{ $routine->time_start_min }} {{ $routine->start_am_pm }}- {{ $routine->time_end }} : {{ $routine->time_end_min }} {{ $routine->end_am_pm }})
                        </div>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td width="100">Wednesday</td>
                <td>
                    @foreach($wed_routines as $routine)
                        <div style="float:left; padding:8px; margin:5px; background-color:#ccc;">
                            {{ $routine->subject->name }}
                            ({{ $routine->time_start }} : {{ $routine->time_start_min }} {{ $routine->start_am_pm }}- {{ $routine->time_end }} : {{ $routine->time_end_min }} {{ $routine->end_am_pm }})
                        </div>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td width="100">Thursday</td>
                <td>
                    @foreach($thu_routines as $routine)
                        <div style="float:left; padding:8px; margin:5px; background-color:#ccc;">
                            {{ $routine->subject->name }}
                            ({{ $routine->time_start }} : {{ $routine->time_start_min }} {{ $routine->start_am_pm }}- {{ $routine->time_end }} : {{ $routine->time_end_min }} {{ $routine->end_am_pm }})
                        </div>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td width="100">Friday</td>
                <td>
                    @foreach($fri_routines as $routine)
                        <div style="float:left; padding:8px; margin:5px; background-color:#ccc;">
                            {{ $routine->subject->name }}
                            ({{ $routine->time_start }} : {{ $routine->time_start_min }} {{ $routine->start_am_pm }}- {{ $routine->time_end }} : {{ $routine->time_end_min }} {{ $routine->end_am_pm }})
                        </div>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">

    jQuery(document).ready(function($)
    {
        var elem = $('#print');
        PrintElem(elem);
        Popup(data);

    });

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title></title>');
        //mywindow.document.write('<link rel="stylesheet" href="assets/css/print.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        //mywindow.document.write('<style>.print{border : 1px;}</style>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
</script>