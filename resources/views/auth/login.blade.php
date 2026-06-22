<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Login Admin — SIGAP TUHA</title>
    <meta name="description" content="Login ke Admin Panel SIGAP TUHA untuk mengelola sistem informasi lansia.">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        :root {
            --brand-500: #3b6cf9;
            --brand-600: #254aee;
            --brand-700: #1d37db;
            --brand-800: #1f2fb1;
            --brand-900: #0b1340;
            --brand-50:  #eef4ff;
            --brand-100: #dae6ff;
            --gray-50:  #f8f9fb;
            --gray-100: #f0f2f5;
            --gray-200: #e4e7ec;
            --gray-400: #98a2b3;
            --gray-500: #667085;
            --gray-600: #475467;
            --gray-900: #101828;
            --danger-500: #f04438;
            --success-500: #12b76a;
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
            --radius-2xl: 20px;
            --radius-full: 9999px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, system-ui, sans-serif;
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: var(--gray-50);
            position: relative;
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Background Image with Blur */
        body::before {
            content: '';
            position: fixed;
            top: -5%;
            left: -5%;
            width: 110%;
            height: 110%;
            background-image: url("{{ asset('images/bg-login.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(8px);
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 0;
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
        }

        .login-card {
            background: rgb(55, 129, 157, 0.40);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: var(--radius-2xl);
            padding: 40px 36px;
            box-shadow: 0 20px 60px rgba(11, 19, 64, 0.08), 0 1px 3px rgba(0,0,0,0.06);
            text-align: center;
            animation: cardEntry 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes cardEntry {
            from {
                opacity: 0;
                transform: translateY(24px) scale(0.97);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .login-logo {
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, var(--brand-600) 0%, var(--brand-800) 100%);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
            box-shadow: 0 8px 24px rgba(37, 74, 238, 0.3);
            position: relative;
            overflow: hidden;
        }

        .login-logo::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.12) 50%, transparent 70%);
            animation: shimmer 4s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { transform: translateX(-100%); }
            50% { transform: translateX(100%); }
        }

        .login-card h1 {
            font-size: 22px;
            font-weight: 800;
            color: var(--gray-900);
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .login-card .subtitle {
            font-size: 13.5px;
            color: #ffffff;
            margin-bottom: 28px;
            line-height: 1.5;
        }

        .form-group {
            text-align: left;
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 6px;
        }

        .form-group label i {
            margin-right: 5px;
            color: #ffffff;
            font-size: 13px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i.input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            font-size: 14px;
            pointer-events: none;
            transition: color 0.2s;
        }

        .input-wrapper input {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 1.5px solid var(--gray-200);
            border-radius: var(--radius-md);
            font-family: inherit;
            font-size: 14px;
            color: var(--gray-900);
            background: rgba(255,255,255,0.7);
            transition: all 0.2s ease;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: var(--brand-500);
            box-shadow: 0 0 0 3px var(--brand-100);
            background: #fff;
        }

        .input-wrapper input:focus + i.input-icon,
        .input-wrapper input:focus ~ i.input-icon {
            color: var(--brand-600);
        }

        .input-wrapper input::placeholder {
            color: var(--gray-400);
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-400);
            font-size: 14px;
            cursor: pointer;
            padding: 4px;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: var(--gray-600);
        }

        .error-msg {
            font-size: 12.5px;
            color: var(--danger-500);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--brand-600) 0%, var(--brand-800) 100%);
            color: #fff;
            border: none;
            border-radius: var(--radius-md);
            font-size: 15px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 14px rgba(37, 74, 238, 0.3);
            margin-top: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 74, 238, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 22px;
            font-size: 13px;
            color: #ffffff;
            font-weight: 600;
            transition: all 0.2s;
        }

        .back-link:hover, .back-link:active {
            color: #3b82f6; /* blue color for hover and click */
            gap: 8px;
        }

        .back-link i {
            font-size: 11px;
            transition: transform 0.2s;
        }

        .back-link:hover i {
            transform: translateX(-3px);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 32px 24px;
                border-radius: var(--radius-xl);
            }

            .login-card h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h1>Admin Login</h1>
            <p class="subtitle">Silakan masuk untuk mengelola sistem SIGAP TUHA</p>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@sigaptuha.id">
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                    @error('email')
                        <div class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="passwordInput" required placeholder="••••••••">
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" class="toggle-password" id="togglePassword" aria-label="Toggle password visibility">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
                </button>
            </form>

            <a href="{{ route('beranda') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const toggleBtn = document.getElementById('togglePassword');
        const passInput = document.getElementById('passwordInput');

        toggleBtn.addEventListener('click', () => {
            const isPassword = passInput.type === 'password';
            passInput.type = isPassword ? 'text' : 'password';
            toggleBtn.innerHTML = isPassword
                ? '<i class="far fa-eye-slash"></i>'
                : '<i class="far fa-eye"></i>';
        });
    </script>
</body>
</html>
