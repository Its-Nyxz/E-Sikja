@php
    $settingsPath = public_path('setting/settings.json');
    $setting = json_decode(file_get_contents($settingsPath), true) ?? [];
    $profile = $setting['profile'] ?? [];
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - {{ $setting['website_description'] }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 35px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-title {
            font-weight: 700;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 25px;
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #218838 0%, #1e7e34 100%);
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo text-center mb-3">
            <i class="fas fa-key fa-3x text-primary"></i>
        </div>
        <h3 class="login-title text-center">Reset Password</h3>

        {{-- ✅ Alert pesan dari session --}}
        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        {{-- ✅ Error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('auth.reset-password.post') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ old('email', $email) }}">

            <div class="mb-3">
                <label for="otp" class="form-label">Kode OTP</label>
                <input type="text" id="otp" name="otp"
                    class="form-control @error('otp') is-invalid @enderror" maxlength="6" required
                    placeholder="Masukkan kode OTP" value="{{ old('otp') }}">
                @error('otp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" id="password" name="password"
                    class="form-control @error('password') is-invalid @enderror" required
                    placeholder="Masukkan password baru">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                    required placeholder="Konfirmasi password baru">
            </div>

            <button type="submit" class="btn btn-success w-100">Perbarui Password</button>
        </form>

        <div class="footer-links mt-3 text-center">
            <a href="{{ route('login') }}" class="text-decoration-none text-primary">Kembali ke Login</a>
        </div>
    </div>
</body>

</html>
