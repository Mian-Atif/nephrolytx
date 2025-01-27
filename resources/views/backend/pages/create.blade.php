@extends ('backend.layouts.backend')

@section ('title', trans('labels.backend.pages.management') . ' | ' . trans('labels.backend.pages.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.pages.management') }}
        <small>{{ trans('labels.backend.pages.create') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.pages.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-permission']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.pages.create') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.pages.partials.pages-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('title', trans('validation.attributes.backend.pages.title'), ['class' => 'col-lg-2 control-label required']) }}

                    <div class="col-lg-10">
                        {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.pages.title'), 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('description', trans('validation.attributes.backend.pages.description'), ['class' => 'col-lg-2 control-label required']) }}

                    <div class="col-lg-10">
                        {{ Form::textarea('description', null,['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.pages.description')]) }}
                    </div><!--col-lg-3-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('cannonical_link', trans('validation.attributes.backend.pages.cannonical_link'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('cannonical_link', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.pages.cannonical_link')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('seo_title', trans('validation.attributes.backend.pages.seo_title'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('seo_title', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.pages.seo_title')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('seo_keyword', trans('validation.attributes.backend.pages.seo_keyword'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('seo_keyword', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.pages.seo_keyword')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('seo_description', trans('validation.attributes.backend.pages.seo_description'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::textarea('seo_description', null,['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.pages.seo_description')]) }}
                    </div><!--col-lg-3-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('status', trans('validation.attributes.backend.pages.is_active'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        <div class="control-group">
                            <label class="control control--checkbox">
                                {{ Form::checkbox('status', 1, true) }}
                                <div class="control__indicator"></div>
                            </label>
                        </div>
                    </div><!--col-lg-3-->
                </div><!--form control-->
                <div class="edit-form-btn">
                    {{ link_to_route('admin.pages.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                    <div class="clearfix"></div>
                </div>
            </div><!-- /.box-body -->
        </div><!--box-->
    {{ Form::close() }}
@endsection



@section('content-new')
    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">
                <h3 class="card-title">{{ trans('labels.backend.pages.create') }}</h3>
                <div class="box-tools text-right">
                    @include('backend.pages.partials.pages-header-buttons')
                </div><!--box-tools pull-right-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-body">
                            {{ Form::open(['route' => 'admin.pages.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-permission']) }}

                            <div class="row">




                            </div>
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('title', trans('validation.attributes.backend.pages.title'), ['class' => 'col-lg-12 control-label required']) }}

                                        <div class="col-lg-12">
                                            {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.pages.title'), 'required' => 'required']) }}
                                        </div><!--col-lg-10-->
                                    </div><!--form control-->

                                </div>

                                <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::label('cannonical_link', trans('validation.attributes.backend.pages.cannonical_link'), ['class' => 'col-lg-12 control-label']) }}

                                    <div class="col-lg-12">
                                        {{ Form::text('cannonical_link', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.pages.cannonical_link')]) }}
                                    </div><!--col-lg-10-->
                                </div><!--form control-->
                                </div>

                                <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::label('seo_title', trans('validation.attributes.backend.pages.seo_title'), ['class' => 'col-lg-12 control-label']) }}

                                    <div class="col-lg-12">
                                        {{ Form::text('seo_title', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.pages.seo_title')]) }}
                                    </div><!--col-lg-10-->
                                </div><!--form control-->
                                </div>
                                <div class="col-md-3">
                                <div class="form-group">
                                    {{ Form::label('seo_keyword', trans('validation.attributes.backend.pages.seo_keyword'), ['class' => 'col-lg-12 control-label']) }}

                                    <div class="col-lg-12">
                                        {{ Form::text('seo_keyword', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.pages.seo_keyword')]) }}
                                    </div><!--col-lg-10-->
                                </div><!--form control-->
                                </div>



                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{ Form::label('description', trans('validation.attributes.backend.pages.description'), ['class' => 'col-lg-12 control-label required']) }}

                                        <div class="col-lg-12">
                                            {{ Form::textarea('description', null,['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.pages.description')]) }}
                                        </div><!--col-lg-3-->
                                    </div><!--form control-->
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{ Form::label('seo_description', trans('validation.attributes.backend.pages.seo_description'), ['class' => 'col-lg-12 control-label']) }}

                                        <div class="col-lg-12">
                                            {{ Form::textarea('seo_description', null,['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.pages.seo_description')]) }}
                                        </div><!--col-lg-3-->
                                    </div><!--form control-->
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('status', trans('validation.attributes.backend.pages.is_active'), ['class' => 'col-lg-12 control-label']) }}

                                        <div class="col-lg-12">
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
                                {{ link_to_route('admin.pages.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                                {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                                <div class="clearfix"></div>
                            </div>

                            {{ Form::close() }}
                        </div><!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section("after-scripts")
    <script type="text/javascript">
        Backend.Pages.init('{{ config('locale.languages.' . app()->getLocale())[1] }}');
    </script>
@endsection
