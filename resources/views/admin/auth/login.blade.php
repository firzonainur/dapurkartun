<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin - Dapur Kartun</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #1F1135 0%, #351E5C 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            min-height: 100vh;
        }
        .login-card {
            background-color: #FFFFFF;
            border-radius: 16px;
            padding: 2.5rem;
            max-width: 440px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border: 3px solid #1F1135;
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header img {
            margin: 0 auto 1rem;
        }
        .login-header h2 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1F1135;
        }
        .login-header p {
            font-size: 0.9rem;
            color: #64748B;
        }
        .demo-credentials {
            background-color: #FFF7ED;
            border: 1px solid #FFEDD5;
            border-radius: 8px;
            padding: 0.85rem;
            margin-bottom: 1.5rem;
            font-size: 0.825rem;
            color: #9A3412;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('images/logo.svg') }}" alt="Dapur Kartun" width="200" height="50">
            <h2>Masuk Panel Admin</h2>
            <p>Kelola konten, galeri, slider, dan pesan masuk studio.</p>
        </div>

        <div class="demo-credentials">
            <strong>Kredensial Default:</strong><br>
            Email: <code>admin@dapurkartun.id</code><br>
            Kata Sandi: <code>password123</code>
        </div>

        @if($errors->any())
            <div style="background-color: #FEE2E2; color: #991B1B; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1.25rem; font-size: 0.85rem; font-weight: 600;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div class="adm-form-group">
                <label for="email" class="adm-label">Alamat Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="adm-input" 
                    value="{{ old('email', 'admin@dapurkartun.id') }}" 
                    required 
                    autofocus>
            </div>

            <div class="adm-form-group">
                <label for="password" class="adm-label">Kata Sandi</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="adm-input" 
                    value="password123" 
                    required>
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; cursor: pointer;">
                    <input type="checkbox" name="remember" value="1" checked>
                    <span>Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="adm-btn adm-btn-primary" style="width: 100%; padding: 0.85rem; font-size: 1rem;">
                Masuk ke Panel Admin
            </button>
        </form>

        <div style="text-align: center; margin-top: 1.75rem;">
            <a href="{{ route('home') }}" style="color: #64748B; font-size: 0.85rem; text-decoration: none; font-weight: 600;">
                &larr; Kembali ke Website Utama
            </a>
        </div>
    </div>
</body>
</html>
