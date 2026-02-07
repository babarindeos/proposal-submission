<x-mail::message>
# Welcome {{ $payload['fullname'] }}

Your account has been successfully created.

<x-mail::panel>
**Username:** {{ $payload['username'] }}  
**Password:** {{ $payload['password'] }}
</x-mail::panel>

<x-mail::button :url="url('/')">
Login Now
</x-mail::button>

Thanks,  
{{ config('app.name') }}
</x-mail::message>