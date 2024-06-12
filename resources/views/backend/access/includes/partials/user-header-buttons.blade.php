<!--Action Button-->
    @if(Active::checkUriPattern('admin/access/user') || Active::checkUriPattern('admin/access/user/deleted') || Active::checkUriPattern('admin/access/user/deactivated'))
        @include('backend.access.includes.partials.header-export')
    @endif
<!--Action Button-->
<div class="btn-group">
  <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">@lang('menus.backend.access.users.action')
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li style="font-size: 13px;padding: 0 5px;"><a href="{{route('admin.access.user.index')}}" style="color: #fff;"><i class="fa fa-list-ul"></i> @lang('menus.backend.access.users.list')</a></li>
    <li style="font-size: 13px;padding: 0 5px;"><a href="{{route('admin.upload-reports-data.create')}}" style="color: #fff;"><i class="fa fa-list-ul"></i> Upload CSV File</a></li>
    @permission('create-user')
    <li style="font-size: 13px;padding: 0 5px;"><a href="{{route('admin.access.user.create')}}" style="color: #fff;"><i class="fa fa-plus"></i> @lang('menus.backend.access.users.add-new')</a></li>
    @endauth
    @permission('view-deactive-user')
    {{--<li style="font-size: 13px;padding: 0 5px;"><a href="{{route('admin.access.user.deactivated')}}" style="color: #fff;"><i class="fa fa-square"></i> @lang('menus.backend.access.users.deactivated-users')</a></li>--}}
    @endauth
    @permission('view-deleted-user')
    {{--<li style="font-size: 13px;padding: 0 5px;"><a href="{{route('admin.access.user.deleted')}}" style="color: #fff;"><i class="fa fa-trash"></i> @lang('menus.backend.access.users.deleted-users')</a></li>--}}
    @endauth
  </ul>
</div>