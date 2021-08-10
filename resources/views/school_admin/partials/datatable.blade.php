<link rel="stylesheet" type="text/css" href="{{ asset('assets/back/libs/table/dataTables.bootstrap4.min.css') }}">
<link href="{{ asset('assets/back/libs/table/buttons.dataTables.min.css') }}">
<script type="text/javascript" src="{{ asset('assets/back/libs/table/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/back/libs/table/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/back/libs/table/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/back/libs/table/buttons.flash.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/back/libs/table/pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/back/libs/table/vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/back/libs/table/buttons.html5.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/back/libs/table/buttons.print.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/back/libs/table/buttons.colVis.min.js')}}"></script>

<style>
    .buttons-html5{
        color: #fff;
        background-color: #5969ff;
        border-color: #5969ff;
        font-size: 14px;
        padding: 9px 16px;
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        border: 1px solid transparent;
        line-height: 1.5;
        border-radius: 100px;
        cursor: pointer;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .buttons-print{
        color: #fff;
        background-color: #5969ff;
        border-color: #5969ff;
        font-size: 14px;
        padding: 9px 16px;
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        border: 1px solid transparent;
        line-height: 1.5;
        border-radius: 100px;
        cursor: pointer;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .buttons-colvis{
        color: #fff;
        background-color: #5969ff;
        border-color: #5969ff;
        font-size: 14px;
        padding: 9px 16px;
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        border: 1px solid transparent;
        line-height: 1.5;
        border-radius: 100px;
        cursor: pointer;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    div.dataTables_wrapper div.dataTables_filter {
        text-align: right;
        margin-top: -35px;
</style>

<script>
    $(function () {
        $('#datatable').dataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            'order'       : [[0,"desc"]],
            'buttons'     : ['excel', 'pdf'],
            "lengthMenu": [[10, 20, 30, 40, 50, 100, -1], [10, 20, 30, 40, 50, 100, "All"]],
            dom: 'lfBrtip'
        });


        $('.data_table').dataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            'order'       : [[0,"desc"]],
            'buttons'     : ['excel', 'pdf'],
            "lengthMenu": [[10, 20, 30, 40, 50, 100, -1], [10, 20, 30, 40, 50, 100, "All"]],
            dom: 'lfBrtip'
        });

    });
</script>