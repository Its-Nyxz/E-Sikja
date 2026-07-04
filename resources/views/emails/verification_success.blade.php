<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Akun Berhasil Divalidasi</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; color: #333; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #e1e8ed;">
        <div style="background-color: #28a745; color: white; padding: 25px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px; font-weight: 600;">Pendaftaran Berhasil!</h1>
        </div>
        <div style="padding: 30px; line-height: 1.6;">
            <h2 style="color: #28a745; margin-top: 0;">Halo, {{ $user->name }}</h2>
            <p>Selamat! Akun Anda telah berhasil divalidasi dan diaktifkan oleh Administrator sistem **E-Sikja**.</p>
            <p>Sekarang Anda sudah dapat masuk ke dashboard dan menikmati layanan layanan administrasi kependudukan serta surat-menyurat secara online.</p>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/login') }}" style="background-color: #007bff; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; box-shadow: 0 2px 5px rgba(0,123,255,0.3);">
                    Masuk ke E-Sikja
                </a>
            </div>

            <p style="margin-bottom: 0;">Terima kasih atas partisipasi Anda.</p>
            <hr style="border: 0; border-top: 1px solid #eee; margin: 25px 0;">
            <p style="font-size: 12px; color: #777; text-align: center;">
                Email ini dikirim secara otomatis oleh sistem layanan kependudukan digital <strong>E-Sikja</strong>. Silakan abaikan jika merasa tidak melakukan pendaftaran.
            </p>
        </div>
    </div>
</body>
</html>
