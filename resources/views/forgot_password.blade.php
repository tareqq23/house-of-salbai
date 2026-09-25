<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemulihan Password | House of Salbai</title>
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
            padding: 50px;
            width: 100%;
            max-width: 480px;
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
            font-size: 2.2rem;
            font-weight: 900;
            text-align: center;
            margin-bottom: 1rem;
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
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 30px;
            opacity: 0.8;
        }

        .form-label { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: #d1d5db; margin-bottom: 8px; }

        .form-control {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            color: white;
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 0.95rem;
            margin-bottom: 20px;
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
            padding: 15px;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 0.85rem;
            letter-spacing: 2px;
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
            margin-top: 30px;
            color: #666;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .back-link:hover { color: var(--primary-green); letter-spacing: 2px; }

        .alert-login-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #f87171;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.85rem;
            margin-bottom: 20px;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 35px 20px;
                max-width: 92%;
            }
            .brand-logo {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>

    <div class="ambient-glow"></div>

    <div class="login-card">
        <div class="brand-logo">LUPA PASSWORD</div>
        <p class="auth-subtitle">Admin Recovery Portal</p>

        <div class="alert alert-info py-2 px-3 mb-4 text-center" style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.1); color: #a7f3d0; font-size: 0.78rem; border-radius: 12px;">
            <i class="fas fa-info-circle me-1"></i> Khusus Administrator. Jika Anda adalah Staff, silakan hubungi Admin secara langsung untuk mereset password Anda.
        </div>

        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            @if($errors->any())
                <div class="alert-login-danger">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-4">
                <label class="form-label">Email Terdaftar</label>
                <input type="email" name="email" id="fp-email" class="form-control" placeholder="Masukkan alamat Gmail terdaftar" required value="{{ old('email') }}" autocomplete="email">
            </div>

            <button type="submit" id="btn-reset" class="btn-green">Kirim Link Pemulihan</button>
        </form>

        <a href="/login" class="back-link"><i class="fas fa-arrow-left me-1"></i> Kembali ke Login</a>
    </div>

</body>
</html>
