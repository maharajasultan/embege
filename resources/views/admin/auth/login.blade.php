<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — MBG Bekasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 80% 60% at 50% 0%, rgba(22,163,74,.25) 0%, transparent 70%);
        }

        .grid-bg {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-brand {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-icon {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px;
            margin: 0 auto 16px;
            box-shadow: 0 8px 24px rgba(22,163,74,.4);
        }

        .login-brand h1 {
            color: #fff;
            font-size: 24px;
            font-weight: 800;
        }

        .login-brand p {
            color: #94a3b8;
            font-size: 14px;
            margin-top: 4px;
        }

        .login-card {
            background: rgba(30, 41, 59, .8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 20px;
            padding: 36px;
            box-shadow: 0 25px 50px rgba(0,0,0,.5);
        }

        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background: rgba(239,68,68,.15);
            border: 1px solid rgba(239,68,68,.3);
            color: #fca5a5;
        }

        .alert-success {
            background: rgba(22,163,74,.15);
            border: 1px solid rgba(22,163,74,.3);
            color: #86efac;
        }

        .form-group { margin-bottom: 20px; }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 8px;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #475569;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px 12px 42px;
            background: rgba(15,23,42,.6);
            border: 1.5px solid rgba(255,255,255,.08);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #f1f5f9;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22,163,74,.15);
        }

        .form-control.is-invalid { border-color: #ef4444; }

        .invalid-feedback {
            color: #fca5a5;
            font-size: 12px;
            margin-top: 6px;
        }

        .form-control::placeholder { color: #475569; }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .remember-row input[type="checkbox"] { accent-color: #16a34a; }

        .remember-row label {
            color: #94a3b8;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all .2s;
            box-shadow: 0 4px 16px rgba(22,163,74,.4);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(22,163,74,.5);
        }

        .btn-login:active { transform: translateY(0); }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            color: #475569;
            font-size: 12px;
        }

        .hint-box {
            margin-top: 20px;
            padding: 14px;
            background: rgba(22,163,74,.08);
            border: 1px solid rgba(22,163,74,.15);
            border-radius: 10px;
        }

        .hint-box p {
            font-size: 12px;
            color: #86efac;
            margin-bottom: 4px;
        }

        .hint-box p:last-child { margin-bottom: 0; }

        .hint-box strong { color: #4ade80; }

        a { color: #4ade80; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="grid-bg"></div>

<div class="login-wrapper">
    <div class="login-brand">
        <div class="brand-icon">🍱</div>
        <h1>MBG Bekasi</h1>
        <p>Panel Admin Dapur Makan Bergizi Gratis</p>
    </div>

    <div class="login-card">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-circle-exclamation"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Alamat Email</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope input-icon"></i>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        value="{{ old('email') }}"
                        placeholder="admin@mbg.id"
                        required
                        autofocus
                    >
                </div>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock input-icon"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        placeholder="Masukkan password"
                        required
                    >
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-right-to-bracket" style="margin-right:8px;"></i>
                Masuk ke Panel Admin
            </button>
        </form>

        <div class="hint-box" style="margin-top:20px;">
            <p>💡 Akun default untuk development:</p>
            <p><strong>Email:</strong> admin@mbg.id</p>
            <p><strong>Password:</strong> password123</p>
        </div>
    </div>

    <div class="login-footer">
        <a href="{{ route('home') }}">← Kembali ke Website Publik</a>
    </div>
</div>
</body>
</html>
