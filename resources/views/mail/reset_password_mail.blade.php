Hi {{ $user->name }}, <br>
Akun Anda meminta reset password pada {{$resetPassword->created_at}} <br>
@php
    $link = route('fp.new.form');
    $link .= '?email=';
    $link .= $user->email; 
    $link .= '&token=';
    $link .= $resetPassword->token;
@endphp
Klik Link dibawah ini untuk melakukan Reset Password <br>
<a target="_blank" href="{{ $link }}">Reset Password</a>
<br>
Link akan expired pada {{ $resetPassword->expired }}