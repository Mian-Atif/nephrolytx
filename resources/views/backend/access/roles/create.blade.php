@extends ('backend.layouts.backend')

@section ('title', trans('labels.backend.access.roles.management') . ' | ' . trans('labels.backend.access.roles.create'))

@section('page-header')

        {{ trans('labels.backend.access.roles.management') }}
        <small>{{ trans('labels.backend.access.roles.create') }}</small>

@endsection

@section('content-new')
    <div class="box-tools text-right" style="margin-bottom: -34px;">
        @include('backend.access.includes.partials.role-header-buttons')
    </div><!--box-tools pull-right-->
    {{ Form::open(['route' => 'admin.access.role.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-role']) }}

        <div class="card">
            <div class="card-body" style="padding: 0;">
               <div class="row">
                   <div class="col-sm-4">
                       <div class="form-group">
                           {{ Form::label('name', trans('validation.attributes.backend.access.roles.name'), ['class' => ' control-label required']) }}

                           <div class="">
                               {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.roles.name'), 'required' => 'required']) }}
                           </div><!--col-lg-10-->
                       </div><!--form control-->
                   </div>

                   <div class="col-sm-4">
                       <div class="form-group">
                           {{ Form::label('sort', trans('validation.attributes.backend.access.roles.sort'), ['class' => ' control-label']) }}

                           <div class="">
                               {{ Form::text('sort', ($roleCount+1), ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.roles.sort')]) }}
                           </div><!--col-lg-10-->
                       </div><!--form control-->
                   </div>

                   <div class="col-sm-12">
                       <div class="form-group">
                           {{ Form::label('associated_permissions', trans('validation.attributes.backend.access.roles.associated_permissions'), ['class' => ' control-label']) }}
                           {{ Form::hidden('associated_permissions','custom')  }}
                           <div class="">

                               <div id="available-permissions" class="hidden mt-20" style="width: 700px; height: 200px; overflow-x: hidden; overflow-y: scroll;">
                                   <div class="">
                                       <div class="">
                                           @if ($permissions->count())
                                               @foreach ($permissions as $perm)
                                                   <label class="control ">
                                                       <input type="checkbox" name="permissions[{{ $perm->id }}]" value="{{ $perm->id }}" id="perm_{{ $perm->id }}" {{ is_array(old('permissions')) && in_array($perm->id, old('permissions')) ? 'checked' : '' }} /> <label for="perm_{{ $perm->id }}">{{ $perm->display_name }}</label>

                                                   </label>
                                                   <br/>
                                               @endforeach
                                           @else
                                               <p>There are no available permissions.</p>
                                           @endif
                                       </div><!--col-lg-6-->
                                   </div><!--row-->
                               </div><!--available permissions-->
                           </div><!--col-lg-3-->
                       </div><!--form control-->
                   </div>

                   <div class="col-sm-12">
                       <div class="form-group">
                           {{ Form::label('status', trans('validation.attributes.backend.access.roles.active'), ['class' => ' control-label']) }}

                           <div class="">
                               <div class="control-group">
                                   <label class="control control--checkbox">
                                       {{ Form::checkbox('status', 1, true) }}
                                       <div class="control__indicator"></div>
                                   </label>
                               </div>
                           </div><!--col-lg-3-->
                       </div><!--form control-->
                   </div>
               </div>
                <div class="edit-form-btn">
                    {{ link_to_route('admin.access.role.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                    <div class="clearfix"></div>
                </div>
            </div><!-- /.box-body -->
        </div><!--box-->
    {{ Form::close() }}
@endsection

@section('after-scripts')
    {{ Html::script('js/backend/access/roles/script.js') }}
     <script type="text/javascript">
         Backend.Utils.documentReady(function(){
             Backend.Roles.init("rolecreate")
        });
    </script>
@endsection
