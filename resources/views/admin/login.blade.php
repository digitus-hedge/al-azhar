<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EGTS - Admin Login</title>
       {{-- Favicon --}}
    <link rel="icon" type="image/webp" href="{{ asset('images/logo.webp') }}">
    <link rel="shortcut icon" type="image/webp" href="{{ asset('images/logo.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.webp') }}">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            background-color: #1e1e2d;
            background-image:
                radial-gradient(circle at 15% 20%, rgba(59, 59, 88, 0.55) 0%, transparent 45%),
                radial-gradient(circle at 85% 80%, rgba(91, 91, 138, 0.45) 0%, transparent 50%),
                linear-gradient(135deg, #1e1e2d 0%, #262640 45%, #3b3b58 100%);
        }

        /* Subtle diagonal grid pattern overlay */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
            background-size: 42px 42px;
            pointer-events: none;
        }

        /* Soft glowing accent blob */
        body::after {
            content: "";
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
            top: -150px;
            right: -150px;
            border-radius: 50%;
            pointer-events: none;
        }

        .login-box {
            position: relative;
            z-index: 1;
            background: #fff;
            padding: 40px 35px;
            border-radius: 14px;
            width: 360px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.35);
        }

        .brand-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 8px;
        }

        .brand-header img {
            width: 50%;
            height: auto;
            object-fit: contain;
            margin-bottom: 12px;
        }

        .brand-header .brand-name {
            font-size: 20px;
            font-weight: 700;
            color: #1e1e2d;
            letter-spacing: 0.5px;
        }

        .brand-header .brand-tagline {
            font-size: 11.5px;
            color: #999;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 6px;
            color: #1e1e2d;
            font-size: 19px;
        }

        .login-box p.subtitle {
            text-align: center;
            color: #888;
            font-size: 13px;
            margin-bottom: 25px;
        }

        .error {
            background: #fdecea;
            color: #c0392b;
            font-size: 13px;
            padding: 10px 12px;
            border-radius: 6px;
            margin-bottom: 18px;
            border: 1px solid #f5c6cb;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            color: #444;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i.field-icon {
            position: absolute;
            left: 12px;
            color: #999;
            font-size: 15px;
        }

        .input-wrapper input {
            width: 100%;
            padding: 10px 12px 10px 38px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .input-wrapper input:focus {
            border-color: #3b3b58;
            box-shadow: 0 0 0 3px rgba(59, 59, 88, 0.12);
        }

        .input-wrapper input#password {
            padding-right: 38px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            color: #999;
            cursor: pointer;
            font-size: 15px;
            user-select: none;
        }

        .toggle-password:hover {
            color: #3b3b58;
        }

        .login-box button {
            width: 100%;
            padding: 11px;
            background: #3b3b58;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            margin-top: 8px;
            transition: background 0.2s ease, transform 0.1s ease;
        }

        .login-box button:hover {
            background: #2b2b42;
        }

        .login-box button:active {
            transform: translateY(1px);
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 11.5px;
            color: #aaa;
        }


                /* ===== Mobile responsiveness ===== */
@media (max-width: 480px) {
    body {
        padding: 16px;
        height: auto;
        min-height: 100vh;
    }

    .login-box {
        width: 100%;
        max-width: 360px;
        padding: 30px 24px;
        border-radius: 12px;
    }

    .brand-header img {
        width: 60px;
    }

    .brand-header .brand-name {
        font-size: 17px;
    }

    .login-box h2 {
        font-size: 17px;
    }

    .login-box p.subtitle {
        font-size: 12.5px;
        margin-bottom: 20px;
    }

    .form-group label {
        font-size: 12.5px;
    }

    .input-wrapper input {
        padding: 10px 12px 10px 34px;
        font-size: 13.5px;
    }

    .input-wrapper i.field-icon {
        left: 10px;
        font-size: 14px;
    }

    .toggle-password {
        right: 10px;
        font-size: 14px;
    }

    .login-box button {
        padding: 12px;
        font-size: 14px;
    }
}

/* ===== Extra small phones ===== */
@media (max-width: 340px) {
    .login-box {
        padding: 24px 18px;
    }

    .brand-header .brand-name {
        font-size: 15px;
    }
}

/* ===== Short screens (landscape phones) ===== */
@media (max-height: 600px) {
    body {
        align-items: flex-start;
        padding-top: 30px;
    }
}
    </style>
</head>
<body>
    <div class="login-box">

        <div class="brand-header">
            <img src="{{ asset('images/logo.webp') }}" alt="EGTS Logo">
            <div class="brand-name">EGTS Admin</div>
            <!-- <div class="brand-tagline">Control Panel</div> -->
        </div>

        <!-- <h2>Welcome Back</h2> -->
        <p class="subtitle">Sign in to access your dashboard</p>

        @if ($errors->any())
            <div class="error"><i class="bi bi-exclamation-circle"></i> {{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <i class="bi bi-envelope field-icon"></i>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="admin@example.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <i class="bi bi-lock field-icon"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >
                    <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                </div>
            </div>

            <button type="submit">Login</button>
        </form>

        <!-- <p class="login-footer">&copy; {{ date('Y') }} EGTS. All rights reserved.</p> -->
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>