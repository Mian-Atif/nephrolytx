@extends('emails.layouts.app')

@section('content')
    <div class="content">
        <td align="left">
            <table border="0" width="80%" align="center" cellpadding="0" cellspacing="0" class="container590">
                <tr>
                    <td align="left" style="color: #888888; width:20px; font-size: 16px; line-height: 24px;">
                        <!-- section text ======-->

                        <p style="line-height: 24px; margin-bottom:15px;">
                            Hello, {{ !is_null($user->person) ? $user->person->name : ''}}!
                        </p>

                        <p style="line-height: 24px; margin-bottom:20px;">
                            Your Account has successfully been created on {{ app_name() }}. Your Login Details are in below section.
                        </p>

                        <table border="1px">
{{--                            <tr>--}}
{{--                                <th>Login URL:</th>--}}
{{--                                <td><a href="{{ url('/login') }}">Click to login!</a></td>--}}
{{--                            </tr>--}}
                            <tr>
                                <th>Email:</th>
                                <td>{{ $user->email }}</td>
                            </tr>
{{--                            <tr>--}}
{{--                                <th>Password:</th>--}}
{{--                                <td>{{ $password }}</td>--}}
{{--                            </tr>--}}
                            <tr>
                                <th>Reset Password</th>
{{--                                <td><a href="{{ $url }}">click to reset {{$url}}</a></td>--}}
                                <td><a href="{{ url('/password/reset',$token) }}">click to reset</a></td>
                            </tr>
                        </table>

                        <p style="line-height: 24px; margin-bottom:20px;">
                        </p>

                        <p style="line-height: 24px">
                            Regards,<br/>
                            <br/>
                            @yield('title', app_name())
                        </p>

                        <br/>

                        @include('emails.layouts.footer')
                    </td>
                </tr>
            </table>
        </td>
    </div>
@endsection
