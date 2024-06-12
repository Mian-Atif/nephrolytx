@extends ('backend.layouts.backend')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.view'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.access.users.management') }}
        <small>{{ trans('labels.backend.access.users.view') }}</small>
    </h1>
@endsection




@section('content-new')
    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">
                <h3 class="card-title">{{ trans('labels.backend.access.users.view') }}</h3>
                <div class="box-tools text-right mb-3">
                    @include('backend.access.includes.partials.user-header-buttons')
                </div><!--box-tools pull-right-->
                <div class="row">
                    <div class="col-md-12">
                        <ul class="profile-wrap mt-50">
                            <li>
                                <div class="profile-title">{{ trans('labels.backend.access.users.tabs.content.overview.name') }}</div>
                                <div class="profile-desc">{{ !is_null($user->person)?$user->person->name:'' }}</div>
                            </li>
                            <li>
                                <div class="profile-title">{{ trans('labels.backend.access.users.tabs.content.overview.email') }}</div>
                                <div class="profile-desc">
                                    {{ $user->email }}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title">{{ trans('labels.backend.access.users.tabs.content.overview.status') }}</div>
                                <div class="profile-desc">
                                    {!! $user->status_label !!}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title">{{ trans('labels.backend.access.users.tabs.content.overview.confirmed') }}</div>
                                <div class="profile-desc">
                                    {!! $user->confirmed_label !!}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title">Person Email</div>
                                <div class="profile-desc">
                                    {{ !is_null($user->person)?$user->person->email:'' }}
                                </div>
                            </li>
                            <li>
                                <div class="profile-title">Phone</div>
                                <div class="profile-desc">
                                    {{ !is_null($user->person)?$user->person->phone:'' }}
                                </div>
                            </li>

                            <li>
                                <div class="profile-title">Address 1</div>
                                <div class="profile-desc">
                                    {{ !is_null($user->person)?$user->person->address1:'' }}
                                </div>
                            </li>

                            <li>
                                <div class="profile-title">Address 2</div>
                                <div class="profile-desc">
                                    {{ !is_null($user->person)?$user->person->address2:'' }}
                                </div>
                            </li>

                            <li>
                                <div class="profile-title">{{ trans('labels.backend.access.users.tabs.content.overview.created_at') }}</div>
                                <div class="profile-desc">
                                    {{ $user->created_at }} ({{ $user->created_at->diffForHumans() }})
                                </div>
                            </li>
                            <li>
                                <div class="profile-title">{{ trans('labels.backend.access.users.tabs.content.overview.last_updated') }}</div>
                                <div class="profile-desc">
                                    {{ $user->updated_at }} ({{ $user->updated_at->diffForHumans() }})
                                </div>
                            </li>
                            @if ($user->trashed())
                                <li>
                                    <div class="profile-title">{{ trans('labels.backend.access.users.tabs.content.overview.deleted_at') }}</div>
                                    <div class="profile-desc">
                                        {{ $user->deleted_at }} ({{ $user->deleted_at->diffForHumans() }})
                                    </div>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection