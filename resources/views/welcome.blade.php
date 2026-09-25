<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House of Salbai | Premium Event Logistics</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --bg-obsidian: #020202;
            --primary-green: #10B981;
            --accent-green: #059669;
            --text-white: #ffffff;
            --text-grey: #a0a0a0;
            --glass: rgba(255, 255, 255, 0.02);
            --border: rgba(16, 185, 129, 0.15);
        }

        html, body {
            background-color: var(--bg-obsidian);
            color: var(--text-white);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            scroll-behavior: smooth;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background-image: 
                radial-gradient(circle at 2px 2px, rgba(16, 185, 129, 0.05) 1px, transparent 0);
            background-size: 50px 50px;
        }

        /* CUSTOM SCROLLBAR */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-obsidian); }
        ::-webkit-scrollbar-thumb { background: var(--primary-green); border-radius: 10px; }

        /* PREMIUM HERO */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: radial-gradient(circle at 10% 10%, rgba(16, 185, 129, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 90% 90%, rgba(16, 185, 129, 0.05) 0%, transparent 50%);
            padding: 120px 0;
            position: relative;
            z-index: 1;
        }

        .hero-content { position: relative; z-index: 10; }

        .hero-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            font-size: clamp(3rem, 6vw, 5.5rem);
            line-height: 1;
            letter-spacing: -3px;
            background: linear-gradient(180deg, #fff 30%, var(--primary-green) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 2rem;
            text-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .hero-subtitle {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.7);
            line-height: 1.8;
            border-left: 3px solid var(--primary-green);
            padding-left: 25px;
            margin-bottom: 3rem;
            max-width: 500px;
        }

        .hero-visual {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .floating-box {
            width: 120%;
            aspect-ratio: 16/11;
            background: url('{{ isset($settings['hero_image']) ? asset('img/'.$settings['hero_image']) : 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=1200&auto=format&fit=crop' }}');
            background-size: cover;
            background-position: center;
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,0.15);
            box-shadow: 0 40px 80px rgba(0,0,0,0.9), 0 0 60px rgba(16, 185, 129, 0.15);
            animation: float 8s ease-in-out infinite;
            position: relative;
            z-index: 5;
        }

        .floating-box::before {
            content: "";
            position: absolute;
            inset: -20px;
            background: var(--primary-green);
            opacity: 0.1;
            filter: blur(40px);
            z-index: -1;
            border-radius: 40px;
        }

        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        /* Ambient Glows Manager */
        .ambient-glow {
            position: fixed;
            width: 80vw;
            height: 80vw;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.08) 0%, transparent 70%);
            top: -20%;
            left: -20%;
            z-index: 0;
            pointer-events: none;
        }

        /* SCROLL INDICATOR */
        .scroll-down {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            opacity: 0.6;
            z-index: 100;
        }
        .scroll-down:hover { opacity: 1; }
        .mouse {
            width: 25px;
            height: 45px;
            border: 2px solid #fff;
            border-radius: 20px;
            position: relative;
        }
        .mouse::after {
            content: "";
            width: 4px;
            height: 8px;
            background: var(--primary-green);
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
            animation: scroll-wheel 2s infinite;
        }
        @keyframes scroll-wheel { 0% { top: 8px; opacity: 1; } 100% { top: 25px; opacity: 0; } }
        .scroll-text { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 4px; font-weight: 700; color: #fff; }

        .btn-luxury {
            background: var(--primary-green);
            color: #000;
            font-weight: 800;
            padding: 20px 50px;
            text-transform: uppercase;
            letter-spacing: 3px;
            border-radius: 4px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: 0 10px 40px rgba(16, 185, 129, 0.3);
            border: none;
            text-decoration: none;
            display: inline-block;
        }
        .btn-luxury:hover { transform: translateY(-5px) scale(1.02); box-shadow: 0 20px 60px rgba(16, 185, 129, 0.5); color: #000; }

        .btn-outline-premium {
            border: 1px solid var(--border);
            color: #fff;
            padding: 20px 50px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 700;
            text-decoration: none;
            border-radius: 4px;
            transition: 0.4s;
            background: rgba(255,255,255,0.02);
        }
        .btn-outline-premium:hover { background: var(--primary-green); color: #000; border-color: var(--primary-green); }

        .image-wrapper { position: relative; padding-top: 65%; overflow: hidden; }
        .image-wrapper img {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 1.2s cubic-bezier(0.2, 0.8, 0.2, 1);
            filter: brightness(0.85) grayscale(20%);
        }

        .glass-card { background: var(--glass); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.03); border-bottom: 2px solid transparent; border-radius: 8px; overflow: hidden; height: 100%; transition: all 0.5s ease; }
        .glass-card:hover { transform: translateY(-10px); border-bottom: 2px solid var(--primary-green); box-shadow: 0 20px 40px rgba(0,0,0,0.6); }
        .glass-card:hover .image-wrapper img { transform: scale(1.08); filter: brightness(1) grayscale(0%); }

        .card-content { padding: 35px 25px; position: relative; background: linear-gradient(to bottom, #111115, #070709); }
        .card-title { font-size: 1.35rem; font-weight: 700; color: #fff; margin-bottom: 20px; }

        .section-title { font-size: clamp(2rem, 4vw, 3.5rem); font-weight: 800; letter-spacing: -1px; margin-bottom: 0.5rem; text-align: center; }
        .section-subtitle { text-align: center; color: var(--primary-green); font-weight: 500; letter-spacing: 4px; font-size: 0.85rem; text-transform: uppercase; margin-bottom: 4rem; }

        /* Navbar Premium Styling */
        .navbar { 
            padding: 30px 0; 
            background: transparent; 
            border-bottom: 1px solid transparent; 
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); 
            z-index: 1030; 
        }
        .navbar.scrolled {
            padding: 15px 0;
            background: rgba(2, 2, 2, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(16, 185, 129, 0.2);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8);
        }
        .navbar.navbar-dark .nav-link { color: #fff !important; opacity: 0.8; font-weight: 500; margin: 0 15px; }

        /* Component Overrides & Luxury Cards */
        .luxury-card { 
            background: rgba(15, 15, 20, 0.6); 
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(16, 185, 129, 0.15); 
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); 
            height: 100%;
        }
        .luxury-card:hover { 
            border-color: var(--primary-green); 
            transform: translateY(-10px); 
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.12);
        }
        .luxury-card:hover .image-wrapper img {
            transform: scale(1.08);
            filter: brightness(1) grayscale(0%);
        }

        /* PORTFOLIO CARD (Masterpieces Section) */
        .portofolio-card {
            display: flex;
            flex-direction: row;
            align-items: center;
            border-radius: 20px;
            overflow: hidden;
            background: rgba(10, 10, 15, 0.5);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(16, 185, 129, 0.12);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .portofolio-card:hover {
            border-color: var(--primary-green);
            transform: translateY(-8px);
            box-shadow: 0 20px 45px rgba(16, 185, 129, 0.15);
        }
        .portofolio-img {
            width: 38%;
            padding-top: 26%;
            position: relative;
            overflow: hidden;
        }
        .portofolio-img img {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
            filter: brightness(0.8);
        }
        .portofolio-card:hover .portofolio-img img {
            transform: scale(1.06);
            filter: brightness(0.95);
        }
        .portofolio-content {
            width: 62%;
            padding: 40px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .portofolio-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: #fff;
            margin-top: 10px;
            margin-bottom: 15px;
            font-family: 'Outfit', sans-serif;
            transition: color 0.3s ease;
        }
        .portofolio-card:hover .portofolio-title {
            color: var(--primary-green);
        }
        .portofolio-desc {
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.8;
            font-size: 0.98rem;
            margin-bottom: 0;
        }

        /* QR MODAL STYLE */
        .qr-card {
            background: linear-gradient(145deg, #111, #050505);
            border: 1px solid var(--primary-green);
            border-radius: 20px;
            padding: 30px;
        }
        .qr-placeholder {
            background: white;
            padding: 15px;
            border-radius: 15px;
            display: inline-block;
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.2);
        }

        .hero-stats { display: flex; gap: 40px; margin-top: 50px; }
        .stat-item h4 { font-weight: 800; color: var(--primary-green); margin-bottom: 0; font-size: 1.8rem; }
        .stat-item p { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: rgba(255,255,255,0.5); }

        @media (max-width: 991px) {
            .hero-section { text-align: center; padding-top: 150px; }
            .hero-subtitle { margin: 2rem auto; border-left: none; padding-left: 0; }
            .hero-title { font-size: 3rem; }
            .hero-stats { justify-content: center; }
            .hero-visual { margin-top: 60px; }
            .portofolio-card { flex-direction: column; }
            .portofolio-img { width: 100%; padding-top: 60%; }
            .portofolio-content { width: 100%; padding-left: 0; padding-top: 20px; }
            #particles-js { opacity: 0.4; } 
        }

        @media (max-width: 576px) {
            .hero-title { font-size: 2.2rem !important; }
            .hero-stats { flex-direction: column; gap: 20px; }
            .section-title { font-size: 1.8rem !important; }
            .navbar-brand { font-size: 1.2rem; }
            .card-content { padding: 20px 15px; }
            .btn-luxury, .btn-outline-premium {
                padding: 15px 30px !important;
                font-size: 0.85rem !important;
                letter-spacing: 1px !important;
                width: 100% !important;
                text-align: center !important;
                margin-bottom: 10px !important;
            }
        }

        /* FLOATING WHATSAPP */
        .floating-wa {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background-color: #25d366;
            color: #fff;
            border-radius: 50%;
            text-align: center;
            font-size: 30px;
            box-shadow: 0 10px 25px rgba(37, 211, 102, 0.4);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .floating-wa:hover {
            transform: scale(1.1) rotate(10deg);
            color: white;
            box-shadow: 0 15px 35px rgba(37, 211, 102, 0.6);
        }

        /* FLOATING QR CODE BUTTON */
        .mobile-qr-btn {
            position: fixed;
            bottom: 30px;
            right: 100px;
            width: auto;
            height: 60px;
            background: linear-gradient(135deg, #10B981, #059669);
            color: #fff;
            border-radius: 50px;
            padding: 0 20px;
            gap: 10px;
            font-size: 22px;
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5), 0 0 0 2px rgba(16,185,129,0.2);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: qr-pulse 2.5s infinite;
        }
        .mobile-qr-btn:hover {
            transform: scale(1.08) translateY(-3px);
            box-shadow: 0 15px 40px rgba(16, 185, 129, 0.7);
            animation: none;
        }
        .mobile-qr-btn .qr-label {
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            line-height: 1.2;
            text-transform: uppercase;
            white-space: nowrap;
            font-family: 'Outfit', sans-serif;
        }
        @keyframes qr-pulse {
            0%, 100% { box-shadow: 0 8px 25px rgba(16,185,129,0.5), 0 0 0 2px rgba(16,185,129,0.2); }
            50%       { box-shadow: 0 8px 35px rgba(16,185,129,0.8), 0 0 0 6px rgba(16,185,129,0.1); }
        }
        /* Sembunyikan tombol QR di tampilan mobile (HP sudah di layar HP, tidak perlu scan) */
        @media (max-width: 768px) {
            .mobile-qr-btn { display: none !important; }
        }

        /* PAGINATION BUTTONS */
        .btn-outline-hos {
            color: var(--primary-green);
            border: 1px solid rgba(16, 185, 129, 0.4);
            background: transparent;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-outline-hos:hover:not(:disabled) {
            background: rgba(16, 185, 129, 0.1);
            border-color: var(--primary-green);
            color: var(--primary-green);
        }
        .btn-outline-hos:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }
        .btn-hos {
            background: linear-gradient(135deg, var(--primary-green), #059669);
            color: #000 !important;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-hos:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
        }

        /* ============================================================
           PREMIUM CUSTOM STYLING (ADDED FOR MOBILE OPTIMIZATION & LOOKS)
           ============================================================ */
        .text-hos {
            color: var(--primary-green) !important;
        }

        /* ABOUT SECTION SHADOW & IMAGE GLOW */
        .about-image-wrapper {
            position: relative;
            display: inline-block;
            border-radius: 24px;
            padding: 8px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), transparent);
            border: 1px solid rgba(16, 185, 129, 0.15);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7);
            transition: all 0.5s ease;
            max-width: 100%;
        }
        .about-image-wrapper:hover {
            transform: translateY(-5px);
            border-color: var(--primary-green);
            box-shadow: 0 30px 60px rgba(16, 185, 129, 0.2);
        }
        .about-image-wrapper img {
            border-radius: 18px;
            transition: all 0.5s ease;
            max-height: 380px;
            object-fit: cover;
            width: 100%;
        }
        /* Auto-style uploaded logo to look crisp and invert to white on dark theme */
        .about-image-wrapper img[src*="logo"], 
        .about-image-wrapper img[src*="about_"] {
            filter: brightness(0) invert(1) drop-shadow(0px 0px 8px rgba(16,185,129,0.4));
            background: rgba(255, 255, 255, 0.02);
            padding: 25px;
            object-fit: contain;
            aspect-ratio: 16/9;
        }

        .about-text-card {
            padding: 10px;
        }

        /* PREMIUM BULLET CARD SHOWCASE */
        .feature-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(16, 185, 129, 0.12);
            border-radius: 14px;
            padding: 18px 22px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            height: 100%;
        }
        .feature-card:hover {
            background: rgba(16, 185, 129, 0.06);
            border-color: var(--primary-green);
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(16, 185, 129, 0.15);
        }
        .feature-card i {
            color: var(--primary-green) !important;
            font-size: 1.3rem;
        }
        .feature-card span {
            color: #ffffff;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
        }

        /* MOBILE STYLING OVERRIDES */
        @media (max-width: 991px) {
            .floating-box {
                width: 100% !important;
                margin: 0 auto !important;
            }
            .navbar-collapse {
                background: rgba(10, 10, 15, 0.96);
                backdrop-filter: blur(25px);
                -webkit-backdrop-filter: blur(25px);
                border-radius: 20px;
                padding: 25px;
                margin-top: 15px;
                border: 1px solid rgba(16, 185, 129, 0.2);
                box-shadow: 0 20px 45px rgba(0,0,0,0.85);
            }
            .navbar-nav .nav-item {
                margin-bottom: 12px;
            }
            .navbar-nav .nav-link {
                margin: 0 !important;
                padding: 12px 20px;
                border-radius: 10px;
                transition: all 0.3s ease;
            }
            .navbar-nav .nav-link:hover {
                background: rgba(16, 185, 129, 0.08);
                color: var(--primary-green) !important;
            }
        }

        @media (max-width: 768px) {
            #about {
                padding: 50px 15px !important;
            }
            .about-image-wrapper {
                max-width: 85%;
                margin: 0 auto 20px auto;
                display: block;
            }
            .about-image-wrapper img {
                max-height: 220px;
            }
            .about-text-card {
                background: rgba(255, 255, 255, 0.015);
                border: 1px solid rgba(16, 185, 129, 0.06);
                border-radius: 24px;
                padding: 35px 24px;
                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);
                margin-top: 10px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            }
            .about-text-card h6 {
                text-align: center;
                font-size: 0.8rem;
            }
            .about-text-card h2 {
                text-align: center;
                font-size: 1.9rem !important;
                margin-bottom: 22px !important;
            }
            .about-text-card p {
                font-size: 0.92rem !important;
                line-height: 1.8 !important;
                color: rgba(255, 255, 255, 0.72) !important;
                text-align: justify;
                margin-bottom: 25px !important;
            }
            .feature-card {
                padding: 14px 16px;
                gap: 10px;
                border-radius: 12px;
            }
            .feature-card span {
                font-size: 0.82rem;
            }
            .feature-card i {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>

    <div class="ambient-glow"></div>
    <div class="ambient-glow-2"></div>
    <div id="particles-js"></div>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#" id="brand-logo">
                    @if(isset($settings['company_logo']) && !empty($settings['company_logo']))
                    <img src="{{ asset('img/'.$settings['company_logo']) }}" alt="Logo" height="40" class="me-2 logo-img">
                @else
                    <div class="me-2 logo-fallback">HOS</div>
                @endif
                <span class="fw-bold ex-style-867b431d" >{{ $settings['company_name'] ?? 'HOUSE OF SOUND' }}</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto alien-center">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#katalog">Katalog</a></li>
                    <li class="nav-item"><a class="nav-link" href="#album">Album</a></li>
                    @php 
                        $wa_num = $settings['whatsapp'] ?? '628123456789';
                        if(str_starts_with($wa_num, '0')) { $wa_num = '62' . substr($wa_num, 1); }
                        $wa_msg = urlencode($settings['wa_message'] ?? "Halo Salbai, saya ingin berkonsultasi mengenai kebutuhan produksi event saya.");
                    @endphp
                    <li class="nav-item"><a class="nav-link btn btn-outline-hos px-4 ms-lg-3 mt-2 mt-lg-0 ex-style-78c723e8"  href="https://wa.me/{{ $wa_num }}?text={{ $wa_msg }}" target="_blank">{{ $settings['cta_text'] ?? 'Konsultasi' }}</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section id="home" class="hero-section">
        <div class="ambient-glow"></div>
        <div class="ambient-glow-2"></div>
        
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-7 text-start">
                    <span class="badge bg-transparent py-2 mb-4 hero-badge">{{ $settings['hero_badge_text'] ?? 'THE MASTER OF EVENT' }}</span>
                    <h1 class="hero-title">
                        {{ $settings['hero_prefix'] ?? 'Digitalisasi' }} <br> <span class="hero-highlight">{{ $settings['hero_title'] ?? 'Produksi Event' }}</span>
                    </h1>
                    <p class="hero-subtitle">
                        {{ $settings['hero_subtitle'] ?? 'Selamat datang di House of Salbai. Solusi cerdas manajemen aset panggung dan koordinasi logistik event nasional dengan presisi tak tertandingi.' }}
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#katalog" class="btn-luxury">TELUSURI ASET</a>
                        <a href="#about" class="btn-outline-premium">PROFIL BISNIS</a>
                    </div>

                    <div class="hero-stats">
                        <div class="stat-item">
                            <h4>{{ !empty($settings['hero_stat_1_val']) ? $settings['hero_stat_1_val'] : count($inventories).'+' }}</h4>
                            <p>{{ $settings['hero_stat_1_label'] ?? 'Premium Assets' }}</p>
                        </div>
                        <div class="stat-item">
                            <h4>{{ !empty($settings['hero_stat_2_val']) ? $settings['hero_stat_2_val'] : count($albums).'+' }}</h4>
                            <p>{{ $settings['hero_stat_2_label'] ?? 'Epic Events' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-visual">
                        <div class="floating-box"></div>
                    </div>
                </div>
            </div>
        </div>

        <a href="#about" class="scroll-down">
            <div class="mouse"></div>
            <span class="scroll-text">Explore</span>
        </a>
    </section>

    <!-- TENTANG KAMI (Alignment Bab 1 & 2) -->
    <section id="about" class="py-5 about-section">
        <div class="container my-4 my-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0 text-center" data-aos="zoom-in">
                    <div class="about-image-wrapper">
                        <img src="{{ (isset($settings['about_image']) && !empty($settings['about_image'])) ? asset('img/'.$settings['about_image']) : 'https://images.unsplash.com/photo-1511795409834-432f7b1728d2?q=80&w=600&auto=format&fit=crop' }}" alt="About HOS" onerror="this.style.display='none'">
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="about-text-card">
                        <h6 class="text-hos text-uppercase mb-2 ex-style-575a514d" >PROFIL PERUSAHAAN</h6>
                            <h2 class="display-6 fw-bold mb-4 text-white">{{ $settings['company_name'] ?? 'House of Salbai' }}</h2>
                            <p class="text-white-50 mb-4 ex-style-ca8549b7" >
                            {{ $settings['company_description'] ?? 'House of Salbai adalah perusahan Event Organizer yang berfokus pada kualitas produksi dan manajemen aset logistik yang unggul. Kami bertransformasi melalui digitalisasi untuk menjamin setiap event berjalan sukses tanpa kendala teknis.' }}
                        </p>
                        <div class="row g-3">
                            <div class="col-6 col-sm-6">
                                <div class="feature-card">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Asset Management</span>
                                </div>
                            </div>
                            <div class="col-6 col-sm-6">
                                <div class="feature-card">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Event Production</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- KATALOG -->
    <section id="katalog" class="py-5 ex-style-e0b83d9d" >
        <div class="container my-5">
            <h2 class="section-title" data-aos="fade-up">{{ $settings['catalog_header'] ?? 'Katalog Alat' }}</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Katalog Eksekutif Peralatan</p>
            
            <div class="d-flex flex-wrap justify-content-center gap-2 mb-5" data-aos="fade-up">
                <button class="btn btn-outline-hos active filter-btn" onclick="filterAlat('all', this)">Semua Alat</button>
                @foreach($inventories->pluck('kategori')->unique() as $kat)
                    <button class="btn btn-outline-hos filter-btn" onclick="filterAlat('{{ Str::slug($kat) }}', this)">{{ $kat }}</button>
                @endforeach
            </div>

            <div class="row g-4" id="katalogGrid">
                @if(count($inventories) > 0)
                    @foreach($inventories as $alat)
                    @php
                        $fotoUrl = ($alat->foto_alat && $alat->foto_alat != '-')
                            ? asset(implode('/', array_map('rawurlencode', explode('/', $alat->foto_alat))))
                            : 'https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?q=80&w=600&auto=format&fit=crop';
                    @endphp
                    <div class="col-md-6 col-lg-4 alat-item filter-{{ Str::slug($alat->kategori) }}">
                        <div class="luxury-card">
                            <div class="image-wrapper">
                                <img src="{{ $fotoUrl }}" onerror="this.src='https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?q=80&w=600&auto=format&fit=crop';" loading="lazy">
                            </div>
                            <div class="card-content">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="ex-style-df5e91da">{{ $alat->kategori }}</span>
                                    @if($alat->stok_tersedia > 0)
                                        <span class="ex-style-9d6bb583">Tersedia</span>
                                    @else
                                        <span class="ex-style-6aeb87d1">Tersewa</span>
                                    @endif
                                </div>
                                <h3 class="card-title">{{ $alat->nama_alat }}</h3>
                                <div>
                                    <span class="ex-style-4d92d817"><i class="fas fa-layer-group opacity-50 me-2"></i> Kuantitas: <b>{{ $alat->stok_tersedia }}</b> Unit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12 text-center text-muted" data-aos="fade-in">
                        <p>Katalog inventaris sedang dikunci.</p>
                    </div>
                @endif
            </div>

            {{-- Pagination Katalog --}}
            <div class="d-flex justify-content-center align-items-center gap-2 mt-5" id="katalogPagination"></div>
        </div>
    </section>

    <!-- PORTOFOLIO -->
    <section id="portofolio" class="py-5 ex-style-e0b83d9d" >
        <div class="container my-5">
            <h2 class="section-title text-start" data-aos="fade-right">{{ $settings['portfolio_header'] ?? 'Masterpieces' }}</h2>
            <p class="section-subtitle text-start" data-aos="fade-right" data-aos-delay="100">Jejak Karya Profesional Kami</p>

            <div class="row g-4" id="albumGrid">
                @if(count($albums) > 0)
                    @foreach($albums as $album)
                    @php
                        // Tentukan gambar cover: prioritaskan cover_album, fallback ke galeri pertama
                        if (!empty($album->cover_album) && $album->cover_album !== '-') {
                            $coverSrc = asset(implode('/', array_map('rawurlencode', explode('/', $album->cover_album))));
                        } else {
                            $firstImg = $album->galleries->where('file_type', 'image')->first();
                            if ($firstImg) {
                                $coverSrc = asset(implode('/', array_map('rawurlencode', explode('/', $firstImg->file_path))));
                            } else {
                                $coverSrc = 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=800&auto=format&fit=crop';
                            }
                        }
                        // Format tanggal
                        $tglMulai   = date('d F Y', strtotime($album->tanggal_event));
                        $tglSelesai = $album->tanggal_selesai ? date('d F Y', strtotime($album->tanggal_selesai)) : null;
                        $tglLabel   = $tglSelesai ? "$tglMulai &mdash; $tglSelesai" : $tglMulai;
                    @endphp
                    <div class="col-12 album-item"
                         data-judul="{{ $album->judul_event }}"
                         data-galleries="{{ json_encode($album->galleries, JSON_HEX_QUOT|JSON_HEX_APOS) }}"
                         onclick="initGaleriPublik(this)" class="ex-style-24b531c6">
                        <div class="luxury-card portofolio-card">
                            <div class="image-wrapper portofolio-img">
                                <img src="{{ $coverSrc }}" onerror="this.src='https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=800&auto=format&fit=crop';" alt="{{ $album->judul_event }}" loading="lazy">
                            </div>
                            <div class="portofolio-content">
                                <span class="ex-style-2e292406">
                                    <i class="far fa-calendar-alt me-2"></i>{!! $tglLabel !!}
                                </span>
                                <h3 class="portofolio-title">{{ $album->judul_event }}</h3>
                                <p class="portofolio-desc">{{ $album->deskripsi_event }}</p>

                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12 text-center text-muted">
                        <p>Belum ada portofolio yang ditampilkan.</p>
                    </div>
                @endif
            </div>

            {{-- Pagination Masterpieces --}}
            <div class="d-flex justify-content-center align-items-center gap-2 mt-5" id="albumPagination"></div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer py-5 mt-5 ex-style-c4092a3e" >
        <div class="container text-center text-md-start">
            <div class="row align-items-center">
                <div class="col-md-5 mb-4 mb-md-0">
                    <h3 class="footer-brand">{{ $settings['company_name'] ?? 'HOUSE OF SOUND' }}</h3>
                    <p class="text-white-50 mt-3 ex-style-2383b5f1" >{{ $settings['company_description'] ?? 'Penyedia solusi audio profesional untuk berbagai kebutuhan acara Anda.' }}</p>
                    <div class="mt-4 d-flex gap-3">
                        @php
                            $igLink = ltrim($settings['sosmed_ig'] ?? '', '#');
                            if (!empty($igLink) && !str_contains($igLink, '://') && !str_starts_with($igLink, 'http://') && !str_starts_with($igLink, 'https://')) {
                                $igLink = 'https://' . $igLink;
                            }
                        @endphp
                        @if(!empty($igLink))
                        <a href="{{ $igLink }}" target="_blank" class="text-white-50 fs-5"><i class="fab fa-instagram"></i></a>
                        @endif

                        @php
                            $ytLink = ltrim($settings['sosmed_yt'] ?? '', '#');
                            if (!empty($ytLink) && !str_contains($ytLink, '://') && !str_starts_with($ytLink, 'http://') && !str_starts_with($ytLink, 'https://')) {
                                $ytLink = 'https://' . $ytLink;
                            }
                        @endphp
                        @if(!empty($ytLink))
                        <a href="{{ $ytLink }}" target="_blank" class="text-white-50 fs-5"><i class="fab fa-youtube"></i></a>
                        @endif

                        @php
                            $tkLink = ltrim($settings['sosmed_tk'] ?? '', '#');
                            if (!empty($tkLink) && !str_contains($tkLink, '://') && !str_starts_with($tkLink, 'http://') && !str_starts_with($tkLink, 'https://')) {
                                $tkLink = 'https://' . $tkLink;
                            }
                        @endphp
                        @if(!empty($tkLink))
                        <a href="{{ $tkLink }}" target="_blank" class="text-white-50 fs-5"><i class="fab fa-tiktok"></i></a>
                        @endif
                    </div>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <h5 class="mb-4 ex-style-466c4d48" >Navigasi</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#katalog" class="text-white-50 text-decoration-none hover-white">Katalog Alat</a></li>
                        <li class="mb-2"><a href="#album" class="text-white-50 text-decoration-none hover-white">Album Dokumentasi</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-4 ex-style-466c4d48" >Kontak Hubungi</h5>
                    <p class="text-white-50 mb-2"><i class="fas fa-map-marker-alt me-2 ex-style-466c4d48" ></i> {{ $settings['address'] ?? 'Alamat belum diatur' }}</p>
                    <p class="text-white-50 mb-2"><i class="fas fa-envelope me-2 ex-style-466c4d48" ></i> {{ $settings['email'] ?? '-' }}</p>
                    <a href="https://wa.me/{{ $wa_num }}?text={{ $wa_msg }}" target="_blank" class="text-white-50 text-decoration-none hover-white"><i class="fab fa-whatsapp me-2 ex-style-466c4d48" ></i> {{ $settings['whatsapp'] ?? '-' }}</a>
                </div>
            </div>
            <hr class="my-5 ex-style-f4ccf739" >
            <div class="text-center text-white-50 small">
                &copy; {{ date('Y') }} {{ $settings['company_name'] ?? 'HOUSE OF SOUND' }}. Seluruh Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

    <!-- TOMBOL FLOATING SCAN QR -->
    <div class="mobile-qr-btn" data-bs-toggle="modal" data-bs-target="#qrModal" title="Buka di HP — Scan QR Code">
        <i class="fas fa-qrcode"></i>
        <span class="qr-label">Buka<br>di HP</span>
    </div>

    <!-- MODAL QR CODE -->
    @php
        // Mengambil IP Wi-Fi Lokal dari Komputer Windows secara otomatis
        $localIp = getHostByName(getHostName());
        // Jika loopback, coba dapatkan IP adapter jaringan Wi-Fi/Ethernet Windows
        if ($localIp === '127.0.0.1' || $localIp === '127.0.0.2') {
            if (stristr(PHP_OS, 'WIN')) {
                $ipconfig = shell_exec('ipconfig');
                if (preg_match_all('/IPv4 Address.*?: ([\d\.]+)/', $ipconfig, $matches)) {
                    foreach ($matches[1] as $ip) {
                        if ($ip !== '127.0.0.1' && $ip !== '127.0.0.2') {
                            $localIp = $ip;
                            break;
                        }
                    }
                }
            }
        }
        $mobileUrl = "http://" . $localIp . ":8000";
    @endphp
    <div class="modal fade" id="qrModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ex-style-8bb2a45a" >
          <div class="modal-header border-0">
            <h5 class="modal-title brand-font"><i class="fas fa-mobile-alt me-2 ex-style-f587d9a2" ></i> Pindai ke Layar HP</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center pb-5">
            <p class="mb-4 ex-style-5c922f94" >Buka kamera handphone Anda (iOS / Google Lens) dan arahkan ke kode kotak ini agar desain meluncur otomatis ke layar sentuh Anda tanpa perlu repot mengetik IP.</p>
            <div id="qrcode" class="d-flex justify-content-center bg-white p-3 mx-auto ex-style-e5501b74" ></div>
            <p class="mt-4 mb-0 ex-style-c1cb7c79" >{{ $mobileUrl }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL ZOOM (LIGHTBOX) -->
    <div class="modal fade ex-style-541413ab" id="modalZoom" tabindex="-1" >
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 bg-transparent position-relative">
                <!-- Close Button -->
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 fs-4 ex-style-21ced6db" data-bs-dismiss="modal" aria-label="Close" ></button>
                <div class="modal-body p-0 text-center position-relative">
                    <button class="btn text-white position-absolute start-0 top-50 translate-middle-y fs-1 ex-style-b9157e59" onclick="prevFoto()" ><i class="fas fa-chevron-left"></i></button>
                    <img id="zoomImg" src="" class="ex-style-1ecc78fa">
                    <button class="btn text-white position-absolute end-0 top-50 translate-middle-y fs-1 ex-style-b9157e59" onclick="nextFoto()" ><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <!-- FLOATING WHATSAPP -->
    <a href="https://wa.me/{{ $wa_num }}?text={{ $wa_msg }}" target="_blank" class="floating-wa">
        <i class="fab fa-whatsapp"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <!-- MODAL GALERI PUBLIK -->
    <div class="modal fade" id="modalPublik" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content ex-style-8e22ce90" >
                <div class="modal-header border-0 pb-0 d-flex align-items-center justify-content-between p-3">
                    <h5 class="modal-title text-hos ex-style-b1e965fa" id="pubTitle" ></h5>
                    <button type="button" class="btn-close btn-close-white ex-style-663dcb88" data-bs-dismiss="modal" aria-label="Close" ></button>
                </div>
                <div class="modal-body p-4">
                    <div id="pubContent" class="row g-3"></div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Init QR Code
        const qrContainer = document.getElementById("qrcode");
        if (qrContainer) {
            qrContainer.innerHTML = "";
            new QRCode(qrContainer, {
                text: "{{ $mobileUrl }}",
                width: 200,
                height: 200,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        }
        // Init AOS Animation with softer easing
        AOS.init({ once: true, offset: 0, duration: 1200, easing: 'ease-out-cubic' });

        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.navbar');
            if (nav) {
                if (window.scrollY > 50) nav.classList.add('scrolled');
                else nav.classList.remove('scrolled');
            }
        });

        // ============================================================
        // PAGINATION KATALOG ALAT
        // ============================================================
        const KATALOG_PER_PAGE = 9;
        let katalogCurrentPage = 1;
        let katalogActiveFilter = 'all';

        function getVisibleKatalogItems() {
            const all = Array.from(document.querySelectorAll('.alat-item'));
            if (katalogActiveFilter === 'all') return all;
            return all.filter(el => el.classList.contains('filter-' + katalogActiveFilter));
        }

        function renderKatalogPage(page) {
            katalogCurrentPage = page;
            const items = getVisibleKatalogItems();
            const totalPages = Math.ceil(items.length / KATALOG_PER_PAGE);
            const start = (page - 1) * KATALOG_PER_PAGE;
            const end = start + KATALOG_PER_PAGE;

            // Hide all then show current page
            document.querySelectorAll('.alat-item').forEach(el => el.style.display = 'none');
            items.slice(start, end).forEach(el => el.style.display = 'block');

            // Render pagination buttons
            renderKatalogPagination(totalPages);
            AOS.refresh();
        }

        function renderKatalogPagination(totalPages) {
            const pag = document.getElementById('katalogPagination');
            pag.style.display = totalPages <= 1 ? 'none' : 'flex';
            pag.innerHTML = '';

            // Prev button
            const prevBtn = document.createElement('button');
            prevBtn.className = 'btn btn-outline-hos px-3 py-2';
            prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
            prevBtn.disabled = katalogCurrentPage === 1;
            prevBtn.onclick = () => { if(katalogCurrentPage > 1) renderKatalogPage(katalogCurrentPage - 1); };
            pag.appendChild(prevBtn);

            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.className = 'btn px-3 py-2 ' + (i === katalogCurrentPage ? 'btn-hos' : 'btn-outline-hos');
                btn.innerText = i;
                btn.onclick = (() => { const p = i; return () => renderKatalogPage(p); })();
                pag.appendChild(btn);
            }

            // Next button
            const nextBtn = document.createElement('button');
            nextBtn.className = 'btn btn-outline-hos px-3 py-2';
            nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
            nextBtn.disabled = katalogCurrentPage === totalPages;
            nextBtn.onclick = () => { if(katalogCurrentPage < totalPages) renderKatalogPage(katalogCurrentPage + 1); };
            pag.appendChild(nextBtn);
        }

        function filterAlat(cat, btn) {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            katalogActiveFilter = cat;
            renderKatalogPage(1);
        }

        // Init katalog pagination on load
        document.addEventListener('DOMContentLoaded', function() {
            renderKatalogPage(1);
            initAlbumPagination();
        });

        // ============================================================
        // PAGINATION MASTERPIECES
        // ============================================================
        const ALBUM_PER_PAGE = 6;
        let albumCurrentPage = 1;

        function initAlbumPagination() {
            renderAlbumPage(1);
        }

        function renderAlbumPage(page) {
            albumCurrentPage = page;
            const items = Array.from(document.querySelectorAll('.album-item'));
            const totalPages = Math.ceil(items.length / ALBUM_PER_PAGE);
            const start = (page - 1) * ALBUM_PER_PAGE;
            const end = start + ALBUM_PER_PAGE;

            items.forEach((el, idx) => {
                el.style.display = (idx >= start && idx < end) ? 'block' : 'none';
            });

            renderAlbumPagination(totalPages);
            AOS.refresh();
        }

        function renderAlbumPagination(totalPages) {
            const pag = document.getElementById('albumPagination');
            pag.style.display = totalPages <= 1 ? 'none' : 'flex';
            pag.innerHTML = '';

            const prevBtn = document.createElement('button');
            prevBtn.className = 'btn btn-outline-hos px-3 py-2';
            prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
            prevBtn.disabled = albumCurrentPage === 1;
            prevBtn.onclick = () => { if(albumCurrentPage > 1) renderAlbumPage(albumCurrentPage - 1); };
            pag.appendChild(prevBtn);

            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.className = 'btn px-3 py-2 ' + (i === albumCurrentPage ? 'btn-hos' : 'btn-outline-hos');
                btn.innerText = i;
                btn.onclick = (() => { const p = i; return () => renderAlbumPage(p); })();
                pag.appendChild(btn);
            }

            const nextBtn = document.createElement('button');
            nextBtn.className = 'btn btn-outline-hos px-3 py-2';
            nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
            nextBtn.disabled = albumCurrentPage === totalPages;
            nextBtn.onclick = () => { if(albumCurrentPage < totalPages) renderAlbumPage(albumCurrentPage + 1); };
            pag.appendChild(nextBtn);
        }

        // Fitur Galeri Canggih
        let listGaleri = [];
        let indexAktif = 0;

        function initGaleriPublik(el) {
            const judul = el.getAttribute('data-judul');
            const dataRaw = el.getAttribute('data-galleries');
            listGaleri = JSON.parse(dataRaw);
            
            document.getElementById('pubTitle').innerText = judul;
            const content = document.getElementById('pubContent');
            content.innerHTML = "";
            
            if(listGaleri.length === 0) {
                content.innerHTML = "<div class='col-12 text-center py-5 text-muted'>Dokumentasi belum diunggah.</div>";
            }

            listGaleri.forEach((item, index) => {
                const isVideo = item.file_type === 'video';
                let html = `<div class="col-6 col-md-6 mb-3">`;
                if(isVideo) {
                    html += `<video controls class="ex-style-41438fba"><source src="/${item.file_path}"></video>`;
                } else {
                    html += `<img src="/${item.file_path}" class="img-fluid rounded-4 shadow-sm ex-style-1ef8a07f"  onclick="zoomFoto(${index})">`;
                }
                html += `</div>`;
                content.innerHTML += html;
            });

            new bootstrap.Modal(document.getElementById('modalPublik')).show();
        }

        function zoomFoto(index) {
            indexAktif = index;
            const item = listGaleri[indexAktif];
            if(item.file_type === 'video') return; // Zoom hanya untuk foto
            
            document.getElementById('zoomImg').src = '/' + item.file_path;
            const zoomModal = new bootstrap.Modal(document.getElementById('modalZoom'));
            zoomModal.show();
        }

        function nextFoto() {
            let found = false;
            let tempIndex = indexAktif;
            while(tempIndex < listGaleri.length - 1) {
                tempIndex++;
                if(listGaleri[tempIndex].file_type !== 'video') {
                    indexAktif = tempIndex;
                    found = true;
                    break;
                }
            }
            if(found) {
                document.getElementById('zoomImg').style.opacity = '0';
                setTimeout(() => {
                    document.getElementById('zoomImg').src = '/' + listGaleri[indexAktif].file_path;
                    document.getElementById('zoomImg').style.opacity = '1';
                }, 200);
            }
        }

        function prevFoto() {
            let found = false;
            let tempIndex = indexAktif;
            while(tempIndex > 0) {
                tempIndex--;
                if(listGaleri[tempIndex].file_type !== 'video') {
                    indexAktif = tempIndex;
                    found = true;
                    break;
                }
            }
            if(found) {
                document.getElementById('zoomImg').style.opacity = '0';
                setTimeout(() => {
                    document.getElementById('zoomImg').src = '/' + listGaleri[indexAktif].file_path;
                    document.getElementById('zoomImg').style.opacity = '1';
                }, 200);
            }
        }

        // Keyboard Listener
        document.addEventListener('keydown', function(e) {
            const zoomModal = document.getElementById('modalZoom');
            if (zoomModal.classList.contains('show')) {
                if (e.key === 'ArrowRight') nextFoto();
                if (e.key === 'ArrowLeft') prevFoto();
            }
        });

        // ==========================================
        // HIGH SECURITY: HIDDEN ADMIN PORTAL TRIGGER
        // ==========================================
        // ==========================================
        let clicks = 0;
        const brandBtn = document.getElementById('brand-logo');
        if(brandBtn) {
            brandBtn.addEventListener('click', function(e) {
                e.preventDefault();
                clicks++;
                if (clicks === 2) {
                    document.body.style.transition = 'all 0.6s';
                    document.body.style.opacity = '0';
                    setTimeout(() => { window.location.href = '/login'; }, 600);
                }
                setTimeout(() => { clicks = 0; }, 400); 
            });
        }

        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey && event.altKey && event.key.toLowerCase() === 'l') {
                document.body.style.transition = 'all 0.6s';
                document.body.style.opacity = '0';
                setTimeout(() => { window.location.href = '/login'; }, 600);
            }
        });
        // ==========================================

        // Subtle Refined Particles
        particlesJS("particles-js", {
            "particles": {
                "number": { "value": 40, "density": { "enable": true, "value_area": 1200 } },
                "color": { "value": ["#10B981", "#ffffff"] },
                "shape": { "type": "circle" },
                "opacity": { "value": 0.4, "random": true, "anim": { "enable": true, "speed": 0.5, "opacity_min": 0.1, "sync": false } },
                "size": { "value": 2, "random": true, "anim": { "enable": true, "speed": 1, "size_min": 0.1, "sync": false } },
                "line_linked": { "enable": false }, /* Removed lines to make it more like dust/champagne */
                "move": { "enable": true, "speed": 0.6, "direction": "top", "random": true, "straight": false, "out_mode": "out", "bounce": false }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": { "onhover": { "enable": true, "mode": "bubble" }, "onclick": { "enable": false }, "resize": true },
                "modes": { "bubble": { "distance": 200, "size": 3, "duration": 2, "opacity": 0.8, "speed": 3 } }
            },
            "retina_detect": true
        });
    </script>

    <!-- MOBILE FLOATING DOCK BAR (UI/UX PRO MAX) -->
    <div class="mobile-bottom-dock d-lg-none" role="navigation" aria-label="Mobile Navigation">
        <a href="#hero" class="mobile-dock-btn active" title="Beranda">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="#katalog" class="mobile-dock-btn" title="Katalog">
            <i class="fas fa-boxes"></i>
            <span>Katalog</span>
        </a>
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp'] ?? '62895349213579') }}?text={{ urlencode($settings['wa_message'] ?? 'Halo House of Salbai, saya ingin konsultasi logistik acara.') }}" target="_blank" class="mobile-dock-btn highlight-wa" title="Konsultasi WhatsApp">
            <i class="fab fa-whatsapp"></i>
            <span>WhatsApp</span>
        </a>
        <a href="#galeri" class="mobile-dock-btn" title="Portofolio Acara">
            <i class="fas fa-camera-retro"></i>
            <span>Album</span>
        </a>
        <a href="/login" class="mobile-dock-btn" title="Login Admin">
            <i class="fas fa-user-lock"></i>
            <span>Portal</span>
        </a>
    </div>

    <style>
        /* ========================================================
           UI/UX PRO MAX: MOBILE BOTTOM DOCK BAR & TOUCH TARGETS
           ======================================================== */
        .mobile-bottom-dock {
            position: fixed;
            bottom: 18px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 32px);
            max-width: 420px;
            background: rgba(10, 10, 14, 0.88);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(16, 185, 129, 0.28);
            border-radius: 36px;
            padding: 8px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 9999;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.85), 0 0 30px rgba(16, 185, 129, 0.15);
            animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .mobile-dock-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.68rem;
            font-weight: 600;
            padding: 6px 10px;
            border-radius: 16px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            gap: 3px;
            min-width: 52px;
            touch-action: manipulation;
        }
        .mobile-dock-btn i {
            font-size: 1.15rem;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .mobile-dock-btn:hover, .mobile-dock-btn:focus, .mobile-dock-btn.active {
            color: #10B981;
        }
        .mobile-dock-btn:active {
            transform: scale(0.92);
        }
        .mobile-dock-btn.highlight-wa {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.25), rgba(5, 150, 105, 0.15));
            color: #10B981;
            border: 1px solid rgba(16, 185, 129, 0.4);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
            border-radius: 20px;
            padding: 6px 14px;
        }
        .mobile-dock-btn.highlight-wa i {
            color: #10B981;
        }

        /* Tactile Button Feedback */
        .btn, .catalog-card, .album-card {
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn:active {
            transform: scale(0.96) !important;
        }
        .catalog-card:hover, .album-card:hover {
            border-color: rgba(16, 185, 129, 0.35) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.7), 0 0 25px rgba(16, 185, 129, 0.12) !important;
        }

        @media (max-width: 991px) {
            body {
                padding-bottom: 90px;
            }
        }
    </style>
</body>
</html>
