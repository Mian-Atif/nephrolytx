@extends ('backend.layouts.backend')

@section ('title', trans('labels.backend.access.users.management'))

@section('page-header')

        {{ trans('labels.backend.access.users.management') }}
        <small>{{ trans('labels.backend.access.users.active') }}</small>

@endsection

@section('content-new')

    <div class="card">
        <div class="card-body">

            <div class="box-tools text-right">
                <div class="col-md-12" style="margin-top: -60px">
                    @include('backend.access.includes.partials.user-header-buttons')
                </div>
            </div>
            <div class="row">

                <div class="col-12">
                    <div class="table-responsive">
                        <table id="users-table" class="table">
                            <thead>
                            <tr class="table-color">
{{--                                <th>{{ trans('labels.backend.access.users.table.first_name') }}</th>--}}
{{--                                <th>{{ trans('labels.backend.access.users.table.last_name') }}</th>--}}
                                <th>{{ trans('labels.backend.access.users.table.email') }}</th>
                                <th>{{ trans('labels.backend.access.users.table.confirmed') }}</th>
                                <th>{{ trans('labels.backend.access.users.table.roles') }}</th>
                                <th>{{ trans('labels.backend.access.users.table.created') }}</th>
                                <th>Status</th>
                                <th>{{ trans('labels.general.actions') }}</th>
                            </tr>
                        </thead>
                        <thead class="transparent-bg">
                            <tr class="text-white">
                               {{-- <th>
                                    {!! Form::text('first_name', null, ["class" => "search-input-text form-control", "data-column" => 0, "placeholder" => trans('labels.backend.access.users.table.first_name')]) !!}
                                        <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                                    </th>
                                <th>
                                    {!! Form::text('last_name', null, ["class" => "search-input-text form-control", "data-column" => 1, "placeholder" => trans('labels.backend.access.users.table.last_name')]) !!}
                                        <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                                </th>--}}
                                <th>
                                    {!! Form::text('email', null, ["class" => "search-input-text form-control", "data-column" => 2, "placeholder" => trans('labels.backend.access.users.table.email')]) !!}
                                        <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                                </th>
                                <th></th>
                                <th>
                                {!! Form::text('roles', null, ["class" => "search-input-text form-control", "data-column" => 4, "placeholder" => trans('labels.backend.access.users.table.roles')]) !!}
                                    <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
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


@endsection

@section('after-scripts')
    {{-- For DataTables --}}
{{--    {{ Html::script(mix('js/dataTable.js')) }}--}}

    <script>
        (function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            
            var dataTable = $('#users-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.access.user.get") }}',
                    type: 'post',
                    data: {status: 1, trashed: false}
                },
                columns: [

                    {{--{data: 'first_name', name: '{{config('access.users_table')}}.first_name'},--}}
                    // {data: 'name', name: 'person.name'},
                    {data: 'email', name: '{{config('access.users_table')}}.status'},
                    {data: 'confirmed', name: '{{config('access.users_table')}}.confirmed'},
                    {data: 'roles', name: '{{config('access.roles_table')}}.name', sortable: false},
                    {data: 'created_at', name: '{{config('access.users_table')}}.created_att'},
                    {data: 'status', name: '{{config('access.users_table')}}.status'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[0, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]  }}
                    ]
                },
                language: {
                    @lang('datatable.strings')
                }
            });

            Backend.DataTableSearch.init(dataTable);
        })();
    </script>
@endsection
