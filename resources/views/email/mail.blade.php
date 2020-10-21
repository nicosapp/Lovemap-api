@component('email.includes.message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if (isset($level) && $level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello') @isset($user){{ $user->name }}@endisset!
@endif
@endif

{{-- Intro Lines --}}
@isset($introLines)
@foreach ($introLines as $line)
{{ $line }}

@endforeach
@endisset
{{-- Action Button --}}
@isset($actionText)
<?php
switch ($level) {
  case 'success':
  case 'error':
    $color = $level;
    break;
  default:
    $color = 'primary';
}
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

@isset($outroLines)
{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach
@endisset
{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
"If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
'into your web browser:',
[
'actionText' => $actionText,
]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent

