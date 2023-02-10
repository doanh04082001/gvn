@component('mail::message')

# {{ __('web.contact.you_recieve') }}

<p><label>{{ __('web.contact.sender_namer') }}</label> {{ $mailData['name'] }}</p>
<p><label>{{ __('web.contact.sender_email') }} </label> {{ $mailData['email'] }}</p>
<p><label>{{ __('web.contact.sender_phone') }} </label> {{ $mailData['phone'] }}</p>
<p><label>{{ __('web.contact.sender_content') }} </label></p>
<p> {{ $mailData['content'] }}</p>

@component('mail::button', ['color' => 'success', 'url' => env('APP_URL', '#')])
	{{ __('web.contact.back_web_page') }}
@endcomponent

Thanks,<br>

{{ config('app.name') }}
@endcomponent
