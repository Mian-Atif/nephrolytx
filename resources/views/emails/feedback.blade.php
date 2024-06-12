@extends('emails.layouts.app')

@section('content')
<div class="content">
    <td align="left">
        <table border="0" width="80%" align="center" cellpadding="0" cellspacing="0" class="container590">
            <tr>
                <td align="left" style="color: #888888; width:20px; font-size: 16px; line-height: 24px;">
                    <!-- section text ======-->

                    <p style="line-height: 24px; margin-bottom:15px;">
                        Feedback Form
                    </p>

                    <p style="line-height: 24px; margin-bottom:15px;">
                        <strong>Name: </strong> John Doe <br/>
                        <strong>Email: </strong> John Doe <br/>
                        <strong>Suggestion: </strong> Description here 
                    </p>

                    <p style="line-height: 24px">
                        Regards,</br>
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
                        