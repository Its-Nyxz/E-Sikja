<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kode OTP Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>Halo, {{ $user->name }}</h2>
    <p>Kamu baru saja meminta reset password untuk akun kamu.</p>
    <p>Kode OTP kamu adalah:</p>

    <h1 style="background-color:#007bff;color:white;padding:10px;text-align:center;letter-spacing:4px;">
        {{ $otp }}
    </h1>

    <p>Kode ini berlaku selama <strong>5 menit</strong>.</p>
    <p>Jika kamu tidak meminta reset password, abaikan email ini.</p>
    <hr>
    <p>Salam, <br><strong>{{ config('app.name') }}</strong></p>
</body>
</html>
