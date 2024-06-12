@extends ('backend.layouts.backend')

@section ('title', trans('labels.backend.access.permissions.management'))

@section('page-header')
    {{ trans('labels.backend.access.permissions.management') }}
@endsection

@section('content-new')


    <div class="card">
        <div class="card-body">

            <div class="box-tools text-right">
                <div class="col-md-12" style="margin-top: -60px">
                    @include('backend.access.includes.partials.permission-header-buttons')
                </div>
            </div>
            <div class="row">

                <div class="">
                    <div class="table-responsive">


                        <table id="permissions-table" class="table table-condensed table-bordered">
                            <thead>
                            <tr>
                                <th>{{ trans('labels.backend.access.permissions.table.permission') }}</th>
                                <th>{{ trans('labels.backend.access.permissions.table.display_name') }}</th>
                                <th>{{ trans('labels.backend.access.permissions.table.sort') }}</th>
                                <th>{{ trans('labels.general.actions') }}</th>
                            </tr>
                            </thead>
                            <thead class="transparent-bg">
                            <tr>
                                <th>
                                    {!! Form::text('permission', null, ["class" => "search-input-text form-control", "data-column" => 0, "placeholder" => trans('labels.backend.access.permissions.table.permission')]) !!}
                                    <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                                </th>
                                <th>
                                    {!! Form::text('display_name', null, ["class" => "search-input-text form-control", "data-column" => 1, "placeholder" => trans('labels.backend.access.permissions.table.display_name')]) !!}
                                    <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                                </th>
                                <th>
                                    {!! Form::text('sort', null, ["class" => "search-input-text form-control", "data-column" => 2, "placeholder" => trans('labels.backend.access.roles.table.sort')]) !!}
                                    <a class="reset-data" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                                </th>
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
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var dataTable = $('#permissions-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.access.permission.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'name', name: '{{config('access.permissions_table')}}.name'},
                    {data: 'display_name', name: '{{config('access.permissions_table')}}.display_name', sortable: false},
                    {data: 'sort', name: '{{config('access.permissions_table')}}.sort'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[3, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [

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