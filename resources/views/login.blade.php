<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Autentikasi | House of Salbai</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <style>
        :root {
            --bg-obsidian: #050505;
            --primary-green: #10B981;
            --accent-green: #059669;
            --glass-bg: rgba(15, 15, 20, 0.8);
            --border-green: rgba(16, 185, 129, 0.2);
        }

        body {
            background-color: var(--bg-obsidian);
            background-image: radial-gradient(circle at 2px 2px, rgba(16, 185, 129, 0.05) 1px, transparent 0);
            background-size: 50px 50px;
            font-family: 'Inter', sans-serif;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .ambient-glow {
            position: fixed;
            width: 80vw;
            height: 80vw;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.06) 0%, rgba(0,0,0,0) 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
            pointer-events: none;
        }

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-green);
            border-radius: 24px;
            padding: 60px 50px;
            width: 100%;
            max-width: 450px;
            z-index: 10;
            box-shadow: 0 40px 80px rgba(0,0,0,0.9), 0 0 40px rgba(16, 185, 129, 0.1);
            animation: fadeIn 1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .brand-logo {
            font-family: 'Outfit', sans-serif;
            font-size: 2.8rem;
            font-weight: 900;
            text-align: center;
            margin-bottom: 2rem;
            letter-spacing: -2px;
            background: linear-gradient(180deg, #fff 40%, var(--primary-green) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth-subtitle {
            text-align: center;
            color: var(--primary-green);
            font-weight: 700;
            font-size: 0.75rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 40px;
            opacity: 0.8;
        }

        .form-label { font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: #d1d5db; margin-bottom: 10px; }

        .form-control {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            color: white;
            padding: 16px 20px;
            border-radius: 12px;
            font-size: 1rem;
            margin-bottom: 25px;
            transition: all 0.4s ease;
        }

        .form-control:focus {
            background: rgba(16, 185, 129, 0.05);
            border-color: var(--primary-green);
            color: white;
            box-shadow: 0 0 25px rgba(16, 185, 129, 0.15);
            transform: scale(1.01);
        }

        .form-control::placeholder { color: #6b7280; }

        .btn-green {
            background: var(--primary-green);
            color: #000;
            width: 100%;
            padding: 18px;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 0.9rem;
            letter-spacing: 3px;
            border-radius: 12px;
            text-decoration: none;
            border: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-top: 10px;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
            text-transform: uppercase;
        }

        .btn-green:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 45px rgba(16, 185, 129, 0.5);
            filter: brightness(1.1);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 40px;
            color: #666;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .back-link:hover { color: var(--primary-green); letter-spacing: 2px; }

        @media (max-width: 576px) {
            .login-card {
                padding: 40px 25px;
                max-width: 92%;
            }
            .brand-logo {
                font-size: 2.3rem;
            }
        }
    </style>
</head>
<body>

    <div class="ambient-glow"></div>

    <div class="login-card">
        <div class="brand-logo">SALBAI</div>
        <p class="auth-subtitle">Secure Admin Gateway</p>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow" role="alert" style="background: rgba(16,185,129,0.15); color: #fff; border: 1px solid rgba(16,185,129,0.25) !important; font-size: 0.85rem; border-radius: 12px; margin-bottom: 20px;">
                <i class="fas fa-check-circle me-1 text-success"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning border-0 shadow" role="alert" style="background: rgba(245,158,11,0.15); color: #fff; border: 1px solid rgba(245,158,11,0.3) !important; font-size: 0.85rem; border-radius: 12px; margin-bottom: 20px;">
                <i class="fas fa-exclamation-triangle me-1 text-warning"></i> {{ session('warning') }}
            </div>
        @endif

        @if(session('demo_reset_url'))
            <div class="alert alert-info border-0 shadow-lg p-3 mb-4 text-start" style="background: rgba(34,211,238,0.12); border: 1px solid rgba(34,211,238,0.25) !important; border-radius: 12px; color: #fff; font-size: 0.85rem;">
                <div class="d-flex align-items-start gap-2">
                    <div class="text-cyan mt-1" style="color: #22d3ee;"><i class="fas fa-desktop"></i></div>
                    <div>
                        <strong class="d-block mb-1" style="color: #22d3ee;">🖥️ Simulator Email Sidang (Bypass Offline)</strong>
                        <p class="mb-2 text-white-50" style="font-size:0.75rem; line-height: 1.5; margin: 0 0 8px 0;">Sistem mendeteksi driver <code>log</code> (local/offline). Klik tombol di bawah untuk menyimulasikan tindakan membuka link reset dari Gmail.</p>
                        <a href="{{ session('demo_reset_url') }}" class="btn btn-sm text-dark fw-bold px-3 py-1.5" style="border-radius: 6px; font-size: 0.72rem; text-decoration:none; display:inline-block; background:#22d3ee; border: none;">
                            <i class="fas fa-envelope-open-text me-1"></i> Buka Link Reset Password
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            @error('username')
                <div class="alert-login" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #f87171; padding: 12px; border-radius: 12px; font-size: 0.85rem; margin-bottom: 20px;">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                </div>
            @enderror

            <div class="demo-quick-box mb-4 p-3 rounded-3" style="background: rgba(16, 185, 129, 0.08); border: 1px dashed rgba(16, 185, 129, 0.35); text-align: left;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #10B981; font-weight: 700; font-size: 0.72rem; letter-spacing: 0.5px;">
                        <i class="fas fa-id-badge me-1"></i> AKUN UJI COBA (PORTFOLIO)
                    </span>
                    <button type="button" class="btn btn-sm text-dark fw-bold px-2 py-0.5" id="btn-autofill" style="background: #10B981; font-size: 0.72rem; border-radius: 6px; border:none; transition: all 0.2s;" onclick="autoFillDemo()">
                        <i class="fas fa-magic me-1"></i> 1-Klik Isi
                    </button>
                </div>
                <div class="d-flex justify-content-between text-white-50" style="font-size: 0.8rem;">
                    <span>User: <strong class="text-white">admin</strong></span>
                    <span>Pass: <strong class="text-white">password</strong></span>
                </div>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label" for="username">Username</label>
                <div class="input-group">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required value="{{ old('username') }}" autocomplete="username">
                </div>
            </div>
            
            <div class="mb-2 text-start">
                <label class="form-label" for="password">Password</label>
                <div class="input-group position-relative">
                    <input type="password" name="password" id="password" class="form-control pe-5" placeholder="••••••••" required autocomplete="current-password">
                    <button type="button" class="btn position-absolute end-0 top-50 translate-middle-y text-white-50 border-0 bg-transparent pe-3" style="z-index: 10;" onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-end mb-4">
                <a href="{{ route('password.request') }}" style="color: var(--primary-green); text-decoration: none; font-size: 0.78rem; font-weight: 600; transition: opacity 0.2s;" onmouseover="this.style.opacity=0.8" onmouseout="this.style.opacity=1">Lupa Password?</a>
            </div>

            <button type="submit" class="btn-green" id="btn-login">Masuk ke Dashboard</button>
        </form>

        <a href="/" class="back-link"><i class="fas fa-arrow-left me-1"></i> Kembali ke Halaman Depan</a>
    </div>

    <script>
        function autoFillDemo() {
            document.getElementById('username').value = 'admin';
            document.getElementById('password').value = 'password';
            const btn = document.getElementById('btn-autofill');
            btn.innerHTML = '<i class="fas fa-check me-1"></i> Terisi!';
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-magic me-1"></i> 1-Klik Isi';
            }, 1500);
        }

        function togglePasswordVisibility() {
            const passInput = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (passInput.type === 'password') {
                passInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
