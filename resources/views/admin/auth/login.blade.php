<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Dashboard - Dapur Kartun</title>
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
            border: 2px solid rgba(255, 255, 255, 0.1);
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header img {
            margin: 0 auto 1.25rem;
            display: block;
        }
        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1F1135;
            margin-bottom: 0.5rem;
        }
        .login-header p {
            font-size: 0.9rem;
            color: #64748B;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('images/logo.svg') }}" alt="Dapur Kartun" width="180" height="45">
            <h1>Masuk ke Dashboard</h1>
            <p>Akses khusus administrator untuk mengelola konten website.</p>
        </div>

        @if($errors->any())
            <div style="background-color: #FEE2E2; color: #991B1B; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1.25rem; font-size: 0.85rem; font-weight: 600; border: 1px solid #FECACA;">
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
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                    placeholder="nama@dapurkartun.id">
            </div>

            <div class="adm-form-group">
                <label for="password" class="adm-label">Kata Sandi</label>
                <div class="adm-password-wrapper">
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="adm-input" 
                        required
                        placeholder="Masukkan kata sandi">
                    <button type="button" class="adm-password-toggle" id="togglePasswordBtn" aria-label="Tampilkan atau sembunyikan kata sandi">
                        <svg id="eyeIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; cursor: pointer;">
                    <input type="checkbox" name="remember" value="1" checked>
                    <span>Ingat sesi masuk</span>
                </label>
            </div>

            <button type="submit" class="adm-btn adm-btn-primary" style="width: 100%; padding: 0.85rem; font-size: 1rem;">
                Masuk
            </button>
        </form>

        <div style="text-align: center; margin-top: 1.75rem;">
            <a href="{{ route('home') }}" style="color: #64748B; font-size: 0.85rem; text-decoration: none; font-weight: 600;">
                &larr; Kembali ke Landing Page
            </a>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const eyeIcon = document.getElementById('eyeIcon');

        if (togglePasswordBtn && passwordInput) {
            togglePasswordBtn.addEventListener('click', () => {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                if (isPassword) {
                    passwordInput.setAttribute('type', 'text');
                    // Eye off icon
                    eyeIcon.innerHTML = `
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    `;
                } else {
                    passwordInput.setAttribute('type', 'password');
                    // Eye on icon
                    eyeIcon.innerHTML = `
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    `;
                }
            });
        }
    </script>
</body>
</html>

