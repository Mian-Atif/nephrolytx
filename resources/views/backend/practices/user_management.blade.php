@extends ('backend.layouts.backend')

@section ('title', trans('labels.backend.practices.management') . ' | ' . trans('labels.backend.practices.create'))

@section('page-header')

        Practice User
        <small>Users</small>


@endsection
@section('after-styles')
    {{--<link rel="stylesheet" href="{{asset('libraries/phoneApi/css/demo.css')}}">--}}
    {{--<link rel="stylesheet" href="{{asset('libraries/phoneApi/css/intlTelInput.css')}}">--}}
    {{--    <link rel="stylesheet" href="build/css/intlTelInput.css">--}}

@endsection

@section('content-new')

    <div class="container pt-4 pb-3 practice-card">
        <div class="box-tools text-right" >
            <a   class="btn btn-info practice-btn ml-3" href="{{ url('admin/addPracticeUser/'.$practice->id) }}">Add Practice User <i class="fas fa-user-plus" aria-hidden="true"></i></a>

        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th>Type</th>
                <th>Action</th>

            </tr>
            </thead>
            <tbody>
            @if(isset($practiceUsers) && count($practiceUsers) > 0)
                @php $i=1 @endphp
                @foreach($practiceUsers as $user)
                    <tr class="billingindex{{$user->person->id}}">
                        <th scope="row">{{$i}}</th>
                        <td>{{ $user->person->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->roles()->first()->name == 'Practice')
                                Owner
                            @else
                                {{ !is_null($user->roles()->first()->name)? $user->roles()->first()->name : ''   }}

                            @endif
                        </td>
                        <td>
                        <td class="text-center">
                            <a  href="{{ url('admin/change_user_status/'.$user->id) }}">
                                @if($user->status == 1)
                                    <i class="fa fa-ban" aria-hidden="true"></i> Block
                                @else
                                    unblock
                                @endif
                            </a>
                        </td>
                        </td>

                    </tr>
                    @php $i++ @endphp
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">No Data Found!</td>
                </tr>
            @endif

            </tbody>
        </table>
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