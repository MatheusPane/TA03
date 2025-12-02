<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk • Sistem Dasawisma PKK</title>

    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .login-container {
            display: flex;
            max-width: 900px;
            width: 100%;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .login-sidebar {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            padding: 3rem 2rem;
            color: white;
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-sidebar h4 {
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        .login-sidebar p {
            opacity: 0.9;
            font-size: 0.95rem;
            line-height: 1.6;
        }
        .logo-badge {
            background: rgba(255,255,255,0.2);
            width: 70px;
            height: 70px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
        }
        .logo-badge i { font-size: 2.5rem; }
        .login-form {
            padding: 3rem 2.5rem;
            width: 60%;
        }
        .form-control {
            border: 1.5px solid #dee2e6;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
        .btn-login {
            background: linear-gradient(to right, #0d6efd, #0a58ca);
            border: none;
            border-radius: 10px;
            padding: 0.8rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
        }
        .footer-text {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px dashed #dee2e6;
        }
        @media (max-width: 768px) {
            .login-container { flex-direction: column; }
            .login-sidebar, .login-form { width: 100%; }
            .login-sidebar { padding: 2.5rem 2rem; text-align: center; }
        }
    </style>
</head>
<body>

<div class="login-container">
    <!-- Sidebar Kiri -->
    <div class="login-sidebar">
        <div class="logo-badge">
            <i class="bi bi-shield-check"></i>
        </div>
        <h4>Sistem Dasawisma PKK</h4>
        <p>Sistem Informasi Pembinaan Kesejahteraan Keluarga untuk pengelolaan data warga, keluarga, dan kegiatan PKK secara terpadu.</p>
    </div>

    <!-- Form Login -->
    <div class="login-form">
        <h5 class="fw-bold">Selamat Datang Kembali!</h5>
        <p class="text-muted mb-4">Silakan masuk menggunakan akun Anda</p>

        <!-- Session Status (jika ada pesan sukses) -->
        @if (session('status'))
            <div class="alert alert-success rounded mb-4 small">
                {{ session('status') }}
            </div>
        @endif

        <!-- Error Login Gagal -->
        @if ($errors->has('email') || $errors->has('password'))
            <div class="alert alert-danger rounded mb-4 small">
                Email atau kata sandi yang Anda masukkan salah.
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email / Username -->
            <div class="mb-4">
                <label class="form-label fw-medium">Email atau Username</label>
                <input type="text" name="email" class="form-control" 
                       value="{{ old('email') }}" required autofocus autocomplete="username"
                       placeholder="contoh@email.com">
                @error('email')
                    <small class="text-danger mt-1">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="form-label fw-medium">Kata Sandi</label>
                <input type="password" name="password" class="form-control" 
                       required autocomplete="current-password"
                       placeholder="••••••••">
                @error('password')
                    <small class="text-danger mt-1">{{ $message }}</small>
                @enderror
            </div>

            <!-- Remember Me & Lupa Password -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label text-sm" for="remember">
                        Ingat saya
                    </label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline">
                        Lupa kata sandi?
                    </a>
                @endif
            </div>

            <!-- Tombol Masuk -->
            <button type="submit" class="btn btn-login text-white w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>
                Masuk ke Dashboard
            </button>
        </form>

        <!-- Footer -->
        <div class="footer-text text-center">
            <p class="mb-1">Dinas Pemberdayaan Perempuan, Perlindungan Anak<br>dan Keluarga Berencana</p>
            <p class="mb-0">© {{ date('Y') }} • Sistem Informasi Dasawisma PKK</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>