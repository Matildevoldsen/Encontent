@component('mail::message')
# Welcome to {{ config('app.name') }}

<p>Your account has been registered under the name <strong>{{ $user->name }}</strong> on the following email address <strong>{{ $user->email }}</strong></p>

Please verify your user through the email verification email we sent you.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
