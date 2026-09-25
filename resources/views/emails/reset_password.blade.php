<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Password - House of Salbai</title>
    <style>
        body {
            background-color: #050505;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: #ffffff;
            margin: 0;
            padding: 40px 20px;
        }
        .container {
            max-width: 550px;
            margin: 0 auto;
            background-color: rgba(15, 15, 20, 0.95);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        }
        .logo {
            font-family: 'Outfit', sans-serif;
            font-size: 2.2rem;
            font-weight: 900;
            text-align: center;
            letter-spacing: -1px;
            color: #10B981;
            margin-bottom: 30px;
        }
        h2 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #ffffff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 15px;
        }
        p {
            font-size: 0.95rem;
            line-height: 1.6;
            color: #a1a1a6;
            margin-bottom: 25px;
        }
        .btn-wrap {
            text-align: center;
            margin: 35px 0;
        }
        .btn {
            background-color: #10B981;
            color: #000000 !important;
            text-decoration: none;
            padding: 14px 30px;
            font-weight: 800;
            font-size: 0.9rem;
            letter-spacing: 1px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
            text-transform: uppercase;
        }
        .footer {
            font-size: 0.78rem;
            color: #666666;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 20px;
            margin-top: 30px;
        }
        code {
            background: rgba(255,255,255,0.05);
            padding: 4px 8px;
            border-radius: 6px;
            color: #10B981;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">HOUSE OF SALBAI</div>
        <h2>Halo, {{ $name }}</h2>
        <p>Anda menerima email ini karena kami menerima permintaan pemulihan password untuk akun Administrator Anda.</p>
        <p>Silakan klik tombol di bawah ini untuk mengatur ulang password Anda. Link pemulihan ini berlaku selama <strong>1 jam</strong>:</p>
        <div class="btn-wrap">
            <a href="{{ $url }}" class="btn">Reset Password</a>
        </div>
        <p>Jika Anda kesulitan mengklik tombol di atas, silakan salin dan tempel link berikut ke peramban (browser) Anda:</p>
        <p style="word-break: break-all; font-size: 0.8rem; background: rgba(255,255,255,0.02); padding: 12px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">{{ $url }}</p>
        <p>Jika Anda tidak merasa mengajukan pemulihan ini, Anda tidak perlu melakukan tindakan apa pun.</p>
        <div class="footer">
            &copy; {{ date('Y') }} House of Salbai. All rights reserved.
        </div>
    </div>
</body>
</html>
