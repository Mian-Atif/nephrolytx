<!--Action Button-->
    @if(Active::checkUriPattern('admin/person'))
        <export-component></export-component>
    @endif
<!--Action Button-->
<div class="btn-group">
  <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">Action
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li style="font-size: 13px;padding: 0 5px;"><a href="{{route('admin.person.index')}}" style="color:#fff;"><i class="fa fa-list-ul"></i> {{trans('menus.backend.person.all')}}</a></li>
    @permission('create-blog')
    <li style="font-size: 13px;padding: 0 5px;"><a href="{{route('admin.person.create')}}" style="color:#fff;"><i class="fa fa-plus"></i> {{trans('menus.backend.person.create')}}</a></li>
    @endauth
  </ul>
</div>
<div class="clearfix"></div>