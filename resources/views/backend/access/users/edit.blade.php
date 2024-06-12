@extends ('backend.layouts.backend')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.edit'))

@section('page-header')
        {{ trans('labels.backend.access.users.management') }}
        <small>{{ trans('labels.backend.access.users.edit') }}</small> </h1>
@endsection

@section('content-new')
                <div class="box-tools text-right">
                    @include('backend.access.includes.partials.user-header-buttons')
                </div><!--box-tools pull-right-->
                {{ Form::model($user, ['route' => ['admin.access.user.update', $user], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) }}

                <div class="row">
                    <div class="col-md-12">
                        <div class="box-body">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">

                                        {{ Form::label('person', 'Person', ['class' => 'col-lg-12 control-label required']) }}

                                        <div class="col-lg-12">
                                            {{ Form::text('person', $person->, ['class' => 'form-control box-size', 'placeholder' => 'Person', 'required' => 'required']) }}
                                        </div><!--col-lg-10-->
                                    </div><!--form control-->

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('First Name', trans('validation.attributes.backend.access.users.firstName'), ['class' => 'col-lg-12 control-label required']) }}

                                        <div class="col-lg-12">
                                            {{ Form::text('first_name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.users.firstName'), 'required' => 'required']) }}
                                        </div><!--col-lg-10-->
                                    </div><!--form control-->

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('Last Name', trans('validation.attributes.backend.access.users.lastName'), ['class' => 'col-lg-12 control-label required']) }}

                                        <div class="col-lg-12">
                                            {{ Form::text('last_name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.users.lastName'), 'required' => 'required']) }}
                                        </div><!--col-lg-10-->
                                    </div><!--form control-->
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('email', trans('validation.attributes.backend.access.users.email'), ['class' => 'col-lg-12 control-label required']) }}

                                        <div class="col-lg-12">
                                            {{ Form::text('email', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.users.email'), 'required' => 'required']) }}
                                        </div><!--col-lg-10-->
                                    </div><!--form control-->
                                </div>
                                <div class="col-md-4">

                                    <div class="form-group">
                                        {{ Form::label('password', trans('validation.attributes.backend.access.users.password'), ['class' => 'col-lg-12 control-label required']) }}

                                        <div class="col-lg-12">
                                            {{ Form::password('password', ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.users.password'), 'required' => 'required']) }}
                                        </div><!--col-lg-10-->
                                    </div><!--form control-->
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('password_confirmation', trans('validation.attributes.backend.access.users.password_confirmation'), ['class' => 'col-lg-12 control-label required']) }}

                                        <div class="col-lg-12">
                                            {{ Form::password('password_confirmation', ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.users.password_confirmation'), 'required' => 'required']) }}
                                        </div><!--col-lg-10-->
                                    </div><!--form control-->
                                </div>

                            </div>
                            @if ($user->id != 1)
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('status', trans('validation.attributes.backend.access.users.active'), ['class' => 'col-lg-3 control-label']) }}
                                        <label class="control control--checkbox" style="display: inline-block">
                                            {{ Form::checkbox('status', '1', true) }}
                                            <div class="control__indicator"></div>
                                        </label>

                                    </div><!--form control-->
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('confirmed', trans('validation.attributes.backend.access.users.confirmed'), ['class' => 'col-lg-4 control-label']) }}
                                        <label class="control control--checkbox">
                                            {{ Form::checkbox('confirmed', '1', true) }}
                                            <div class="control__indicator"></div>
                                        </label>

                                    </div><!--form control-->
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-lg-6 control-label">{{ trans('validation.attributes.backend.access.users.send_confirmation_email') }}<br/>
                                            <small>{{ trans('strings.backend.access.users.if_confirmed_off') }}</small>
                                        </label>
                                        <label class="control control--checkbox">
                                            {{ Form::checkbox('confirmation_email', '1') }}
                                            <div class="control__indicator"></div>
                                        </label>

                                    </div><!--form control-->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        {{ Form::label('status', trans('validation.attributes.backend.access.users.associated_roles'), ['class' => 'col-lg-12 control-label']) }}

                                        <div class="col-lg-8">
                                            @if (count($roles) > 0)
                                                @foreach($roles as $role)
                                                    <div>
                                                        <label for="role-{{$role->id}}" class="control control--radio">
                                                            <input type="radio" value="{{$role->id}}" name="assignees_roles[]" id="role-{{$role->id}}" class="get-role-for-permissions" {{ $role->id == 3 ? 'checked' : '' }} />  &nbsp;&nbsp;{!! $role->name !!}
                                                            <div class="control__indicator"></div>
                                                            <a href="#" data-role="role_{{ $role->id }}" class="show-permissions small">
                                                                (
                                                                <span class="show-text">{{ trans('labels.general.show') }}</span>
                                                                <span class="hide-text hidden">{{ trans('labels.general.hide') }}</span>
                                                                {{ trans('labels.backend.access.users.permissions') }}
                                                                )
                                                            </a>
                                                        </label>
                                                    </div>
                                                    <div class="permission-list hidden" data-role="role_{{ $role->id }}">
                                                        @if ($role->all)
                                                            {{ trans('labels.backend.access.users.all_permissions') }}<br/><br/>
                                                        @else
                                                            @if (count($role->permissions) > 0)
                                                                <blockquote class="small">
                                                                    @foreach ($role->permissions as $perm)
                                                                        {{$perm->display_name}}<br/>
                                                                    @endforeach
                                                                </blockquote>
                                                            @else
                                                                {{ trans('labels.backend.access.users.no_permissions') }}<br/><br/>
                                                            @endif
                                                        @endif
                                                    </div><!--permission list-->
                                                @endforeach
                                            @else
                                                {{ trans('labels.backend.access.users.no_roles') }}
                                            @endif
                                        </div><!--col-lg-3-->
                                    </div><!--form control-->

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        {{ Form::label('associated-permissions', trans('validation.attributes.backend.access.roles.associated_permissions'), ['class' => 'col-lg-12 control-label']) }}
                                        <div class="col-lg-10">
                                            <div id="available-permissions" class="hidden mt-20" style="width: auto; height: 200px; overflow-x: hidden; overflow-y: scroll;">
                                                <div class="row">
                                                    <div class="col-lg-12 get-available-permissions">

                                                    </div><!--col-lg-6-->
                                                </div><!--row-->
                                            </div><!--available permissions-->
                                        </div><!--col-lg-3-->
                                    </div><!--form control-->
                                </div>
                            </div>



                            @endif
                            <div class="edit-form-btn">
                                {{ link_to_route('admin.access.user.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                                {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                                <div class="clearfix"></div>
                            </div>
                        </div><!-- /.box-body -->
                    </div>
                </div>
                @if ($user->id == 1)
                    {{ Form::hidden('status', 1) }}
                    {{ Form::hidden('confirmed', 1) }}
                    {{ Form::hidden('assignees_roles[]', 1) }}
                @endif
                {{ Form::close() }}
            
        
@endsection

@section('after-scripts')
    <script type="text/javascript">
        Backend.Utils.documentReady(function(){
            csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            Backend.Users.selectors.getPremissionURL = "{{ route('admin.get.permission') }}";
            Backend.Users.init("edit");
        });
        window.onload = function () {
            Backend.Users.windowloadhandler();
        };

    </script>
@endsection
