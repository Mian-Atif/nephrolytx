@extends ('backend.layouts.backend')

@section ('title', trans('labels.backend.practices.management') . ' | ' . trans('labels.backend.access.users.view'))

@section('page-header')
        {{ trans('labels.backend.practices.management') }}
        <small>View Practice</small>
        <div>
            <button id="ajax-button">Ajax Button</button>
            <button class="sync-dashboard1">Sync</button>
        </div>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
        
        <script>
            $(document).ready(function() {
                $('#ajax-button').click(function() {
                    $.ajax({
                        url: '/admin/ajaxsync',
                        type: 'GET',
                        success: function(response) {
                            alert(response);
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                });
            });
            
        </script>
@endsection


@section('content-new')

                <div class="row">
                    <div class="col-md-12">
                        <ul class="profile-wrap mt-50">
                            <li>
                                <div class="profile-title">Name</div>
                                <div class="profile-desc">{{ (!is_null($practice->name)?$practice->name:'') }}</div>
                            </li>
                            <li>
                                <div class="profile-title">Email</div>
                                <div class="profile-desc">
                                    {{ (!is_null($practice->email)?$practice->email:'') }}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title">Specialties</div>
                                <div class="profile-desc">
                                    @if(!is_null($practice->specialities))
                                    @foreach($practice->specialities as $speciality)
                                    {{$speciality->name}},
                                        @endforeach
                                        @endif
                                </div>
                            </li>
                            <li>
                                <div class="profile-title"> Type</div>
                                <div class="profile-desc">
                                    {{!is_null($practice->type)?$practice->type:''}}
                                </div>
                            </li>

                            <li>

                                <div class="profile-title">Owner First Name</div>
                                <div class="profile-desc">
                                    {{!is_null($practice->person)?$practice->person->first_name:''}}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title"> Owner Last Name</div>
                                <div class="profile-desc">
                                    {{!is_null($practice->person)?$practice->person->middle_name:''}}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title"> Owner Middle Initial</div>
                                <div class="profile-desc">
                                    {{!is_null($practice->person)?$practice->person->middle_name:''}}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title"> Owner Email</div>
                                <div class="profile-desc">
                                    {{!is_null($practice->person)?$practice->person->email:''}}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title"> Owner Phone</div>
                                <div class="profile-desc">
                                    {{!is_null($practice->person)?$practice->person->phone:''}}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title"> Type</div>
                                <div class="profile-desc">
                                    {{!is_null($practice->type)?$practice->type:''}}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title"> Address 1</div>
                                <div class="profile-desc">
                                    {{!is_null($practice->detail)?$practice->detail->address_1:''}}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title"> Address 2</div>
                                <div class="profile-desc">
                                    {{!is_null($practice->detail)?$practice->detail->address_2:''}}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title"> City</div>
                                <div class="profile-desc">
                                    {{!is_null($practice->detail)?$practice->detail->city:''}}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title"> State</div>
                                <div class="profile-desc">
                                    {{!is_null($practice->detail)?$practice->detail->state:''}}
                                </div>
                            </li>

                            <li>
                                <div class="profile-title"> Phone</div>
                                <div class="profile-desc">
                                    {{!is_null($practice->detail)?$practice->detail->phone:''}}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title"> Fax</div>
                                <div class="profile-desc">
                                    {{!is_null($practice->detail)?$practice->detail->fax:''}}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title"> Website</div>
                                @if(!is_null($practice->detail))
                                <a href="{{url($practice->detail->website)}}">
                                    {{$practice->detail->website}}</a>
                                    @endif
                            </li>
                            <li>
                                <div class="profile-title"> Zip Code</div>
                                <div class="profile-desc">
                                    {{!is_null($practice->detail)?$practice->detail->zip_code:''}}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title"> NPI</div>
                                <div class="profile-desc">
                                    {{!is_null($practice->detail)?$practice->detail->npi:''}}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title"> Tax ID</div>
                                <div class="profile-desc">
                                    {{!is_null($practice)?$practice->tax_id:''}}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title">{{ trans('labels.backend.access.users.tabs.content.overview.created_at') }}</div>
                                <div class="profile-desc">
                                    {{ !is_null($practice)?$practice->created_at:'' }} ({{ $practice->created_at->diffForHumans() }})
                                </div>
                            </li>
                            {{--<li>
                                <div class="profile-title">{{ trans('labels.backend.access.users.tabs.content.overview.last_updated') }}</div>
                                <div class="profile-desc">
                                    {{ $practice->updated_at }} ({{ $practice->updated_at->diffForHumans() }})
                                </div>
                            </li>--}}
{{--                            @if ($practice->trashed())--}}
                            {{--<li>
                                <div class="profile-title">{{ trans('labels.backend.access.users.tabs.content.overview.deleted_at') }}</div>
                                <div class="profile-desc">
                                    {{ $practice->deleted_at }} ({{ $practice->deleted_at->diffForHumans() }})
                                </div>
                            </li>--}}
{{--                            @endif--}}

                        </ul>
                    </div>
                </div>

                <script>
            $(document).ready(function() {
                $('#ajax-button').click(function() {
                    $.ajax({
                        url: '/ajax',
                        type: 'GET',
                        success: function(response) {
                            alert(response);
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                });
            });
</script>
@endsection