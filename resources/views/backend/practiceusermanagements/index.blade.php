@extends ('backend.layouts.dashboard')

@section('content-new')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">User Management</h4>
                <div style="margin-left: 85%;">
                    <a href="{{ url('admin/practiceuseradd') }}" class="btn btn-primary mb-3">Add Practice User</a>
                </div>
                <div class="row">
                    <div class="col-sm-12">

                        <div class="table-responsive tableFixHead">
                            {{--                        <table class="table  no-footer" style="width: 100%;">--}}
                            <table id="order-listing" class="table">

                                <thead>
                                <tr class="table-color">
                                    <th><strong>#</strong></th>
                                    <th><strong>Name</strong></th>
                                    <th><strong>Email</strong></th>
                                    <th><strong> Phone</strong></th>
                                    <th><strong> Type</strong></th>
                                    <th class="text-center"><strong> Action</strong></th>
                                </tr>
                                </thead>
                                @if($users->users->count())
                                    <tbody>
                                    @foreach($users->users as $user)
                                        @if(!is_null($user->person))
                                            <tr class="text-white">
                                                <td>{{ $loop->iteration  }}</td>
                                                <td>{{ !is_null($user->person) ? $user->person->first_name.' '.$user->person->last_name : '' }}</td>
                                                <td>{{ !is_null($user->person) ? $user->person->email : '' }}</td>
                                                <td>{{ !is_null($user->person) ? $user->person->phone : '' }}</td>
                                                <td>
                                                    @if($user->roles()->first()->name == 'Practice')
                                                        Owner
                                                    @else
                                                        {{ !is_null($user->roles()->first()->name)? $user->roles()->first()->name : ''   }}

                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if(Auth::user()->id != $user->id)
                                                    <a href="{{ url('admin/change_user_status/'.$user->id) }}">
                                                        @if($user->status == 1)
                                                            <i class="fa fa-ban" aria-hidden="true"></i> Block
                                                        @else
                                                            unblock
                                                        @endif
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                    @endif
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No data found!</td>
                                        </tr>
                                    @endif

                                    </tbody>
                            </table>
                            {{--                        {{ $users->links() }}--}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after-scripts')

@endsection
