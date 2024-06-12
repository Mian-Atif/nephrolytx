@extends('emails.layouts.app')

@section('content')
    <div class="content">
        <p style="line-height: 24px; margin-bottom:15px;">
            Hello, {{  $user->name }}!
        </p>

        <p style="line-height: 24px; margin-bottom:20px;">
           Click below to confirm your email address
             </p>

        <p>

            URL:  <a href="{{ url('/verify-email/'.$user->confirmation_code) }}" target="_blank" class="lap">
                {{ url('/verify-email/'.$user->confirmation_code) }}
            </a>
        </p>


        <br><br>
        <p style="line-height: 24px; margin-bottom:20px;">
            Thank You. <br>
            Customer Relationship Team
        </p>


        <br/>

        @include('emails.layouts.footer')

    </div>
@endsection
