Hi {{ $user->name }}, <br>
Silahkan aktivasi email anda dengan klik link dibawah ini <br>

@php
    $link = route('register.verify');
    $link .= '?email=';
    $link .= $user->email;
    $link .= '&otp=';
    $link .= $userVerification->otp;
@endphp

<a target="_blank" href="{{ $link }}">Verifikasi Email</a> <br>
Link akan expired pada {{ $userVerification->expired }}.
