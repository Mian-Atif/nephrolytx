@extends ('backend.layouts.backend')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.view'))

@section('page-header')
        {{ trans('labels.backend.access.users.management') }}
        <small>{{ trans('labels.backend.access.users.view') }}</small>
@endsection




@section('content-new')
    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">
                <h3 class="card-title">View Person</h3>
              {{--  <div class="box-tools text-right mb-3">
                    @include('backend.access.includes.partials.user-header-buttons')
                </div><!--box-tools pull-right-->--}}
                <div class="row">
                    <div class="col-md-12">
                        <ul class="profile-wrap mt-50">
                            <li>
                                <div class="profile-title">Name</div>
                                <div class="profile-desc">{{ (!is_null($person->name)?$person->name:'') }}</div>
                            </li>
                            <li>
                                <div class="profile-title">Email</div>
                                <div class="profile-desc">
                                    {{ (!is_null($person->email)?$person->email:'') }}
                                </div>
                            </li>

                            <li>
                                <div class="profile-title">Phone</div>
                                <div class="profile-desc">
                                    {{ (!is_null($person->phone)?$person->phone:'') }}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title">address 1</div>
                                <div class="profile-desc">
                                    {{ (!is_null($person->address1)?$person->address1:'') }}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title">address 2</div>
                                <div class="profile-desc">
                                    {{ (!is_null($person->address2)?$person->address2:'') }}
                                </div>
                            </li>

                            <li>
                                <div class="profile-title">{{ trans('labels.backend.access.users.tabs.content.overview.created_at') }}</div>
                                <div class="profile-desc">
                                    {{ $person->created_at }} ({{ $person->created_at->diffForHumans() }})
                                </div>
                            </li>
                            {{--<li>
                                <div class="profile-title">{{ trans('labels.backend.access.users.tabs.content.overview.last_updated') }}</div>
                                <div class="profile-desc">
                                    {{ $person->updated_at }} ({{ $person->updated_at->diffForHumans() }})
                                </div>
                            </li>--}}
{{--                            @if ($person->trashed())--}}
                            {{--<li>
                                <div class="profile-title">{{ trans('labels.backend.access.users.tabs.content.overview.deleted_at') }}</div>
                                <div class="profile-desc">
                                    {{ $person->deleted_at }} ({{ $person->deleted_at->diffForHumans() }})
                                </div>
                            </li>--}}
{{--                            @endif--}}

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection