@extends ('backend.layouts.dashboard')
@section('content-new')

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            
            <a href="{{ url('reports/csvimport') }}" class="btn btn-success" title="Import Bulk Users">
                CSV Import
            </a>
            <a href="{{ url('reports/printreport') }}" class="btn btn-success" title="Import Bulk Users">
                Print Report
            </a>
        </div>
    </div>

<div class="card">
    <div class="card-header">
        {{ trans('global.user.title_singular') }} {{ trans('global.list') }}
    </div>
    @if(session('success'))
<br>
        <div class="alert alert-success" style="width: 50%">
            <strong>Success!</strong>  {{session()->get('success')}}
        </div>


@endif
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            First Name
                        </th>
                        <th>
                            Last Name
                        </th>
                        <th>
                            {{ trans('global.user.fields.email') }}
                        </th>
                        <th>
                            {{ trans('global.user.fields.email_verified_at') }}
                        </th>
                        <th>
                            {{ trans('global.user.fields.roles') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
{{--/*--}}
{{--    $(function () {--}}
{{--  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'--}}
{{--/!*--}}
{{--  let deleteButton = {--}}
{{--    text: deleteButtonTrans,--}}
{{--    url: "{{ route('admin.users.massDestroy') }}",--}}
{{--    className: 'btn-danger',--}}
{{--    action: function (e, dt, node, config) {--}}
{{--      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {--}}
{{--          return $(entry).data('entry-id')--}}
{{--      });--}}

{{--      if (ids.length === 0) {--}}
{{--        alert('{{ trans('global.datatables.zero_selected') }}')--}}

{{--        return--}}
{{--      }--}}

{{--      if (confirm('{{ trans('global.areYouSure') }}')) {--}}
{{--        $.ajax({--}}
{{--          headers: {'x-csrf-token': _token},--}}
{{--          method: 'POST',--}}
{{--          url: config.url,--}}
{{--          data: { ids: ids, _method: 'DELETE' }})--}}
{{--          .done(function () { location.reload() })--}}
{{--      }--}}
{{--    }--}}
{{--  }--}}
{{--*!/--}}
{{--  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)--}}
{{--@can('user_delete')--}}
{{--  dtButtons.push(deleteButton)--}}
{{--@endcan--}}

{{--  $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })--}}
{{--})--}}
{{--*/--}}

</script>
@endsection