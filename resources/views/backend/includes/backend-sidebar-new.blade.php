<nav class="sidebar sidebar-info" id="sidebar">
    <div class="sidebar-content-wrapper sidebar-offcanvas">
        <ul class="nav">
            <li class="{{ active_class(Active::checkUriPattern('admin/dashboard')) }} nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
{{--                <img src="{{ asset('img/images/file-icons/dashboard.png') }}" class="menu-icon" style="width: 18px;height: 18px;">--}}
                    <i class="ti-home menu-icon" aria-hidden="true"></i>
                    <span class="menu-title">{{ trans('menus.backend.sidebar.dashboard') }}</span>
                </a>
            </li>

            {{ renderMenuItems(getMenuItems()) }}
          {{--  @permission('view-person')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.person.index') }}">
                    <i class="fa fa-male menu-icon" aria-hidden="true"></i>
--}}{{--                <img src="{{ asset('img/images/file-icons/maintenance.png') }}" class="menu-icon" style="width: 18px;height: 18px;">--}}{{--
                    <span class="menu-title">User Management</span>
                </a>
            </li>
            @endauth--}}

            @permission('view-practice')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.practices.index') }}">
                    <i class="fas fa-user-md menu-icon" aria-hidden="true"></i>
{{--                <img src="{{ asset('img/images/file-icons/maintenance.png') }}" class="menu-icon" style="width: 18px;height: 18px;">--}}
                    <span class="menu-title">Practice Management</span>
                </a>
            </li>
            @endauth



            {{--@permission('view-user-management')--}}
            {{--<li class="nav-item">--}}
                {{--<a class="nav-link" data-toggle="collapse" href="#user-management" aria-expanded="false"--}}
                   {{--aria-controls="ui-apps">--}}
                    {{--<i class="fas fa-users-cog menu-icon" aria-hidden="true"></i>--}}
                    {{--<span class="menu-title">User Management</span>--}}
                    {{--<i class="ti-angle-down menu-arrow"></i>--}}
                {{--</a>--}}
                {{--<div class="collapse" id="user-management">--}}
                    {{--<ul class="nav flex-column sub-menu">--}}
                        {{--@permission('view-users')--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{route('admin.access.user.index')}}" class="nav-link">--}}
                                {{--<span>Users</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--@endauth--}}
                        {{--@permission('view-permission')--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{route('admin.access.permissions')}}" class="nav-link">--}}
                                {{--<span>User Permissions</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--@endauth--}}
                        {{--@permission('view-role')--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="{{route('admin.access.roles')}}" class="nav-link">--}}
                                {{--<span>User Roles</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--@endauth--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</li>--}}
            {{--@endauth--}}
       {{--     @permission('view-page')
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.pages.index')}}">
                    <i class="fa fa-file-text menu-icon" aria-hidden="true"></i>
--}}{{--                <img src="{{ asset('img/images/file-icons/maintenance.png') }}" class="menu-icon" style="width: 18px;height: 18px;">--}}{{--
                    <span class="menu-title">Pages</span>
                </a>
            </li>
            @endauth--}}
           
        </ul>
    </div>
</nav>