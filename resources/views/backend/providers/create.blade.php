@extends ('backend.layouts.dashboard')

@section ('title', trans('labels.backend.providers.management') . ' | ' . trans('labels.backend.providers.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.providers.management') }}
        <small>{{ trans('labels.backend.providers.create') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.providers.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-provider']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.providers.create') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.providers.partials.providers-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!--box-header with-border-->

            <div class="box-body">
                <div class="form-group">
                    {{-- Including Form blade file --}}
                    @include("backend.providers.form")
                    <div class="edit-form-btn">
                        {{ link_to_route('admin.providers.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                        {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                        <div class="clearfix"></div>
                    </div><!--edit-form-btn-->
                </div><!-- form-group -->
            </div><!--box-body-->
        </div><!--box box-success-->
    {{ Form::close() }}
@endsection
@section('content-new')
    <div class="content-wrapper">
        <div class="row">

            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add New Provider</h4>

                        <form class="forms-sample">
                            <div class="row">
                                <div class="col-md-4">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="practice_name" placeholder="Title">
                            </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" name="first_name" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" name="last_name" placeholder="Last Name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>MI</label>
                                        <input type="text" class="form-control" name="mi" placeholder="MI">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Suffix</label>
                                        <input type="text" class="form-control" name="suffix" placeholder="Suffix">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>NPI</label>
                                        <input type="text" class="form-control" name="npi" placeholder="NPI">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Address 1</label>
                                        <input type="text" class="form-control" name="address_2" placeholder="Address 1">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Address 2</label>
                                        <input type="text" class="form-control" name="address_2" placeholder="Address 2">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" name="phone" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Fax</label>
                                        <input class="form-control phone-form" id="fax" data-inputmask="'alias': '999-999-9999'" name="fax" required>
                                        <img class="phone-field" src="{{ asset('img/images/us-flag.svg') }}" alt="">
                                        <div class="input-num">+1</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Website</label>
                                        <input type="text" class="form-control" name="website" placeholder="Website">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" class="form-control" placeholder="City" name="city">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>State</label>
                                        <div id="the-basics">
                                            <input class="typeahead form-control" type="text" placeholder="State" name="state" style="width: 100%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Zip</label>
                                        <input type="text" class="form-control" placeholder="Zip" name="zip">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Specialty</label>
                                        <select class="js-example-basic-single w-100" name="speciality">

                                            <option value="Anaesthesia">Anaesthesia</option>
                                            <option value="Paediatrics">Paediatrics</option>
                                            <option value="Assisted Living Facility">Assisted Living Facility</option>
                                            <option value="Dialysis Center">Dialysis Center</option>
                                            <option value="Emergency medicine">Emergency medicine</option>
                                            <option value="Family Medicine">Family Medicine</option>
                                            <option value="General surgery">General surgery</option>
                                            <option value="Geriatrics">Geriatrics</option>
                                            <option value="Hematology">Hematology</option>
                                            <option value="Hospital">Hospital</option>
                                            <option value="House Called">House Called</option>
                                            <option value="Internal medicine">Internal medicine</option>
                                            <option value="Multispecialty">Multispecialty</option>
                                            <option value="Neurology">Neurology</option>
                                            <option value="Nursing Home">Nursing Home</option>
                                            <option value="Obstetrics and gynaecology">Obstetrics and gynaecology</option>
                                            <option value="Pain Management">Pain Management</option>
                                            <option value="Pathology">Pathology</option>
                                            <option value="Psychiatry">Psychiatry</option>
                                            <option value="Radiology">Radiology</option>
                                            <option value="Rehabilitation Center">Rehabilitation Center</option>
                                            <option value="Surgery Center">Surgery Center</option>
                                            <option value="Urgent Care">Urgent Care</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Taxonomy Code</label>
                                        <input type="text" class="form-control" name="taxonomy_code" placeholder="Taxonomy Code">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Provider Type</label>
                                        <select class="form-control" >
                                            <option value="Rendering">Rendering</option>
                                            <option value="Billing">Billing</option>
                                            <option value="Rendering & Billing">Rendering & Billing</option>

                                        </select>

                                    </div>
                                </div>

                            </div>


                            <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                            <button class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>



        </div>
    </div>
@endsection
