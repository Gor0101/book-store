@component('mail::message')
# BookStore

Please verify your email

@component('mail::button', ['url' => $url])
Verify my email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
