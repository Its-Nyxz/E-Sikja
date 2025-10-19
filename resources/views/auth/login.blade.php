@php
    $settingsPath = public_path('setting/settings.json');
    $setting = json_decode(file_get_contents($settingsPath), true) ?? [];
    $profile = $setting['profile'] ?? [];
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ $setting['website_description'] }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
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
            max-width: 450px;
            padding: 40px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo img {
            max-width: 120px;
            height: auto;
        }

        .login-title {
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 30px;
            text-align: center;
            font-size: 1.8rem;
        }

        .form-label {
            font-weight: 600;
            color: #34495e;
            margin-bottom: 8px;
        }

        .form-control {
            padding: 12px 15px;
            height: auto;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 8px 0 0 8px;
        }

        .input-group .form-control {
            border-radius: 0 8px 8px 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #357abd 0%, #2c6aa0 100%);
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .footer-links {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .footer-links a {
            color: #4a90e2;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: #357abd;
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 30px 20px;
            }

            .login-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="login-container">
                    <div class="logo">
                        <i class="fas fa-envelope-open-text fa-3x text-primary"></i>
                    </div>
                    <h3 class="login-title">{{ $setting['website_description'] }}</h3>

                    {{-- ✅ ALERT ERROR / SUCCESS --}}
                    @if (session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- ✅ ALERT COUNTDOWN --}}
                    @if (isset($isLocked) && $isLocked)
                        <div class="alert alert-warning">
                            <i class="fas fa-clock me-2"></i>
                            Terlalu banyak percobaan gagal. Silakan coba lagi dalam
                            <strong id="countdown">{{ $remainingSeconds }}</strong> detik.
                        </div>
                    @endif

                    {{-- ✅ FORM LOGIN --}}
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ old('username') }}" placeholder="Masukkan username Anda" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Masukkan password Anda" required>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </div>
                    </form>

                    <div class="footer-links">
                        <p class="mb-2">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
                        <p class="mb-0"><a href="{{ route('auth.forgot-password') }}">Lupa Password?</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- ✅ SCRIPT COUNTDOWN --}}
    @if (isset($isLocked) && $isLocked)
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let remaining = {{ $remainingSeconds }};
                const countdownEl = document.getElementById('countdown');

                const timer = setInterval(() => {
                    if (remaining > 0) {
                        countdownEl.textContent = remaining;
                        remaining--;
                    } else {
                        clearInterval(timer);
                        countdownEl.parentElement.innerHTML =
                            '<i class="fas fa-check-circle text-success me-2"></i> Anda bisa mencoba login sekarang.';
                    }
                }, 1000);
            });
        </script>
    @endif
</body>

</html>
