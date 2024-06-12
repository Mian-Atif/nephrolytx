@extends ('backend.layouts.backend')
@section ('title', trans('labels.backend.practices.management'))

@section('page-header')
    {{ trans('labels.backend.practices.management') }}
@endsection
@section('before-styles')
    <style>
        .dt-buttons {
            display: none;
        }
        #practices-table_filter{
            float: right !important;
            width: 80%;
        }
        #practices-table_filter > label{
           float: right;
           margin: 20px 0;
       }
        #practices-table_length {
            float: left;
            width: 20%;
        }
        .pagination #practices-table_previous a{
            border-color: rgba(101, 103, 119, 0.21);
            color: #ffffff;
            font-size: .875rem;
            transition-duration: 0.3s;
            pointer-events: none;
            cursor: auto;
            background-color: #8b8d91;
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
        }
        .pagination #practices-table_next a{
            border-color: rgba(101, 103, 119, 0.21);
            color: #ffffff;
            font-size: .875rem;
            transition-duration: 0.3s;
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            background-color: #0000004d;
        }
        .pagination .paginate_button a{
            border-color: rgba(101, 103, 119, 0.21);
            color: #ffffff;
            font-size: .875rem;
            -moz-transition-duration: 0.3s;
            -o-transition-duration: 0.3s;
            transition-duration: 0.3s;
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            background-color: #0000004d;
        }
        .pagination .active a{
            background-color: #f16857;
        }
        #practices-table_info{
            float: left;
            width: 100%;
        }
        #practices-table_processing{
            background-color: #d4fbff;
            color: black;
            border-radius: 2px;
        }
        #practices-table_paginate{
            float: right;
            width: 100%;
        }
       div.dataTables_wrapper div.dataTables_paginate {
           margin: 0;
           white-space: nowrap;
           text-align: right;
       }
       div.dataTables_wrapper div.dataTables_paginate ul.pagination {
           margin: 2px 0;
           white-space: nowrap;
           justify-content: flex-end;
       }
    </style>


@endsection
@section('content-new')

    <div class="box-tools text-right">
        @include('backend.practices.partials.practices-header-buttons')
    </div>

    <div class="row">

        <div class="col-12">
            <div class="table-responsive">
                <table id="practices-table" class="table">
                    <thead>
                    <tr class="table-color">
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Owner</th>
                        <th>Type</th>
                        <th>created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <thead class="transparent-bg">

                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!--table-responsive-->
    </div><!--table-responsive-->
@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(asset('js/dataTable.js')) }}

    <script>
        //Below written line is short form of writing $(document).ready(function() { })
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var dataTable = $('#practices-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.practices.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'id', name: '{{config('module.practices.table')}}.id'},
                    {data: 'name', name: '{{config('module.practices.table')}}.name'},
                    {data: 'email', name: '{{config('module.practices.table')}}.email'},
                    {data: 'owner', name: '{{config('module.person.table')}}.middle_name'},
                    {data: 'type', name: '{{config('module.practices.table')}}.type'},
                    {data: 'created_at', name: '{{config('module.practices.table')}}.created_at'},
                    {data: 'actions', name: 'actions', searchable: true, sortable: true}
                ],
                order: [[0, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                        {extend: 'copy', className: 'copyButton', exportOptions: {columns: [0, 1,3,4,5]}},
                        {extend: 'csv', className: 'csvButton', exportOptions: {columns: [0, 1,2,3,4,5]}},
                        {extend: 'excel', className: 'excelButton', exportOptions: {columns: [0, 1,2,3,4,5]}},
                        {extend: 'pdf', className: 'pdfButton', exportOptions: {columns: [0, 1,2,3,4,5]}},
                        {extend: 'print', className: 'printButton', exportOptions: {columns: [0, 1,2,3,4,5]}}
                    ]
                }
            });

            dataTable.on('draw.dt', function () {
                var PageInfo = $('#practices-table').DataTable().page.info();
                dataTable.column(0, {page: 'current'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1 + PageInfo.start;
                });
            }).draw();
            (function (dataTable) {

                // Header All search columns
                $("div.dataTables_filter input").unbind();
                $("div.dataTables_filter input").keypress(function (e) {


                    if (e.keyCode == 13) {
                        let table = jQuery('#practices-table').dataTable();
                        table.fnFilter(this.value);
                        // dataTable.fnFilter( this.value );
                    }
                });

                // Individual columns search
                $('.search-input-text').on('keypress', function (e) {
                    // for text boxes
                    if (e.keyCode == 13) {
                        var i = $(this).attr('data-column');  // getting column index
                        var v = $(this).val();  // getting search input value
                        dataTable.api().columns(i).search(v).draw();
                    }
                });

                // Individual columns search
                $('.search-input-select').on('change', function (e) {
                    // for dropdown
                    var i = $(this).attr('data-column');  // getting column index
                    var v = $(this).val();  // getting search input value
                    dataTable.api().columns(i).search(v).draw();
                });

                // Individual columns reset
                $('.reset-data').on('click', function (e) {
                    var textbox = $(this).prev('input'); // Getting closest input field
                    var i = textbox.attr('data-column');  // Getting column index
                    $(this).prev('input').val(''); // Blank the serch value
                    dataTable.api().columns(i).search("").draw();
                });

                //Copy button
                $('#copyButton').click(function () {
                    $('.copyButton').trigger('click');
                });
                //Download csv
                $('#csvButton').click(function () {
                    $('.csvButton').trigger('click');
                });
                //Download excelButton
                $('#excelButton').click(function () {
                    $('.excelButton').trigger('click');
                });
                //Download pdf
                $('#pdfButton').click(function () {
                    $('.pdfButton').trigger('click');
                });
                //Download printButton
                $('#printButton').click(function () {
                    $('.printButton').trigger('click');
                });

                var id = $('.table-responsive .dataTables_filter').attr('id') ;
                $('#' + id + ' label').append('<a class="reset-data" id="input-sm-reset" href="javascript:void(0)"></a>');
                $(document).on('click', "#" + id + " label #input-sm-reset", function () {
                    let table = jQuery('#practices-table').dataTable();
                    table.fnFilter('');
                });
            }(dataTable));

            // dataTable.DataTableSearch.init(dataTable);
        });
    </script>
    
@endsection
