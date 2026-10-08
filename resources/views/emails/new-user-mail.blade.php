<x-mail::message>
# Welcome {{ $payload['fullname'] }}

Your account has been successfully created. You can change this password after you sign in, from your profile.

<x-mail::panel>
**Login email:** {{ $payload['username'] }}  
**Password:** {{ $payload['password'] }}
</x-mail::panel>

<x-mail::button :url="config('drip.base_url')">
Login Now
</x-mail::button>

Thanks,  
{{ config('app.name') }}
</x-mail::message>