@extends ('backend.layouts.backend')

@section ('title', trans('labels.backend.access.roles.management') . ' | ' . trans('labels.backend.access.roles.edit'))

@section('page-header')
        {{ trans('labels.backend.access.roles.management') }}
        <small>{{ trans('labels.backend.access.roles.edit') }}</small>
@endsection

@section('content-new')
    <div class="box-tools pull-right" style="margin-top: -34px;">
        @include('backend.access.includes.partials.role-header-buttons')
    </div><!--box-tools pull-right-->
    {{ Form::model($role, ['route' => ['admin.access.role.update', $role], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-role']) }}

        <div class="card">

            <div class="card-body" style="padding: 0;">
              <div class="row">
                  <div class="col-sm-4">
                      <div class="form-group">
                          {{ Form::label('name', trans('validation.attributes.backend.access.roles.name'), ['class' => ' control-label required']) }}
                          {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.roles.name'), 'required' => 'required']) }}
                      </div><!--form control-->
                  </div>

                  <div class="col-sm-4">
                      <div class="form-group">
                          {{ Form::label('sort', trans('validation.attributes.backend.access.roles.sort'), ['class' => 'control-label']) }}
                          {{ Form::text('sort', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.roles.sort')]) }}
                      </div><!--form control-->
                  </div>

                  <div class="col-sm-12">
                      <div class="form-group">
                          {{ Form::label('associated_permissions', trans('validation.attributes.backend.access.roles.associated_permissions'), ['class' => ' control-label']) }}
                          {{ Form::hidden('associated_permissions','custom')  }}
                          <div id="available-permissions" class="hidden mt-20" style="width: 700px; height: 200px; overflow-x: hidden; overflow-y: scroll;">
                              <div class="">
                                  <div class="col-xs-12">
                                      @if ($permissions->count())
                                          @foreach ($permissions as $perm)
                                              <label class="control control--checkbox">
                                                  <input type="checkbox" name="permissions[{{ $perm->id }}]" value="{{ $perm->id }}" id="perm_{{ $perm->id }}" {{ is_array(old('permissions')) ? (in_array($perm->id, old('permissions')) ? 'checked' : '') : (in_array($perm->id, $rolePermissions) ? 'checked' : '') }} /> <label for="perm_{{ $perm->id }}">{{ $perm->display_name }}</label>
                                                  <div class="control__indicator"></div>
                                              </label>
                                              <br/>
                                          @endforeach
                                      @else
                                          <p>There are no available permissions.</p>
                                      @endif
                                  </div><!--col-lg-6-->
                              </div><!--row-->
                          </div><!--available permissions-->

                      </div><!--form control-->

                  </div>
              </div>

                <div class="edit-form-btn">
                    {{ link_to_route('admin.access.role.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                    <div class="clearfix"></div>
                </div>
            </div><!-- /.box-body -->
        </div><!--box-->
    {{ Form::close() }}
@endsection

@section('after-scripts')
    
    <script type="text/javascript">
        Backend.Utils.documentReady(function(){
             Backend.Roles.init("edit")
        });
    </script>
@endsection