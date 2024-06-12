@extends ('backend.layouts.backend')



@section('content-new')

    <div class="container pt-4 pb-3 practice-card">
        <div class="box-tools text-right" >
            <a   class="btn btn-info practice-btn ml-3 mb-4" href="{{ url('admin/addPracticeUser/'.$practice->id) }}">Add Practice User <i class="fas fa-user-plus" aria-hidden="true"></i></a>

        </div>

        @if ($errors->any())
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if(session()->has('message'))
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                </div>
            </div>

        @endif
    <div class="table-responsive tableFixHead">
        <table id="order-listing" class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th>Type</th>
                <th class="text-center">Action</th>

            </tr>
            </thead>
            <tbody>
            @if($practice->users->count())
                @foreach($practice->users as $user)
                    @if(!is_null($user->person))
                    <tr class="billingindex{{$user->person->id}}">
                        <th>{{ $loop->iteration }}</th>
                        <td>{{!is_null($user->person)? $user->person->first_name.' '.$user->person->last_name:'' }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                          {{--  @if($user->roles()->first()->name == 'Practice')
                                Owner
                            @else
                                {{ !is_null($user->roles()->first()->name)? $user->roles()->first()->name : ''   }}

                            @endif--}}
                        </td>
                        <td class="text-center">
                            <a style="color: #fff;"  href="{{ url('admin/pratice_user_status/'.$user->id) }}">
                                @if($user->status == 1)
                                    <i class="fa fa-ban" aria-hidden="true"></i> Block
                                @else
                                    unblock
                                @endif
                            </a>
                        </td>

                    </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">No Data Found!</td>
                </tr>
            @endif

            </tbody>
        </table>
        </div>
    </div>
@endsection

@section('after-scripts')
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script>
        $(document).on("click",".DeleteDoctor",function() {
            if (confirm('Are you sure you want to delete?')) {
                var url = $(this).data('url');
                var id = $(this).data('id');
                $.ajax({
                    type:'GET',
                    url:url,
                    data:'_token = <?php echo csrf_token() ?>',
                    beforeSend: function() {
                        $('.DeleteDoctor'+id).html('<i class="fas fa-cog fa-spin" aria-hidden="true"></i>');
                    },
                    success:function(responce) {
                        if(responce.code == 1){
                            $('.deoctorindex'+id).remove();
                        }
                    },
                    complete: function() {
                        $('.DeleteDoctor'+id).html('<i class="fas fa-trash-alt" aria-hidden="true"></i>');
                    }
                });
            }
        });


        $(document).on("click",".DeleteBilling",function() {
            if (confirm('Are you sure you want to delete?')) {
                var url = $(this).data('url');
                var id = $(this).data('id');
                $.ajax({
                    type:'GET',
                    url:url,
                    data:'_token = <?php echo csrf_token() ?>',
                    beforeSend: function() {
                        $('.DeleteBilling'+id).html('<i class="fas fa-cog fa-spin" aria-hidden="true"></i>');
                    },
                    success:function(responce) {
                        if(responce.code == 1){
                            $('.billingindex'+id).remove();
                        }
                    },
                    complete: function() {
                        $('.DeleteBilling'+id).html('<i class="fas fa-trash-alt" aria-hidden="true"></i>');
                    }
                });
            }
        });

    </script>
@endsection