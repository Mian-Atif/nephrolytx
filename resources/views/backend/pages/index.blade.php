@extends ('backend.layouts.backend')

@section ('title', trans('labels.backend.pages.management'))

@section('page-header')
   {{ trans('labels.backend.pages.management') }}
@endsection


@section('content-new')


    <div class="card">
        <div class="card-body">

            <div class="box-tools text-right">
                <div class="col-md-12" style="margin-top: -60px">
                    @include('backend.pages.partials.pages-header-buttons')
                </div>
            </div>
            <div class="row">

                <div class="col-12">
                    <table id="pages-table" class="table">
                        <thead>
                        <tr class="table-color">
                            <th>{{ trans('labels.backend.pages.table.title') }}</th>
                            <th>{{ trans('labels.backend.pages.table.status') }}</th>
                            <th>{{ trans('labels.backend.pages.table.createdat') }}</th>
                            <th>{{ trans('labels.backend.pages.table.createdby') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                        </thead>
                        <thead class="transparent-bg">
                        <tr>
                            <th>
                                {!! Form::text('first_name', null, ["class" => "search-input-text form-control", "data-column" => 0, "placeholder" => trans('labels.backend.pages.table.title')]) !!}
                                <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                            </th>
                            <th>
                                {!! Form::select('status', [0 => "InActive", 1 => "Active"], null, ["class" => "search-input-select form-control", "data-column" => 0,"style"=>"position:relative;top:-14px;height:35px;", "placeholder" => trans('labels.backend.pages.table.all')]) !!}
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                    </table>
                    </div><!--table-responsive-->
                </div><!-- /.box-body -->
            </div><!--box-->
        </div>
    </div>
    </div>















@endsection
@section('after-scripts')
    {{-- For DataTables --}}
{{--    {{ Html::script(mix('js/dataTable.js')) }}--}}

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var dataTable = $('#pages-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.pages.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'title', name: '{{config('module.pages.table')}}.title'},
                    {data: 'status', name: '{{config('module.pages.table')}}.status'},
                    {data: 'created_at', name: '{{config('module.pages.table')}}.created_at'},
                    {data: 'created_by', name: '{{config('access.users_table')}}.first_name'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[1, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0, 1, 2, 3 ]  }}
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