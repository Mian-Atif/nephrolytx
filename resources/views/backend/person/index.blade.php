@extends ('backend.layouts.backend')


{{--@section ('title', trans('labels.backend.person.management'))--}}

{{--@section('page-header')--}}
    {{--<h1>{{ trans('labels.backend.person.management') }}</h1>--}}
{{--@endsection--}}
@section('before-styles')
  {{--  <style>
#person-table_processing{
    background-color: #d4fbff;
    color: black;
    border-radius: 2px;
}
    </style>--}}
@endsection

@section('content-new')
    

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">User Management</h4>
                <div class="box-tools text-right">
                    @include('backend.person.partials.person-header-buttons')
                </div>
                <div class="row">

                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="person-table" class="table">
                                <thead>
                                <tr>
                                    <th>Middle Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address1</th>
                                    <th>Address2</th>
                                    <th>Created At</th>
                                    <th>{{ trans('labels.general.actions') }}</th>
                                </tr>
                                </thead>
                                <thead class="transparent-bg">

                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
 
@endsection

@section('after-scripts')
     {{--For DataTables--}}
{{--    {{ Html::script(mix('js/dataTable.js')) }}--}}

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var dataTable = $('#person-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.person.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'middle_name', name: '{{config('module.person.table')}}.middle_name'},
                    {data: 'email', name: '{{config('module.person.table')}}.email'},
                    {data: 'phone', name: '{{config('module.person.table')}}.phone'},
                    {data: 'address1', name: '{{config('module.person.table')}}.address1'},
                    {data: 'address2', name: '{{config('module.person.table')}}.address2'},
                    {data: 'created_at', name: '{{config('module.person.table')}}.created_at'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false, "ordering": false}
                ],
                order: [[3, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4 ]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4 ]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4 ]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4 ]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4 ]  }}
                    ]
                },
                language: {
                    @lang('datatable.strings')
                }
            });

            Backend.DataTableSearch.init(dataTable);
        });
    </script>
@endsection