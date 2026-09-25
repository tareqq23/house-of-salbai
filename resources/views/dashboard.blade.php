<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | House of Salbai</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        :root {
            --bg-obsidian: #050505;
            --text-white: #ffffff;
            --text-grey: #a1a1a6;
            --accent-green: #10B981; /* Premium Emerald */
            --accent-green-glow: rgba(16, 185, 129, 0.3);
            --glass-border: rgba(255, 255, 255, 0.08);
            --primary-green: #10B981;
        }

        body { background: var(--bg-obsidian); color: var(--text-white); font-family: 'Inter', sans-serif; overflow-x: hidden; position: relative; }
        
        /* Custom Premium Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: rgba(5, 5, 5, 0.5); }
        ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, rgba(16, 185, 129, 0.5) 0%, rgba(5, 150, 105, 0.3) 100%); border-radius: 4px; transition: background 0.3s; }
        ::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg, rgba(16, 185, 129, 0.9) 0%, rgba(5, 150, 105, 0.7) 100%); }

        /* Entry Animations */
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes shimmer {
            0%   { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        @keyframes float-orb {
            0%,100% { transform: translate(0,0) scale(1); }
            33%     { transform: translate(20px,-30px) scale(1.05); }
            66%     { transform: translate(-15px,20px) scale(0.97); }
        }
        @keyframes borderGlow {
            0%,100% { border-color: rgba(16,185,129,0.15); }
            50%     { border-color: rgba(16,185,129,0.45); }
        }
        @keyframes countUp {
            from { opacity: 0; transform: scale(0.7) translateY(10px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        .animate-fade-up { animation: fadeSlideUp 0.6s cubic-bezier(0.4,0,0.2,1) both; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }

        /* Glowing background decorations (mesh gradients) */
        .glowing-orb-1 {
            position: fixed;
            top: -250px;
            left: -250px;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0) 65%);
            z-index: -1;
            pointer-events: none;
            filter: blur(60px);
            animation: float-orb 18s ease-in-out infinite;
        }
        .glowing-orb-2 {
            position: fixed;
            bottom: -350px;
            right: -350px;
            width: 900px;
            height: 900px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.06) 0%, rgba(5, 150, 105, 0) 65%);
            z-index: -1;
            pointer-events: none;
            filter: blur(80px);
            animation: float-orb 24s ease-in-out infinite reverse;
        }
        .glowing-orb-3 {
            position: fixed;
            top: 40%;
            left: 30%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.025) 0%, transparent 70%);
            z-index: -1;
            pointer-events: none;
            filter: blur(80px);
            animation: float-orb 30s ease-in-out infinite;
        }

        /* Sidebar Glassmorphism */
        .sidebar { 
            background: rgba(8, 8, 10, 0.7) !important; 
            backdrop-filter: blur(25px); 
            border-right: 1px solid rgba(255, 255, 255, 0.05); 
            position: fixed; 
            z-index: 1000; 
            min-height: 100vh; 
            width: 16.666667%; 
            box-shadow: 10px 0 30px rgba(0,0,0,0.5);
        }

        /* MOBILE NAV BAR */
        .mobile-top-nav {
            display: none;
            background: rgba(13, 13, 18, 0.85);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(16, 185, 129, 0.2);
            padding: 15px 20px;
            position: sticky;
            top: 0;
            z-index: 2000;
        }

        @media (max-width: 768px) {
            .mobile-top-nav { display: flex !important; justify-content: space-between; align-items: center; }
            .sidebar { display: none !important; }
            main { margin-left: 0 !important; padding: 25px 15px !important; }
            h2[style*="font-size: 3rem"] { font-size: 1.6rem !important; }
            .stats-card h3, .stats-card h4 { font-size: 1.3rem !important; }
        }
        /* Sidebar Branding */
        .sidebar-logo-area { padding: 25px 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .sidebar-logo-area img { width: 36px; height: 36px; object-fit: contain; border-radius: 8px; flex-shrink: 0; }
        .sidebar-logo-area .brand-name { font-family: 'Outfit'; font-size: 0.95rem; font-weight: 700; color: #fff; letter-spacing: 0.5px; line-height: 1.2; }
        .sidebar-logo-area .brand-name span { color: var(--accent-green); font-size: 0.7rem; font-weight: 600; display: block; letter-spacing: 1.5px; text-transform: uppercase; opacity: 0.9; margin-top: 2px; }
        .sidebar-logo-text { font-family: 'Outfit'; font-size: 1.2rem; font-weight: 800; color: #fff; border: 1px solid var(--accent-green); border-radius: 8px; padding: 6px 12px; letter-spacing: -0.5px; }
        .sidebar-logo-text em { color: var(--accent-green); font-style: normal; }

        /* Navigation */
        .sidebar-nav-label { font-size: 0.65rem; font-weight: 700; letter-spacing: 2px; color: var(--text-grey); padding: 24px 24px 8px; text-transform: uppercase; opacity: 0.5; }
        .nav-pills .nav-link { 
            color: var(--text-grey); 
            margin: 4px 12px; 
            font-size: 0.85rem; 
            border-radius: 8px; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            text-align: left; 
            background: transparent; 
            border: none; 
            font-weight: 500; 
            padding: 11px 16px; 
            border-left: 3px solid transparent;
        }
        .nav-pills .nav-link i { width: 20px; opacity: 0.6; transition: all 0.3s; margin-right: 8px; }
        .nav-pills .nav-link:hover { color: #fff; background: rgba(255,255,255,0.04); padding-left: 20px; }
        .nav-pills .nav-link:hover i { opacity: 1; color: var(--accent-green); }
        
        /* Active Sidebar Indicator */
        .nav-pills .nav-link.active { 
            background: linear-gradient(90deg, rgba(16, 185, 129, 0.12) 0%, rgba(16, 185, 129, 0.02) 100%) !important; 
            color: var(--accent-green) !important; 
            font-weight: 600; 
            border-left: 3px solid var(--accent-green) !important;
            border-radius: 0 8px 8px 0;
            margin-left: 0;
            padding-left: 20px;
            box-shadow: inset 5px 0 15px rgba(16, 185, 129, 0.05);
        }
        .nav-pills .nav-link.active i { opacity: 1; color: var(--accent-green); }
        .nav-pills .nav-link { position: relative; }

        /* Pulsing status indicator */
        @keyframes pulse-green {
            0% { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1.1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        /* Shimmer text gradient animation */
        .text-shimmer {
            background: linear-gradient(90deg, #ffffff 0%, #10B981 40%, #a1a1a6 60%, #ffffff 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 4s linear infinite;
        }
        .text-gradient-green {
            background: linear-gradient(135deg, #ffffff 0%, #10B981 60%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Section Page Hero Headers (reusable across tabs) */
        .page-hero-header {
            position: relative;
            margin-bottom: 32px;
            padding: 28px 32px;
            background: linear-gradient(135deg, rgba(16,185,129,0.06) 0%, rgba(5,5,5,0.3) 100%);
            border: 1px solid rgba(16,185,129,0.12);
            border-radius: 18px;
            backdrop-filter: blur(16px);
            overflow: hidden;
        }
        .page-hero-header::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 200px; height: 200px;
            background: rgba(16,185,129,0.07);
            filter: blur(50px);
            border-radius: 50%;
            pointer-events: none;
        }
        .page-hero-header .hero-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }
        .page-hero-header h4 {
            font-family: 'Outfit';
            font-size: 1.6rem;
            font-weight: 800;
            margin: 0;
            line-height: 1.2;
        }
        .page-hero-header p {
            color: rgba(255,255,255,0.45);
            font-size: 0.88rem;
            margin: 4px 0 0;
        }

        /* Sidebar Footer */
        .sidebar-footer { padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.05); }
        .sidebar-footer .btn-view-site { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 10px; background: rgba(16,185,129,0.06); border: 1px solid rgba(16,185,129,0.15); color: var(--accent-green); font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all 0.25s; width: 100%; }
        .sidebar-footer .btn-view-site:hover { background: rgba(16,185,129,0.15); border-color: var(--accent-green); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1); }
        .sidebar-footer .btn-logout { display: flex; align-items: center; gap: 8px; padding: 8px 14px; color: rgba(255,255,255,0.35); font-size: 0.8rem; background: none; border: none; width: 100%; margin-top: 4px; border-radius: 8px; transition: all 0.2s; cursor: pointer; }
        .sidebar-footer .btn-logout:hover { color: #f87171; background: rgba(248,113,113,0.08); }

        main { margin-left: 16.666667%; padding: 40px 50px; min-height: 100vh; position: relative; z-index: 1; }
        
        /* Premium Cards */
        .card { 
            background: rgba(20, 20, 25, 0.45); 
            backdrop-filter: blur(20px); 
            border: 1px solid rgba(255, 255, 255, 0.05); 
            border-radius: 16px; 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
            margin-bottom: 25px; 
        }
        .card:hover { border-color: rgba(16, 185, 129, 0.25); box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
        
        .text-hos { color: var(--accent-green); font-weight: 700; font-family: 'Outfit'; }
        
        /* High-Visibility Buttons */
        .btn-hos { 
            background: linear-gradient(135deg, var(--accent-green), #059669); 
            color: #000 !important; 
            font-weight: 700; 
            padding: 11px 24px; 
            border-radius: 8px; 
            border: none; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);
        }
        .btn-hos:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4); filter: brightness(1.15); }
        
        .btn-outline-hos {
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: var(--accent-green);
            background: rgba(16, 185, 129, 0.02);
            font-weight: 600;
            padding: 11px 24px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .btn-outline-hos:hover {
            background: rgba(16, 185, 129, 0.12);
            color: #fff !important;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.15);
            border-color: var(--accent-green);
            transform: translateY(-2px);
        }

        .btn-outline-warning { border-color: rgba(16, 185, 129, 0.3); color: var(--accent-green); }
        .btn-outline-warning:hover { background: var(--accent-green); color: #000; }

        /* Specific Stats Cards Theme Styling */
        .stats-card-container {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        .stats-card-container:hover {
            transform: translateY(-8px) scale(1.02);
        }
        .stat-number {
            font-family: 'Outfit';
            font-size: 3.2rem;
            font-weight: 900;
            letter-spacing: -2px;
            line-height: 1;
            animation: countUp 0.7s cubic-bezier(0.34,1.56,0.64,1) both;
        }
        .stat-icon-wrap {
            width: 54px; height: 54px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            position: relative;
        }
        .stat-icon-wrap::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 14px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .stats-card-container:hover .stat-icon-wrap::after { opacity: 1; }
        .stats-card-emerald {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.02) 100%) !important;
            border: 1px solid rgba(16, 185, 129, 0.15) !important;
            animation: borderGlow 3s ease-in-out infinite;
        }
        .stats-card-emerald .stat-number { color: #10B981; }
        .stats-card-emerald:hover {
            border-color: rgba(16, 185, 129, 0.5) !important;
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.12), 0 0 25px rgba(16, 185, 129, 0.08) !important;
        }
        .stats-card-purple {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(139, 92, 246, 0.02) 100%) !important;
            border: 1px solid rgba(139, 92, 246, 0.15) !important;
        }
        .stats-card-purple .stat-number { color: #8b5cf6; }
        .stats-card-purple:hover {
            border-color: rgba(139, 92, 246, 0.5) !important;
            box-shadow: 0 20px 40px rgba(139, 92, 246, 0.12), 0 0 25px rgba(139, 92, 246, 0.08) !important;
        }
        .stats-card-amber {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(245, 158, 11, 0.02) 100%) !important;
            border: 1px solid rgba(245, 158, 11, 0.15) !important;
        }
        .stats-card-amber .stat-number { color: #f59e0b; }
        .stats-card-amber:hover {
            border-color: rgba(245, 158, 11, 0.5) !important;
            box-shadow: 0 20px 40px rgba(245, 158, 11, 0.12), 0 0 25px rgba(245, 158, 11, 0.08) !important;
        }
        .stats-card-cyan {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(6, 182, 212, 0.02) 100%) !important;
            border: 1px solid rgba(6, 182, 212, 0.15) !important;
        }
        .stats-card-cyan .stat-number { color: #06b6d4; }
        .stats-card-cyan:hover {
            border-color: rgba(6, 182, 212, 0.5) !important;
            box-shadow: 0 20px 40px rgba(6, 182, 212, 0.12), 0 0 25px rgba(6, 182, 212, 0.08) !important;
        }
        
        /* Modal & Tabs */
        .modal-content {
            background: rgba(15, 15, 18, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.25);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8), 0 0 40px rgba(16, 185, 129, 0.05);
        }
        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 24px 28px;
        }
        .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding: 20px 28px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 0 0 20px 20px;
            position: relative;
        }
        .modal-body {
            max-height: calc(100vh - 250px);
            overflow-y: auto;
            padding: 28px;
        }
        
        .nav-tabs .nav-link { color: var(--text-grey); border: none; font-weight: 600; padding: 15px 20px; }
        .nav-tabs .nav-link.active { background: transparent !important; color: var(--accent-green) !important; border-bottom: 3px solid var(--accent-green) !important; }

        /* Global High Contrast Fixes for Dark Mode Text, Labels, Small & Placeholder */
        .text-muted {
            color: rgba(255, 255, 255, 0.72) !important;
        }
        label {
            color: #e5e7eb !important;
            font-weight: 500;
        }
        label.text-hos, .text-hos {
            color: var(--accent-green) !important;
        }
        small, .small {
            color: rgba(255, 255, 255, 0.72) !important;
        }

        .form-control, .form-select {
            background: rgba(15, 15, 18, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #fff !important;
            padding: 12px 16px;
            border-radius: 10px;
            transition: all 0.25s;
        }
        .form-control:focus, .form-select:focus {
            background: rgba(22, 22, 27, 0.9) !important;
            border-color: var(--accent-green) !important;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15) !important;
        }
        .form-control::placeholder, .form-select::placeholder, textarea::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="datetime-local"]::-webkit-calendar-picker-indicator {
            filter: invert(0.9);
            cursor: pointer;
        }

        input[type="file"]::file-selector-button {
            background: rgba(255, 255, 255, 0.12) !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
            border-radius: 6px;
            padding: 4px 12px;
            margin-right: 10px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        input[type="file"]::file-selector-button:hover {
            background: rgba(16, 185, 129, 0.25) !important;
            color: var(--accent-green) !important;
        }

        #manifestItemArea, #manualItemArea {
            max-height: 400px; overflow-y: auto;
            background: rgba(0,0,0,0.2); border-radius: 12px; padding: 15px; margin-bottom: 15px;
            border: 1px dashed rgba(16, 185, 129, 0.3);
        }

        /* Translucent Glowing Badges */
        .badge {
            font-family: 'Inter';
            font-weight: 600;
            font-size: 0.7rem;
            letter-spacing: 0.5px;
            padding: 6px 12px;
            border-radius: 6px;
            text-transform: uppercase;
        }
        .badge.bg-success {
            background: rgba(16, 185, 129, 0.15) !important;
            color: #10B981 !important;
            border: 1px solid rgba(16, 185, 129, 0.25);
        }
        .badge.bg-danger {
            background: rgba(239, 68, 68, 0.15) !important;
            color: #ef4444 !important;
            border: 1px solid rgba(239, 68, 68, 0.25);
        }
        .badge.bg-warning {
            background: rgba(245, 158, 11, 0.15) !important;
            color: #f59e0b !important;
            border: 1px solid rgba(245, 158, 11, 0.25);
        }
        .badge.bg-info {
            background: rgba(59, 130, 246, 0.15) !important;
            color: #3b82f6 !important;
            border: 1px solid rgba(59, 130, 246, 0.25);
        }
        .badge.badge-hos {
            background: rgba(16, 185, 129, 0.15) !important;
            color: #10B981 !important;
            border: 1px solid rgba(16, 185, 129, 0.25);
        }

        /* Premium Table Polish */
        .table-responsive {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(20, 20, 22, 0.4);
            backdrop-filter: blur(10px);
        }
        .table {
            margin-bottom: 0 !important;
            color: #f3f4f6 !important;
        }
        .table tr {
            border-color: rgba(255, 255, 255, 0.05) !important;
            transition: all 0.2s;
        }
        .table tbody tr:hover {
            background: rgba(16, 185, 129, 0.02) !important;
        }
        .table th {
            background: rgba(0, 0, 0, 0.35) !important;
            color: #a1a1a6 !important;
            font-family: 'Outfit';
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 18px 16px !important;
            border-bottom: 1px solid rgba(16, 185, 129, 0.2) !important;
        }
        .table td {
            padding: 16px 16px !important;
            vertical-align: middle;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04) !important;
        }

        /* Album Event Styling */
        .album-card {
            background: rgba(14, 14, 18, 0.7) !important;
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 18px;
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            backdrop-filter: blur(12px);
        }
        .album-card:hover {
            border-color: rgba(16, 185, 129, 0.35);
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.5), 0 0 20px rgba(16, 185, 129, 0.05);
        }
        .album-cover {
            height: 180px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(16,185,129,0.05) 0%, rgba(20,20,25,0.9) 100%);
        }
        .album-cover img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.4,0,0.2,1), opacity 0.3s;
            opacity: 0.75;
        }
        .album-card:hover .album-cover img { transform: scale(1.08); opacity: 0.9; }
        .album-cover-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(8,8,10,0.95) 0%, rgba(8,8,10,0.1) 60%);
        }
        .album-cover-placeholder {
            width: 100%; height: 100%;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: 8px; color: rgba(16,185,129,0.4);
        }
        .album-badge {
            position: absolute; top: 12px; right: 12px;
            background: rgba(16,185,129,0.2);
            border: 1px solid rgba(16,185,129,0.4);
            color: #10B981; font-size: 0.65rem;
            font-weight: 700; letter-spacing: 1px;
            padding: 4px 10px; border-radius: 20px;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }
        .album-card-body { padding: 20px; }
        .album-title { font-family: 'Outfit'; font-weight: 700; font-size: 1.05rem; color: #fff; margin-bottom: 8px; line-height: 1.3; }
        .album-meta { font-size: 0.8rem; color: rgba(255,255,255,0.4); display: flex; align-items: center; gap: 6px; margin-bottom: 4px; }
        .album-meta i { color: var(--accent-green); opacity: 0.8; }
        .album-actions { display: flex; gap: 8px; margin-top: 16px; }
        .album-actions .btn-open {
            flex: 1; background: linear-gradient(135deg, rgba(16,185,129,0.15) 0%, rgba(16,185,129,0.05) 100%);
            border: 1px solid rgba(16,185,129,0.3); color: #10B981;
            font-size: 0.82rem; font-weight: 600; border-radius: 10px;
            padding: 9px 14px; transition: all 0.25s;
        }
        .album-actions .btn-open:hover { background: rgba(16,185,129,0.25); border-color: var(--accent-green); color: #fff; }

        .stats-card { background: linear-gradient(145deg, rgba(255,255,255,0.05), rgba(255,255,255,0.01)); transition: all 0.3s; }
        .stats-card:hover { transform: translateY(-5px); background: rgba(255,255,255,0.08); }



        /* CMS Styling enhancements */
        .cms-section-card {
            background: rgba(25, 25, 25, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 25px;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            backdrop-filter: blur(12px);
        }
        .cms-section-card:hover {
            border-color: rgba(16, 185, 129, 0.25);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.5), 0 0 20px rgba(16, 185, 129, 0.05);
        }
        .cms-header-title {
            font-family: 'Outfit';
            font-weight: 700;
            color: #fff;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(16, 185, 129, 0.15);
        }
        .cms-header-title i {
            color: var(--accent-green);
        }
        .cms-input-group {
            margin-bottom: 20px;
        }
        .cms-input-group label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-weight: 700;
            color: var(--text-grey);
            margin-bottom: 8px;
            display: block;
        }
        .cms-input-group .form-control, .cms-input-group .form-select {
            background: rgba(15, 15, 18, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: #fff;
            padding: 12px 16px;
            border-radius: 10px;
            transition: all 0.25s;
        }
        .cms-input-group .form-control:focus, .cms-input-group .form-select:focus {
            background: rgba(22, 22, 27, 0.9);
            border-color: var(--accent-green);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        }
        .cms-stat-box {
            background: rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.04);
            border-radius: 12px;
            padding: 18px;
            transition: all 0.25s ease;
        }
        .cms-stat-box:focus-within {
            border-color: rgba(16, 185, 129, 0.3);
            background: rgba(16, 185, 129, 0.02);
        }
        .cms-sidebar-card {
            background: rgba(20, 20, 22, 0.9);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 16px;
            padding: 24px;
            backdrop-filter: blur(12px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
        }
        .media-upload-card {
            background: rgba(10, 10, 12, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
            transition: all 0.25s;
        }
        .media-upload-card:hover {
            border-color: rgba(16, 185, 129, 0.3);
            background: rgba(16, 185, 129, 0.01);
        }
        .media-preview-box {
            position: relative;
            background: rgba(0, 0, 0, 0.4);
            border: 1px dashed rgba(16, 185, 129, 0.2);
            border-radius: 10px;
            padding: 12px;
            margin-top: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            transition: all 0.25s;
        }
        .media-preview-box:hover {
            border-color: var(--accent-green);
            background: rgba(16, 185, 129, 0.03);
        }
        .media-preview-img {
            max-height: 80px;
            max-width: 100%;
            object-fit: contain;
            border-radius: 6px;
            transition: transform 0.3s;
        }
        .media-preview-box:hover .media-preview-img {
            transform: scale(1.05);
        }
        .trash-action-btn {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border-radius: 8px;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            cursor: pointer;
            text-decoration: none;
        }
        .trash-action-btn:hover {
            background: #ef4444;
            color: #fff;
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.4);
        }
        .active-btn-glow {
            background: linear-gradient(135deg, var(--accent-green) 0%, #059669 100%) !important;
            color: #000 !important;
            font-weight: 800 !important;
            border: none !important;
            letter-spacing: 1px;
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.25) !important;
            transition: all 0.3s ease !important;
        }
        .active-btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(16, 185, 129, 0.45) !important;
            filter: brightness(1.1);
        }
        .mobile-vendor-card, .mobile-user-card {
            background: rgba(20, 20, 25, 0.8);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            backdrop-filter: blur(12px);
        }
        .mobile-user-card .user-form {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }
        .mobile-user-card .user-form .form-control,
        .mobile-user-card .user-form .btn {
            width: 100%;
            min-height: 44px;
        }
        .mobile-user-form-panel {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            border: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.03);
        }
        .mobile-report-card {
            background: rgba(20, 20, 25, 0.78);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            backdrop-filter: blur(12px);
        }
        .user-action-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.5rem;
        }
        .user-action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            width: 100%;
            border: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.04);
            color: #f5f5f5;
            border-radius: 10px;
            padding: 0.6rem 0.7rem;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .user-action-btn:hover {
            background: rgba(16, 185, 129, 0.12);
            border-color: rgba(16, 185, 129, 0.25);
            color: #10B981;
            transform: translateY(-1px);
        }
        @media (max-width: 767.98px) {
            body {
                padding-top: 0;
            }
            .mobile-top-nav {
                display: flex;
            }
            main.col-md-9.ms-sm-auto.col-lg-10.px-md-4.py-5 {
                padding-top: 1rem !important;
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            .page-hero-header {
                padding: 20px 18px;
            }
            .page-hero-header > .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }
            .page-hero-header .hero-icon {
                width: 44px;
                height: 44px;
            }
            .page-hero-header h4 {
                font-size: 1.15rem;
            }
            .page-hero-header p {
                font-size: 0.82rem;
            }
            .mobile-vendor-card + .mobile-vendor-card,
            .mobile-user-card + .mobile-user-card {
                margin-top: 0.75rem;
            }
            .mobile-user-card .user-form {
                flex-direction: column;
                align-items: stretch;
            }
            .mobile-user-card .user-form .form-control,
            .mobile-user-card .user-form .btn {
                max-width: 100% !important;
            }
            .stats-card-container .card {
                padding: 1rem !important;
            }
            .stats-card-container .stat-number {
                font-size: 1.7rem !important;
            }
            .card-body.p-4,
            .card-body.p-5 {
                padding: 1rem !important;
            }
            .hero-actions .btn,
            .btn-hos,
            .btn-outline-hos,
            .btn {
                width: 100%;
            }
            .album-actions {
                flex-direction: column;
                align-items: stretch;
            }
            .album-actions > * {
                width: 100% !important;
            }
            .cms-sidebar-card,
            .cms-section-card,
            .media-upload-card,
            .cms-input-group {
                width: 100%;
                max-width: 100%;
            }
            .form-control,
            .form-select,
            textarea {
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body class="bg-obsidian text-white">
    <!-- GLOWING BACKGROUND ORBS -->
    <div class="glowing-orb-1"></div>
    <div class="glowing-orb-2"></div>
    <div class="glowing-orb-3"></div>

    <!-- MOBILE TOP NAV -->
    <div class="mobile-top-nav">
        <a href="/dashboard" class="text-white text-decoration-none fw-bold">
            @if(isset($settings['company_logo']))
                <img src="{{ asset('img/'.$settings['company_logo']) }}" style="max-height: 25px; width: auto; object-fit: contain; filter: brightness(0) invert(1);">
            @else
                <i class="fas fa-home text-hos me-1"></i> SALBAI
            @endif
        </a>
        <div class="d-flex gap-2">
            <a href="/" class="btn btn-outline-hos btn-sm"><i class="fas fa-external-link-alt"></i> Website</a>
            <div class="dropdown">
                <button class="btn btn-hos btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Menu
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow-lg border-hos">
                    <li><button class="dropdown-item py-2" onclick="switchTab('v-pills-home')"><i class="fas fa-home me-2"></i> Dashboard Utama</button></li>
                    @if(Auth::user() && Auth::user()->isAdmin())
                        <li><button class="dropdown-item py-2" onclick="switchTab('v-pills-approval')"><i class="fas fa-clipboard-check me-2"></i> Persetujuan Konten</button></li>
                    @endif
                    <li><button class="dropdown-item py-2" onclick="switchTab('v-pills-inventaris')"><i class="fas fa-boxes me-2"></i> Inventaris</button></li>
                    <li><button class="dropdown-item py-2" onclick="switchTab('v-pills-album')"><i class="fas fa-camera-retro me-2"></i> Album Event</button></li>
                    <li><button class="dropdown-item py-2" onclick="switchTab('v-pills-manifes')"><i class="fas fa-file-invoice me-2"></i> Manifes Alat</button></li>
                    @if(Auth::user() && Auth::user()->isAdmin())
                        <li><button class="dropdown-item py-2" onclick="switchTab('v-pills-vendor')"><i class="fas fa-handshake me-2"></i> Database Vendor</button></li>
                        <li><button class="dropdown-item py-2" onclick="switchTab('v-pills-profile')"><i class="fas fa-id-card me-2"></i> Profil Bisnis</button></li>
                        <li><button class="dropdown-item py-2" onclick="switchTab('v-pills-laporan')"><i class="fas fa-chart-bar me-2"></i> Laporan Bulanan</button></li>
                        <li><button class="dropdown-item py-2" onclick="switchTab('v-pills-users')"><i class="fas fa-user-shield me-2"></i> Kelola Pengguna</button></li>
                    @endif
                    <li><hr class="dropdown-divider"></li>
                    <li><form action="/logout" method="POST">@csrf<button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i> Keluar</button></form></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 sidebar d-flex flex-column">

                <!-- LOGO AREA -->
                <a href="/dashboard" class="sidebar-logo-area">
                    @if(isset($settings['company_logo']))
                        <img src="{{ asset('img/'.$settings['company_logo']) }}" alt="Logo" style="width: auto; height: 40px; object-fit: contain; filter: brightness(0) invert(1); padding: 4px; border: none !important;">
                        <div class="brand-name">
                            {{ $settings['company_name'] ?? 'House of Salbai' }}
                            @if(Auth::user() && Auth::user()->isAdmin())
                                <span>Admin Dashboard</span>
                            @else
                                <span>Staff Dashboard</span>
                            @endif
                        </div>
                    @else
                        <span class="sidebar-logo-text">SALBAI<em>.</em></span>
                        <div class="brand-name ms-2">
                            @if(Auth::user() && Auth::user()->isAdmin())
                                <span>Admin Dashboard</span>
                            @else
                                <span>Staff Dashboard</span>
                            @endif
                        </div>
                    @endif
                </a>

                <!-- NAVIGATION -->
                <div class="flex-grow-1 overflow-auto py-2">
                    <p class="sidebar-nav-label">Menu Utama</p>
                    <ul class="nav nav-pills flex-column" id="v-pills-tab" role="tablist">
                        <li class="nav-item"><button class="nav-link active w-100" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button"><i class="fas fa-home me-2"></i>Dashboard Utama</button></li>
                        @if(Auth::user() && Auth::user()->isAdmin())
                            <li class="nav-item">
                                <button class="nav-link w-100 d-flex justify-content-between align-items-center" data-bs-toggle="pill" data-bs-target="#v-pills-approval" type="button">
                                    <span><i class="fas fa-clipboard-check me-2"></i>Persetujuan Konten</span>
                                    @php
                                        $pendingCount = $inventories->where('approval_status', 'pending')->count() + $albums->where('approval_status', 'pending')->count();
                                    @endphp
                                    @if($pendingCount > 0)
                                        <span class="badge bg-warning text-dark rounded-pill" style="font-size: 0.7rem; font-weight: 700; padding: 3px 6px;">{{ $pendingCount }}</span>
                                    @endif
                                </button>
                            </li>
                        @endif
                        <li class="nav-item"><button class="nav-link w-100" data-bs-toggle="pill" data-bs-target="#v-pills-inventaris" type="button"><i class="fas fa-boxes me-2"></i>Inventaris Alat</button></li>
                        <li class="nav-item"><button class="nav-link w-100" data-bs-toggle="pill" data-bs-target="#v-pills-album" type="button"><i class="fas fa-camera-retro me-2"></i>Album Event</button></li>
                        <li class="nav-item"><button class="nav-link w-100" data-bs-toggle="pill" data-bs-target="#v-pills-manifes" type="button"><i class="fas fa-file-invoice me-2"></i>Manifes Alat</button></li>
                        @if(Auth::user() && Auth::user()->isAdmin())
                            <li class="nav-item"><button class="nav-link w-100" data-bs-toggle="pill" data-bs-target="#v-pills-vendor" type="button"><i class="fas fa-handshake me-2"></i>Database Vendor</button></li>
                            <li class="nav-item"><button class="nav-link w-100" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button"><i class="fas fa-id-card me-2"></i>Profil Bisnis</button></li>
                            <li class="nav-item"><button class="nav-link w-100" data-bs-toggle="pill" data-bs-target="#v-pills-laporan" type="button"><i class="fas fa-chart-bar me-2"></i>Laporan Bulanan</button></li>
                            <li class="nav-item"><button class="nav-link w-100" data-bs-toggle="pill" data-bs-target="#v-pills-users" type="button"><i class="fas fa-user-shield me-2"></i>Kelola Pengguna</button></li>
                        @endif
                    </ul>
                    

                </div>

                <!-- FOOTER: LIHAT WEBSITE + LOGOUT -->
                <div class="sidebar-footer">
                    <a href="/" target="_blank" class="btn-view-site mb-1">
                        <i class="fas fa-arrow-up-right-from-square" style="font-size:0.8rem;"></i>
                        <span>Lihat Website Depan</span>
                    </a>
                    <form action="/logout" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Keluar dari Dashboard</span>
                        </button>
                    </form>
                </div>

            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-5">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4 shadow" role="alert" style="background: rgba(40,167,69,0.2); color: #fff; border: 1px solid rgba(40,167,69,0.3); backdrop-filter:blur(10px);">
                        <i class="fas fa-check-circle me-2 text-success"></i> {{ session('success') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-dismissible fade show mb-4 shadow" role="alert" style="background: rgba(234,179,8,0.15); color: #fff; border: 1px solid rgba(234,179,8,0.4); backdrop-filter:blur(10px);">
                        <i class="fas fa-exclamation-circle me-2" style="color:#EAB308;"></i>
                        <strong style="color:#EAB308;">Peringatan Stok:</strong>
                        <span class="d-block mt-1" style="font-size:0.9rem;">{{ session('warning') }}</span>
                        <small class="d-block mt-1 text-white-50">Manifes tetap berhasil disimpan. Silakan cek kembali jumlah alat yang tercatat.</small>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4 shadow" role="alert" style="background: rgba(220,53,69,0.2); color: #fff; border: 1px solid rgba(220,53,69,0.3); backdrop-filter:blur(10px);">
                        <i class="fas fa-times-circle me-2 text-danger"></i> <strong>Gagal:</strong> {{ session('error') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4 shadow" role="alert" style="background: rgba(220,53,69,0.2); color: #fff; border: 1px solid rgba(220,53,69,0.3); backdrop-filter:blur(10px);">
                        <i class="fas fa-exclamation-triangle me-2 text-danger"></i> <strong>Gagal:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(config('app.demo_mode', env('DEMO_MODE', false)))
                    <div class="alert border-0 shadow-lg mb-4 text-start animate-fade-up" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(6, 182, 212, 0.08)); border-left: 4px solid #10B981 !important; border-radius: 14px; backdrop-filter: blur(12px);">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(16, 185, 129, 0.2); display: flex; align-items: center; justify-content: center; color: #10B981; font-size: 1.2rem;">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div>
                                    <strong class="text-white d-block" style="font-size: 0.95rem;">Mode Live Demo Aktif (Portfolio Showcase)</strong>
                                    <span class="text-white-50" style="font-size: 0.8rem;">Seluruh fitur dashboard & input data dapat diuji coba. Fitur hapus data & modifikasi sensitif dilindungi demi menjaga integritas data bersama.</span>
                                </div>
                            </div>
                            <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #10B981; border: 1px solid rgba(16, 185, 129, 0.35); font-size: 0.72rem; padding: 6px 12px; border-radius: 20px;">
                                <i class="fas fa-lock me-1"></i> Proteksi Aktif
                            </span>
                        </div>
                    </div>
                @endif

                <div class="tab-content" id="v-pills-tabContent">
                    <!-- DASHBOARD UTAMA -->
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-up" id="dashboard-header">
                            <div>
                                <h2 class="fw-bold mb-1 font-outfit" style="font-size: 2.4rem; color: #ffffff; text-shadow: 0 0 40px rgba(16,185,129,0.3);">Panel <span style="color: #10B981;">Kontrol</span> {{ Auth::user() && Auth::user()->isAdmin() ? 'Admin' : 'Pegawai' }}</h2>
                                <p style="color: rgba(255,255,255,0.5); font-size: 0.88rem; margin: 0;">Selamat datang kembali &mdash; <span style="color: #10B981; font-weight: 600;">{{ now()->format('l, d M Y') }}</span></p>
                            </div>
                        </div>



                        <div class="row g-4 mb-4" id="dashboard-stats">
                            <!-- Total Aset -->
                            <div class="col-12 col-sm-6 col-xl-3 stats-card-container animate-fade-up delay-1" onclick="switchTab('v-pills-inventaris')">
                                <div class="card stats-card stats-card-emerald p-4 h-100 border-0 shadow-lg">
                                    <div class="d-flex align-items-start justify-content-between mb-3">
                                        <div class="stat-icon-wrap" style="background: rgba(16,185,129,0.15); color: #10B981;">
                                            <i class="fas fa-boxes"></i>
                                        </div>
                                        <span class="badge" style="background: rgba(16,185,129,0.1); color: #10B981; border: 1px solid rgba(16,185,129,0.2); font-size: 0.65rem; letter-spacing: 0.8px;">INVENTARIS</span>
                                    </div>
                                    <div class="stat-number delay-1">{{ $inventories->count() }}</div>
                                    <p class="mb-0 mt-2 text-white-50" style="font-size: 0.85rem; font-weight: 500; letter-spacing: 0.2px;">Item terdaftar sewa <span class="ms-2 text-success" style="font-weight: 600;"><i class="fas fa-warehouse fa-xs"></i> Aktif</span></p>
                                </div>
                            </div>

                            <!-- Album Event -->
                            <div class="col-12 col-sm-6 col-xl-3 stats-card-container animate-fade-up delay-2" onclick="switchTab('v-pills-album')">
                                <div class="card stats-card stats-card-purple p-4 h-100 border-0 shadow-lg">
                                    <div class="d-flex align-items-start justify-content-between mb-3">
                                        <div class="stat-icon-wrap" style="background: rgba(139,92,246,0.15); color: #8b5cf6;">
                                            <i class="fas fa-camera-retro"></i>
                                        </div>
                                        <span class="badge" style="background: rgba(139,92,246,0.1); color: #8b5cf6; border: 1px solid rgba(139,92,246,0.2); font-size: 0.65rem; letter-spacing: 0.8px;">GALERI</span>
                                    </div>
                                    <div class="stat-number delay-2" style="color: #8b5cf6;">{{ $albums->count() }}</div>
                                    <p class="mb-0 mt-2 text-white-50" style="font-size: 0.85rem; font-weight: 500; letter-spacing: 0.2px;">Album dokumentasi event</p>
                                </div>
                            </div>

                            <!-- Manifes Aktif -->
                            <div class="col-12 col-sm-6 col-xl-3 stats-card-container animate-fade-up delay-3" onclick="switchTab('v-pills-manifes')">
                                <div class="card stats-card stats-card-amber p-4 h-100 border-0 shadow-lg">
                                    <div class="d-flex align-items-start justify-content-between mb-3">
                                        <div class="stat-icon-wrap" style="background: rgba(245,158,11,0.15); color: #f59e0b;">
                                            <i class="fas fa-truck-loading"></i>
                                        </div>
                                        <span class="badge" style="background: rgba(245,158,11,0.1); color: #f59e0b; border: 1px solid rgba(245,158,11,0.2); font-size: 0.65rem; letter-spacing: 0.8px;">MANIFES</span>
                                    </div>
                                    <div class="stat-number delay-3" style="color: #f59e0b;">{{ $manifests->where('status', 'Alat Diluar')->count() }}</div>
                                    <p class="mb-0 mt-2 text-white-50" style="font-size: 0.85rem; font-weight: 500; letter-spacing: 0.2px;">Manifes berjalan diluar</p>
                                </div>
                            </div>

                            <!-- Vendor Mitra -->
                            <div class="col-12 col-sm-6 col-xl-3 stats-card-container animate-fade-up delay-4" onclick="switchTab('v-pills-vendor')">
                                <div class="card stats-card stats-card-cyan p-4 h-100 border-0 shadow-lg">
                                    <div class="d-flex align-items-start justify-content-between mb-3">
                                        <div class="stat-icon-wrap" style="background: rgba(6,182,212,0.15); color: #06b6d4;">
                                            <i class="fas fa-handshake"></i>
                                        </div>
                                        <span class="badge" style="background: rgba(6,182,212,0.1); color: #06b6d4; border: 1px solid rgba(6,182,212,0.2); font-size: 0.65rem; letter-spacing: 0.8px;">MITRA</span>
                                    </div>
                                    <div class="stat-number delay-4" style="color: #06b6d4;">{{ $vendors->count() }}</div>
                                    <p class="mb-0 mt-2 text-white-50" style="font-size: 0.85rem; font-weight: 500; letter-spacing: 0.2px;">Vendor mitra terjalin</p>
                                </div>
                            </div>
                        </div>

                        {{-- PEMBERITAHUAN KONTEN DITOLAK KHUSUS STAFF / PEGAWAI --}}
                        @if(Auth::user() && !Auth::user()->isAdmin())
                            @php
                                $rejectedInventories = $inventories->where('approval_status', 'rejected')->filter(fn($item) => !empty($item->catatan_penolakan));
                                $rejectedAlbums = $albums->where('approval_status', 'rejected')->filter(fn($item) => !empty($item->catatan_penolakan));
                                $totalRejected = $rejectedInventories->count() + $rejectedAlbums->count();
                            @endphp

                            @if($totalRejected > 0)
                                <div class="alert alert-danger border-0 shadow-lg p-4 mb-4 text-start animate-fade-up" 
                                     style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.25) !important; border-radius: 20px; backdrop-filter: blur(15px);">
                                    <div class="d-flex align-items-start gap-3">
                                        <div style="width: 46px; height: 46px; background: rgba(239, 68, 68, 0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #f87171; font-size: 1.2rem;">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-1">
                                                <h5 class="fw-bold mb-0 text-white font-outfit" style="font-size: 1.05rem;">
                                                    Catatan Penolakan Konten dari Admin
                                                    <span class="badge bg-danger ms-2" style="font-size: 0.75rem; vertical-align: middle;">{{ $totalRejected }} Item Perlu Diperbaiki</span>
                                                </h5>
                                                <small style="color: rgba(255,255,255,0.4); font-size: 0.75rem;"><i class="fas fa-info-circle me-1"></i>Anda dapat merubah data lalu mengunggah ulang, atau menghapus catatan ini</small>
                                            </div>
                                            <p class="text-white-50 mb-3" style="font-size: 0.85rem;">
                                                Berikut daftar aset atau album yang <strong class="text-danger">ditolak oleh Admin</strong>. Silakan perbaiki data lalu simpan untuk mengunggah ulang:
                                            </p>

                                            <div class="row g-3">
                                                @foreach($rejectedInventories as $rejAset)
                                                    <div class="col-12 col-md-6">
                                                        <div class="p-3 rounded-3 h-100 d-flex flex-column justify-content-between" style="background: rgba(0,0,0,0.35); border: 1px solid rgba(239,68,68,0.25);">
                                                            <div>
                                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                                    <span class="fw-bold text-white small"><i class="fas fa-box me-1 text-danger"></i> {{ $rejAset->nama_alat }}</span>
                                                                    <span class="badge bg-secondary" style="font-size:0.65rem;">Aset Inventaris</span>
                                                                </div>
                                                                <div class="text-danger small mt-1 mb-2" style="font-size:0.8rem; line-height: 1.4;">
                                                                    <strong><i class="fas fa-comment-dots me-1"></i> Alasan Admin:</strong> {{ $rejAset->catatan_penolakan ?: 'Tidak ada catatan spesifik.' }}
                                                                </div>
                                                            </div>
                                                            <div class="d-flex gap-2 mt-2 pt-2 border-top border-secondary-subtle">
                                                                <button type="button" class="btn btn-sm btn-outline-warning flex-fill" onclick="switchTab('v-pills-inventaris'); editAset(this);" data-aset="{{ json_encode($rejAset, JSON_HEX_QUOT|JSON_HEX_APOS) }}" style="font-size:0.75rem;">
                                                                    <i class="fas fa-edit me-1"></i> Perbaiki & Unggah Ulang
                                                                </button>
                                                                <form action="/admin/aset/dismiss-rejection/{{ $rejAset->id }}" method="POST" class="m-0">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" style="font-size:0.75rem;" title="Hapus catatan ini">
                                                                        <i class="fas fa-times me-1"></i> Hapus Catatan
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                @foreach($rejectedAlbums as $rejAlbum)
                                                    <div class="col-12 col-md-6">
                                                        <div class="p-3 rounded-3 h-100 d-flex flex-column justify-content-between" style="background: rgba(0,0,0,0.35); border: 1px solid rgba(239,68,68,0.25);">
                                                            <div>
                                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                                    <span class="fw-bold text-white small"><i class="fas fa-camera-retro me-1 text-danger"></i> {{ $rejAlbum->judul_event }}</span>
                                                                    <span class="badge bg-secondary" style="font-size:0.65rem;">Album Event</span>
                                                                </div>
                                                                <div class="text-danger small mt-1 mb-2" style="font-size:0.8rem; line-height: 1.4;">
                                                                    <strong><i class="fas fa-comment-dots me-1"></i> Alasan Admin:</strong> {{ $rejAlbum->catatan_penolakan ?: 'Tidak ada catatan spesifik.' }}
                                                                </div>
                                                            </div>
                                                            <div class="d-flex gap-2 mt-2 pt-2 border-top border-secondary-subtle">
                                                                <button type="button" class="btn btn-sm btn-outline-warning flex-fill" onclick="switchTab('v-pills-album'); editAlbum(this);" data-album="{{ json_encode($rejAlbum->load('galleries'), JSON_HEX_QUOT|JSON_HEX_APOS) }}" style="font-size:0.75rem;">
                                                                    <i class="fas fa-edit me-1"></i> Perbaiki & Unggah Ulang
                                                                </button>
                                                                <form action="/admin/album/dismiss-rejection/{{ $rejAlbum->id }}" method="POST" class="m-0">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" style="font-size:0.75rem;" title="Hapus catatan ini">
                                                                        <i class="fas fa-times me-1"></i> Hapus Catatan
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <div class="card p-5 border-0 shadow-lg position-relative overflow-hidden mb-4" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(5, 5, 5, 0.65) 100%); border: 1px solid rgba(16, 185, 129, 0.15) !important; border-radius: 20px; backdrop-filter: blur(20px);">
                            <div style="position: absolute; top: -100px; right: -100px; width: 300px; height: 300px; background: rgba(16, 185, 129, 0.08); filter: blur(80px); border-radius: 50%; pointer-events: none;"></div>
                            
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <h2 class="fw-bold mb-3 font-outfit text-white" style="font-size: 2rem; background: linear-gradient(135deg, #ffffff 0%, #10B981 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Selamat Datang di Portal {{ Auth::user() && Auth::user()->isAdmin() ? 'Admin' : 'Pegawai' }} House of Salbai</h2>
                                    <p class="text-white-50 mb-4" style="font-size: 1.05rem; line-height: 1.7; max-width: 95%;">
                                        Panel kontrol terintegrasi ini dirancang khusus untuk memudahkan Anda mengelola seluruh aspek operasional persewaan alat event, manifes loading barang, hingga dokumentasi galeri portofolio publik. Gunakan menu navigasi di sisi kiri atau akses cepat fitur utama di bawah ini:
                                    </p>
                                    <div class="hero-actions d-flex flex-wrap gap-3">
                                        <button class="btn btn-hos" onclick="switchTab('v-pills-inventaris')">
                                            <i class="fas fa-boxes me-2"></i> Kelola Inventaris
                                        </button>
                                        <button class="btn btn-outline-hos" onclick="switchTab('v-pills-manifes')">
                                            <i class="fas fa-file-invoice me-2"></i> Buat Surat Manifes
                                        </button>
                                        <button class="btn btn-outline-hos" onclick="switchTab('v-pills-album')">
                                            <i class="fas fa-camera-retro me-2"></i> Upload Galeri Event
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block text-center">
                                    @if(isset($settings['company_logo']))
                                        <img src="{{ asset('img/' . $settings['company_logo']) }}" style="max-height: 120px; width: auto; filter: drop-shadow(0 0 20px rgba(16, 185, 129, 0.35)) brightness(0) invert(1);" onerror="this.src='https://img.icons8.com/gradient/120/10B981/dashboard.png'; this.style.filter='none'">
                                    @else
                                        <i class="fas fa-laptop-code fa-5x text-hos" style="opacity: 0.6; filter: drop-shadow(0 0 15px rgba(16, 185, 129, 0.3));"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PERSETUJUAN KONTEN STAFF (ADMIN ONLY) -->
                    @if(Auth::user() && Auth::user()->isAdmin())
                        <div class="tab-pane fade" id="v-pills-approval" role="tabpanel">
                            <!-- Page Hero Header -->
                            <div class="page-hero-header animate-fade-up">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="hero-icon" style="background: rgba(16,185,129,0.12); color: #10B981;">
                                        <i class="fas fa-clipboard-check"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-gradient-green">Persetujuan Konten Staff</h4>
                                        <p>Tinjau, setujui, atau tolak aset inventaris dan album event baru yang diinput oleh Staff.</p>
                                    </div>
                                </div>
                            </div>

                            @php
                                $pendingInventories = $inventories->where('approval_status', 'pending');
                                $pendingAlbums = $albums->where('approval_status', 'pending');
                                $totalPending = $pendingInventories->count() + $pendingAlbums->count();
                            @endphp

                            @if($totalPending > 0)
                                <div class="row g-4 animate-fade-up">
                                    <!-- PENINJAUAN ASET INVENTARIS -->
                                    <div class="col-12">
                                        <div class="card bg-dark border-0 shadow-lg mb-4">
                                            <div class="card-header border-bottom border-secondary-subtle p-4 d-flex align-items-center justify-content-between">
                                                <h5 class="fw-bold mb-0 font-outfit text-white"><i class="fas fa-boxes me-2" style="color: var(--accent-green);"></i>Aset Menunggu Persetujuan</h5>
                                                <span class="badge bg-warning text-dark rounded-pill" style="font-weight: 700;">{{ $pendingInventories->count() }} Aset</span>
                                            </div>
                                            <div class="card-body p-4">
                                                @if($pendingInventories->count() > 0)
                                                    <div class="table-responsive">
                                                        <table class="table table-dark table-hover mb-0" style="vertical-align: middle; table-layout: fixed; width: 100%;">
                                                            <thead>
                                                                <tr style="color: #e2e8f0; font-family: 'Outfit'; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.8px; border-bottom: 2px solid rgba(16, 185, 129, 0.2);">
                                                                    <th style="width: 10%; text-align: center; padding: 14px 8px;">Visual</th>
                                                                    <th style="width: 30%; padding: 14px 8px;">Nama Alat</th>
                                                                    <th style="width: 20%; text-align: center; padding: 14px 8px;">Kategori</th>
                                                                    <th style="width: 15%; text-align: center; padding: 14px 8px;">Stok</th>
                                                                    <th style="width: 25%; text-align: center; padding: 14px 8px;">Persetujuan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($pendingInventories as $item)
                                                                    <tr>
                                                                        <td style="width: 10%; padding: 14px 8px; text-align: center; cursor: pointer;" onclick="tinjauAset(this)" data-aset="{{ json_encode($item, JSON_HEX_QUOT|JSON_HEX_APOS) }}" title="Klik untuk meninjau">
                                                                            @if($item->foto_alat && $item->foto_alat != '-')
                                                                                <img src="{{ asset($item->foto_alat) }}" style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(16, 185, 129, 0.25);">
                                                                            @else
                                                                                <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.05); border-radius: 8px; display: inline-flex; align-items:center; justify-content:center; border: 1px dashed rgba(255,255,255,0.1);"><i class="fas fa-box" style="color: rgba(255,255,255,0.6);"></i></div>
                                                                            @endif
                                                                        </td>
                                                                        <td style="width: 30%; padding: 14px 8px;">
                                                                            <span class="fw-bold text-white d-block" style="font-size: 0.95rem; cursor: pointer;" onclick="tinjauAset(this)" data-aset="{{ json_encode($item, JSON_HEX_QUOT|JSON_HEX_APOS) }}" title="Klik untuk meninjau">{{ $item->nama_alat }}</span>
                                                                            <span style="font-size: 0.75rem; color: #f1f5f9;">ID Referensi: #{{ $item->id }} <span class="mx-1" style="color: rgba(255,255,255,0.15);">|</span> <a href="javascript:void(0)" onclick="tinjauAset(this)" data-aset="{{ json_encode($item, JSON_HEX_QUOT|JSON_HEX_APOS) }}" class="text-info" style="text-decoration: none;"><i class="fas fa-eye me-1"></i>Tinjau Detail</a></span>
                                                                        </td>
                                                                        <td style="width: 20%; padding: 14px 8px; text-align: center;"><span class="badge" style="background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.85); border: 1px solid rgba(255,255,255,0.15); font-size: 0.75rem; padding: 6px 12px; font-weight: 500;">{{ $item->kategori }}</span></td>
                                                                        <td style="width: 15%; padding: 14px 8px; text-align: center;"><span class="badge bg-success" style="font-size: 0.8rem; padding: 6px 12px; font-weight: 700;">{{ $item->stok_tersedia }} Unit</span></td>
                                                                        <td style="width: 25%; padding: 14px 8px;">
                                                                            <div class="d-flex gap-2 justify-content-center">
                                                                                <form action="/admin/aset/approve/{{ $item->id }}" method="POST" class="m-0 flex-fill">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn btn-sm btn-success w-100 py-2 px-3 text-white fw-bold d-flex align-items-center justify-content-center gap-1" style="font-size: 0.8rem; border-radius:6px; height: 36px;"><i class="fas fa-check"></i> Setujui</button>
                                                                                </form>
                                                                                <button type="button" class="btn btn-sm btn-danger flex-fill py-2 px-3 text-white fw-bold d-flex align-items-center justify-content-center gap-1" style="font-size: 0.8rem; border-radius:6px; height: 36px;" onclick="bukaModalTolak('/admin/aset/reject/{{ $item->id }}', 'aset')"><i class="fas fa-times"></i> Tolak</button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <div class="text-center py-5 text-muted">
                                                        <i class="fas fa-check-circle fa-2x mb-3 text-success"></i>
                                                        <p class="mb-0">Tidak ada aset baru yang menunggu persetujuan.</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PENINJAUAN ALBUM EVENT -->
                                    <div class="col-12 animate-fade-up">
                                        <div class="card bg-dark border-0 shadow-lg">
                                            <div class="card-header border-bottom border-secondary-subtle p-4 d-flex align-items-center justify-content-between">
                                                <h5 class="fw-bold mb-0 font-outfit text-white"><i class="fas fa-camera-retro me-2" style="color: var(--accent-green);"></i>Album Menunggu Persetujuan</h5>
                                                <span class="badge bg-warning text-dark rounded-pill" style="font-weight: 700;">{{ $pendingAlbums->count() }} Album</span>
                                            </div>
                                            <div class="card-body p-4">
                                                @if($pendingAlbums->count() > 0)
                                                    <div class="table-responsive">
                                                        <table class="table table-dark table-hover mb-0" style="vertical-align: middle; table-layout: fixed; width: 100%;">
                                                            <thead>
                                                                <tr style="color: #e2e8f0; font-family: 'Outfit'; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.8px; border-bottom: 2px solid rgba(16, 185, 129, 0.2);">
                                                                    <th style="width: 10%; text-align: center; padding: 14px 8px;">Cover</th>
                                                                    <th style="width: 30%; padding: 14px 8px;">Judul Event</th>
                                                                    <th style="width: 35%; padding: 14px 8px;">Deskripsi</th>
                                                                    <th style="width: 25%; text-align: center; padding: 14px 8px;">Persetujuan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($pendingAlbums as $item)
                                                                    @php
                                                                        $albumCover = null;
                                                                        if (!empty($item->cover_album) && $item->cover_album !== '-') {
                                                                            $albumCover = asset($item->cover_album);
                                                                        } else {
                                                                            $firstImg = $item->galleries->where('file_type','image')->first();
                                                                            $albumCover = $firstImg ? asset($firstImg->file_path) : null;
                                                                        }
                                                                    @endphp
                                                                    <tr>
                                                                        <td style="width: 10%; padding: 14px 8px; text-align: center; cursor: pointer;" onclick="tinjauAlbum(this)" data-album="{{ json_encode($item->load('galleries'), JSON_HEX_QUOT|JSON_HEX_APOS) }}" title="Klik untuk meninjau">
                                                                            @if($albumCover)
                                                                                <img src="{{ $albumCover }}" style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(16, 185, 129, 0.25);">
                                                                            @else
                                                                                <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.05); border-radius: 8px; display: inline-flex; align-items:center; justify-content:center; border: 1px dashed rgba(255,255,255,0.1);"><i class="fas fa-image small" style="color: rgba(255,255,255,0.4);"></i></div>
                                                                            @endif
                                                                        </td>
                                                                        <td style="width: 30%; padding: 14px 8px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                                            <span class="fw-bold text-white d-block" style="font-size: 0.95rem; cursor: pointer;" onclick="tinjauAlbum(this)" data-album="{{ json_encode($item->load('galleries'), JSON_HEX_QUOT|JSON_HEX_APOS) }}" title="Klik untuk meninjau">{{ $item->judul_event }}</span>
                                                                            <span style="font-size: 0.75rem; color: rgba(255,255,255,0.65);"><i class="far fa-calendar-alt me-1"></i>{{ date('d M Y', strtotime($item->tanggal_event)) }} <span class="mx-1" style="color: rgba(255,255,255,0.15);">|</span> <a href="javascript:void(0)" onclick="tinjauAlbum(this)" data-album="{{ json_encode($item->load('galleries'), JSON_HEX_QUOT|JSON_HEX_APOS) }}" class="text-info" style="text-decoration: none;"><i class="fas fa-eye me-1"></i>Tinjau Detail</a></span>
                                                                        </td>
                                                                        <td style="width: 35%; padding: 14px 8px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><span style="font-size: 0.85rem; line-height: 1.5; color: rgba(255, 255, 255, 0.8);" title="{{ $item->deskripsi_event }}">{{ Str::limit($item->deskripsi_event, 100) ?: 'Tanpa deskripsi.' }}</span></td>
                                                                        <td style="width: 25%; padding: 14px 8px;">
                                                                            <div class="d-flex gap-2 justify-content-center">
                                                                                <form action="/admin/album/approve/{{ $item->id }}" method="POST" class="m-0 flex-fill">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn btn-sm btn-success w-100 py-2 px-3 text-white fw-bold d-flex align-items-center justify-content-center gap-1" style="font-size: 0.8rem; border-radius:6px; height: 36px;"><i class="fas fa-check"></i> Setujui</button>
                                                                                </form>
                                                                                <button type="button" class="btn btn-sm btn-danger flex-fill py-2 px-3 text-white fw-bold d-flex align-items-center justify-content-center gap-1" style="font-size: 0.8rem; border-radius:6px; height: 36px;" onclick="bukaModalTolak('/admin/album/reject/{{ $item->id }}', 'album')"><i class="fas fa-times"></i> Tolak</button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <div class="text-center py-5 text-muted">
                                                        <i class="fas fa-check-circle fa-2x mb-3 text-success"></i>
                                                        <p class="mb-0">Tidak ada album baru yang menunggu persetujuan.</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- ALL CONTENT CLEAN / EMPTY STATE -->
                                <div class="card border-0 shadow-lg p-5 text-center animate-fade-up" style="background: rgba(20, 20, 25, 0.4); border-radius: 20px;">
                                    <div class="mx-auto bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px; font-size: 2.5rem; background: rgba(16,185,129,0.1) !important;">
                                        <i class="fas fa-check-double text-success"></i>
                                    </div>
                                    <h4 class="fw-bold font-outfit text-white mb-2">Semua Konten Telah Bersih</h4>
                                    <p class="text-white-50 mx-auto mb-0" style="max-width: 500px;">
                                        Tidak ada pengajuan aset inventaris atau album event baru dari Staff yang menunggu peninjauan Anda saat ini. Semua konten operasional berjalan dengan tertib.
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- INVENTARIS ALAT -->
                    <div class="tab-pane fade" id="v-pills-inventaris" role="tabpanel">
                        <!-- Page Hero Header -->
                        <div class="page-hero-header animate-fade-up">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="hero-icon" style="background: rgba(16,185,129,0.12); color: #10B981;">
                                        <i class="fas fa-boxes"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-gradient-green">Manajemen Aset Produksi</h4>
                                        <p>Kelola inventaris alat event, stok, dan kondisi peralatan operasional.</p>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-sm-row gap-2">
                                    <div class="position-relative">
                                        <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size:0.8rem;"></i>
                                        <input type="text" id="inventarisSearch" class="form-control form-control-sm ps-5" placeholder="Cari alat..." style="min-width: 180px; background: rgba(255,255,255,0.06); border: 1px solid rgba(16,185,129,0.25); color: white; border-radius:10px;">
                                    </div>
                                    <div class="position-relative">
                                        <select id="inventarisKategoriFilter" class="form-select form-select-sm" style="min-width: 150px; background: rgba(255,255,255,0.06) url('data:image/svg+xml,%3csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 16 16%22%3e%3cpath fill=%22none%22 stroke=%22%2310B981%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22m2 5 6 6 6-6%22/%3e%3c/svg%3e') no-repeat right .75rem center; background-size: 16px 12px; border: 1px solid rgba(16,185,129,0.25); color: white; padding-right: 2.25rem; border-radius:10px;">
                                            <option value="all" style="background: #111; color: white;">Semua Kategori</option>
                                            @foreach($inventories->pluck('kategori')->unique() as $kat)
                                                <option value="{{ $kat }}" style="background: #111; color: white;">{{ $kat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button class="btn btn-hos" data-bs-toggle="modal" data-bs-target="#modalTambahAset"><i class="fas fa-plus me-1"></i> Tambah Aset</button>
                                </div>
                            </div>
                        </div>
                        <div class="d-none d-md-block">
                            <div class="card bg-dark border-0 shadow-lg"><div class="card-body p-0"><div class="table-responsive"><table class="table table-dark table-hover mb-0" id="tableInventaris">
                                <thead><tr style="color: #aaa;"><th class="px-4">Visual</th><th>Nama Alat</th><th>Kategori</th><th>Stok</th><th>Kondisi</th><th>Status</th><th class="text-center">Aksi</th></tr></thead>
                                <tbody>
                                    @foreach($inventories as $item)
                                    <tr>
                                        <td class="px-4">
                                            @if($item->foto_alat && $item->foto_alat != '-')
                                                <img src="{{ asset($item->foto_alat) }}" style="width: 45px; height: 45px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(16, 185, 129, 0.2);">
                                            @else
                                                <div style="width: 45px; height: 45px; background: rgba(255,255,255,0.05); border-radius: 8px; display: flex; align-items:center; justify-content:center;"><i class="fas fa-box text-muted small"></i></div>
                                            @endif
                                        </td>
                                        <td>{{ $item->nama_alat }}</td>
                                        <td>{{ $item->kategori }}</td>
                                        <td><span class="badge badge-hos">{{ $item->stok_tersedia }} Unit</span></td>
                                        <td>
                                            @php
                                                $kondisiColor = match($item->kondisi_alat ?? 'Baik') {
                                                    'Baik' => 'bg-success',
                                                    'Perlu Servis' => 'bg-warning text-dark',
                                                    'Rusak' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $kondisiColor }}" style="font-size:0.7rem;">{{ $item->kondisi_alat ?? 'Baik' }}</span>
                                        </td>
                                        <td>
                                            @if(($item->approval_status ?? 'approved') == 'approved')
                                                <span class="badge bg-success" style="font-size:0.7rem;"><i class="fas fa-check-circle me-1"></i>Disetujui</span>
                                            @elseif($item->approval_status == 'pending')
                                                <span class="badge bg-warning text-dark" style="font-size:0.7rem;"><i class="fas fa-clock me-1"></i>Menunggu</span>
                                            @else
                                                <span class="badge bg-danger" style="font-size:0.7rem;" title="{{ $item->catatan_penolakan ? 'Alasan: ' . $item->catatan_penolakan : 'Ditolak' }}"><i class="fas fa-times-circle me-1"></i>Ditolak</span>
                                                @if(!empty($item->catatan_penolakan))
                                                    <div class="text-danger mt-1" style="font-size:0.72rem;"><i class="fas fa-info-circle me-1"></i>Alasan: {{ $item->catatan_penolakan }}</div>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                @if(Auth::user() && Auth::user()->isAdmin())
                                                    @if(($item->approval_status ?? 'approved') == 'pending')
                                                        <form action="/admin/aset/approve/{{ $item->id }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Setujui"><i class="fas fa-check"></i></button>
                                                        </form>
                                                        <button type="button" class="btn btn-sm btn-outline-warning" onclick="bukaModalTolak('/admin/aset/reject/{{ $item->id }}', 'aset')" title="Tolak"><i class="fas fa-times"></i></button>
                                                    @endif
                                                    <button class="btn btn-sm btn-outline-warning" onclick="editAset(this)" data-aset="{{ json_encode($item, JSON_HEX_QUOT|JSON_HEX_APOS) }}" title="Edit Aset"><i class="fas fa-edit"></i></button>
                                                    <form action="/admin/aset/delete/{{ $item->id }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus aset ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Aset"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                @else
                                                    <span class="text-muted small">—</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table></div></div></div>
                        </div>

                        <div class="d-md-none">
                            @forelse($inventories as $item)
                            @php
                                $kondisiColor = match($item->kondisi_alat ?? 'Baik') {
                                    'Baik' => 'bg-success',
                                    'Perlu Servis' => 'bg-warning text-dark',
                                    'Rusak' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <div class="card mobile-vendor-card p-3 mb-3">
                                <div class="d-flex align-items-start justify-content-between gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        @if($item->foto_alat && $item->foto_alat != '-')
                                            <img src="{{ asset($item->foto_alat) }}" style="width: 48px; height: 48px; object-fit: cover; border-radius: 10px; border: 1px solid rgba(16,185,129,0.2);">
                                        @else
                                            <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.05); border-radius:10px; display:flex; align-items:center; justify-content:center;"><i class="fas fa-box text-muted"></i></div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-white">{{ $item->nama_alat }}</div>
                                            <div class="small text-white-50">{{ $item->kategori }}</div>
                                        </div>
                                    </div>
                                    <span class="badge badge-hos">{{ $item->stok_tersedia }} Unit</span>
                                </div>
                                <div class="d-flex flex-wrap gap-2 mt-3">
                                    <span class="badge {{ $kondisiColor }}" style="font-size:0.7rem;">{{ $item->kondisi_alat ?? 'Baik' }}</span>
                                    @if(($item->approval_status ?? 'approved') == 'approved')
                                        <span class="badge bg-success" style="font-size:0.7rem;"><i class="fas fa-check-circle me-1"></i>Disetujui</span>
                                    @elseif($item->approval_status == 'pending')
                                        <span class="badge bg-warning text-dark" style="font-size:0.7rem;"><i class="fas fa-clock me-1"></i>Menunggu</span>
                                    @else
                                        <span class="badge bg-danger" style="font-size:0.7rem;"><i class="fas fa-times-circle me-1"></i>Ditolak</span>
                                    @endif
                                </div>
                                @if(!empty($item->catatan_penolakan) && $item->approval_status == 'rejected')
                                    <div class="text-danger mt-1" style="font-size:0.75rem;"><i class="fas fa-info-circle me-1"></i>Alasan Penolakan: {{ $item->catatan_penolakan }}</div>
                                @endif
                                @if(Auth::user() && Auth::user()->isAdmin())
                                <div class="d-flex flex-wrap gap-2 mt-3">
                                    @if(($item->approval_status ?? 'approved') == 'pending')
                                        <form action="/admin/aset/approve/{{ $item->id }}" method="POST" class="flex-fill">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success w-100"><i class="fas fa-check me-1"></i>Setujui</button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-outline-warning flex-fill" onclick="bukaModalTolak('/admin/aset/reject/{{ $item->id }}', 'aset')"><i class="fas fa-times me-1"></i>Tolak</button>
                                    @endif
                                    <button class="btn btn-sm btn-outline-warning flex-fill" onclick="editAset(this)" data-aset="{{ json_encode($item, JSON_HEX_QUOT|JSON_HEX_APOS) }}"><i class="fas fa-edit me-1"></i>Edit</button>
                                    <form action="/admin/aset/delete/{{ $item->id }}" method="POST" class="flex-fill" onsubmit="return confirm('Hapus aset ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100"><i class="fas fa-trash me-1"></i>Hapus</button>
                                    </form>
                                </div>
                                @endif
                            </div>
                            @empty
                            <div class="text-center py-5" style="color: rgba(255,255,255,0.35);">
                                <i class="fas fa-box-open fa-2x mb-2 d-block"></i>
                                Belum ada data inventaris.
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- ALBUM -->
                    <div class="tab-pane fade" id="v-pills-album">
                        <!-- Page Hero Header -->
                        <div class="page-hero-header animate-fade-up">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="hero-icon" style="background: rgba(139,92,246,0.12); color: #8b5cf6;">
                                        <i class="fas fa-camera-retro"></i>
                                    </div>
                                    <div>
                                        <h4 style="background: linear-gradient(135deg,#ffffff 0%,#8b5cf6 70%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">Galeri Album Dokumentasi</h4>
                                        <p>Kelola foto dan video dokumentasi event yang ditampilkan di website publik.</p>
                                    </div>
                                </div>
                                <button class="btn btn-hos" data-bs-toggle="modal" data-bs-target="#modalTambahAlbum"><i class="fas fa-upload me-1"></i> Upload Album</button>
                            </div>
                        </div>

                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            @foreach($albums as $album)
                            @php
                                // Tentukan cover: cover_album diprioritaskan, fallback ke galeri pertama
                                $dashCover = null;
                                if (!empty($album->cover_album) && $album->cover_album !== '-') {
                                    $dashCover = asset($album->cover_album);
                                } else {
                                    $firstImg = $album->galleries->where('file_type','image')->first();
                                    $dashCover = $firstImg ? asset($firstImg->file_path) : null;
                                }
                                $tglMulai   = date('d M Y', strtotime($album->tanggal_event));
                                $tglSelesai = $album->tanggal_selesai ? date('d M Y', strtotime($album->tanggal_selesai)) : null;
                                $totalFiles = $album->galleries->count();
                                $totalImg   = $album->galleries->where('file_type','image')->count();
                                $totalVid   = $album->galleries->where('file_type','video')->count();
                            @endphp
                            <div class="col animate-fade-up">
                                <div class="album-card h-100">
                                    <!-- Album Cover -->
                                    <div class="album-cover">
                                        @if($dashCover)
                                            <img src="{{ $dashCover }}" alt="{{ $album->judul_event }}" onerror="this.style.display='none'">
                                            <div class="album-cover-overlay"></div>
                                        @else
                                            <div class="album-cover-placeholder">
                                                <i class="fas fa-images fa-2x" style="opacity:0.4;"></i>
                                                <span style="font-size:0.75rem; opacity:0.4;">Belum ada gambar</span>
                                            </div>
                                        @endif
                                        @if($tglSelesai)
                                            <span class="album-badge"><i class="fas fa-calendar-week me-1"></i>Multi-hari</span>
                                        @endif
                                    </div>
                                    <!-- Album Body -->
                                    <div class="album-card-body">
                                        <div class="album-title">{{ $album->judul_event }}</div>
                                        <div class="album-meta"><i class="far fa-calendar-alt"></i> {{ $tglMulai }}{{ $tglSelesai ? ' — ' . $tglSelesai : '' }}</div>
                                        <div class="album-meta">
                                            <i class="fas fa-photo-video"></i>
                                            {{ $totalFiles }} file
                                            @if($totalImg > 0)<span class="ms-2"><i class="fas fa-image" style="opacity:0.6;"></i> {{ $totalImg }}</span>@endif
                                            @if($totalVid > 0)<span class="ms-1"><i class="fas fa-film" style="opacity:0.6;"></i> {{ $totalVid }}</span>@endif
                                        </div>
                                        <!-- Approval status for Album -->
                                        <div class="mb-3 mt-2">
                                            @if(($album->approval_status ?? 'approved') == 'approved')
                                                <span class="badge bg-success" style="font-size:0.7rem;"><i class="fas fa-check-circle me-1"></i>Disetujui</span>
                                            @elseif($album->approval_status == 'pending')
                                                <span class="badge bg-warning text-dark" style="font-size:0.7rem;"><i class="fas fa-clock me-1"></i>Menunggu</span>
                                            @else
                                                <span class="badge bg-danger" style="font-size:0.7rem;"><i class="fas fa-times-circle me-1"></i>Ditolak</span>
                                                @if(!empty($album->catatan_penolakan))
                                                    <div class="text-danger mt-1" style="font-size:0.72rem;"><i class="fas fa-info-circle me-1"></i>Alasan: {{ $album->catatan_penolakan }}</div>
                                                @endif
                                            @endif
                                        </div>

                                        <div class="album-actions d-flex gap-2 flex-wrap align-items-center">
                                            <button class="btn-open" onclick="initGaleriAdmin(this)" data-judul="{{ $album->judul_event }}" data-galleries="{{ json_encode($album->galleries, JSON_HEX_QUOT|JSON_HEX_APOS) }}"><i class="fas fa-eye me-1"></i> Buka Galeri</button>
                                            @if(Auth::user() && Auth::user()->isAdmin())
                                                @if(($album->approval_status ?? 'approved') == 'pending')
                                                    <!-- Approve/Reject buttons -->
                                                    <form action="/admin/album/approve/{{ $album->id }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success text-dark" style="border-radius:10px; font-weight: 700; font-size:0.75rem; padding: 6px 12px;" title="Setujui Album">Setujui</button>
                                                    </form>
                                                    <button type="button" class="btn btn-sm btn-warning text-dark fw-bold" style="border-radius:10px; font-size:0.75rem; padding: 6px 12px;" onclick="bukaModalTolak('/admin/album/reject/{{ $album->id }}', 'album')" title="Tolak Album">Tolak</button>
                                                @endif
                                                <button class="btn btn-sm" onclick="editAlbum(this)" data-album="{{ json_encode($album->load('galleries'), JSON_HEX_QUOT|JSON_HEX_APOS) }}" style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.25); color:#f59e0b; border-radius:10px; width:38px; height:38px; display:inline-flex; align-items:center; justify-content:center;" title="Edit Album"><i class="fas fa-edit"></i></button>
                                                <form action="/admin/album/delete/{{ $album->id }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus album & semua file fisik?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25); color:#ef4444; border-radius:10px; width:38px; height:38px; display:inline-flex; align-items:center; justify-content:center;" title="Hapus"><i class="fas fa-trash"></i></button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>


                    <!-- MANIFES -->
                    <div class="tab-pane fade" id="v-pills-manifes">
                        <!-- Page Hero Header -->
                        <div class="page-hero-header animate-fade-up">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="hero-icon" style="background: rgba(245,158,11,0.12); color: #f59e0b;">
                                        <i class="fas fa-file-invoice"></i>
                                    </div>
                                    <div>
                                        <h4 style="background: linear-gradient(135deg,#ffffff 0%,#f59e0b 70%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">Daftar Manifes Loading</h4>
                                        <p>Kelola surat jalan keluar-masuk alat gudang dan cetak dokumen PDF.</p>
                                    </div>
                                </div>
                                <button class="btn btn-hos" data-bs-toggle="modal" data-bs-target="#modalTambahManifes"><i class="fas fa-plus me-1"></i> Buat Manifes</button>
                            </div>
                        </div>

                        {{-- DESKTOP: Table view --}}
                        <div class="d-none d-md-block">
                            <div class="card bg-dark border-0 shadow-lg"><div class="card-body p-0"><div class="table-responsive"><table class="table table-dark table-hover mb-0">
                                <thead><tr style="color: #aaa;"><th class="px-4">No. Manifes</th><th>Klien</th><th>Crew Chief</th><th>Status</th><th class="text-center">Aksi</th></tr></thead>
                                <tbody>
                                    @foreach($manifests as $m)
                                    <tr>
                                        <td class="px-4 text-hos fw-bold">{{ $m->nomor_manifes }}</td>
                                        <td>{{ $m->klien_event }}</td>
                                        <td>{{ $m->crew_chief }}</td>
                                        <td>
                                            @if($m->status == 'Alat Diluar')
                                                <span class="badge bg-warning text-dark"><i class="fas fa-truck-loading me-1"></i> Alat Diluar</span>
                                            @else
                                                <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Sudah Kembali</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-info" onclick="window.open('/admin/manifes/print/{{ $m->id }}', '_blank')" title="Cetak PDF"><i class="fas fa-file-pdf"></i></button>
                                                @if(Auth::user() && Auth::user()->isAdmin())
                                                    @if($m->status == 'Alat Diluar')
                                                    <button class="btn btn-sm btn-outline-warning" onclick="editManifes(this)" data-manifes="{{ json_encode($m, JSON_HEX_QUOT|JSON_HEX_APOS) }}" title="Edit"><i class="fas fa-edit"></i></button>
                                                    <form action="/admin/manifes/return/{{ $m->id }}" method="POST" class="d-inline" onsubmit="return confirm('Konfirmasi barang sudah kembali ke gudang?');">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success text-white" title="Unloading"><i class="fas fa-undo-alt"></i> Kembali</button>
                                                    </form>
                                                    @endif
                                                    <form action="/admin/manifes/delete/{{ $m->id }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus manifes?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table></div></div></div>
                        </div>

                        {{-- MOBILE: Card view --}}
                        <div class="d-md-none">
                            @forelse($manifests as $m)
                            <div class="card mb-3" style="background: rgba(20,20,25,0.7); border: 1px solid rgba(255,255,255,0.07); border-radius: 16px; backdrop-filter: blur(12px);">
                                <div class="card-body p-3">
                                    {{-- Header --}}
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="fw-bold text-hos" style="font-family:'Outfit'; font-size:0.9rem;">{{ $m->nomor_manifes }}</span>
                                        @if($m->status == 'Alat Diluar')
                                            <span class="badge bg-warning text-dark"><i class="fas fa-truck-loading me-1"></i> Alat Diluar</span>
                                        @else
                                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Sudah Kembali</span>
                                        @endif
                                    </div>
                                    {{-- Info --}}
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <div style="font-size:0.7rem; color:rgba(255,255,255,0.4); text-transform:uppercase; letter-spacing:0.8px;">Klien</div>
                                            <div style="font-size:0.88rem; color:#fff;">{{ $m->klien_event }}</div>
                                        </div>
                                        <div class="col-6">
                                            <div style="font-size:0.7rem; color:rgba(255,255,255,0.4); text-transform:uppercase; letter-spacing:0.8px;">Crew Chief</div>
                                            <div style="font-size:0.88rem; color:#fff;">{{ $m->crew_chief }}</div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <button class="btn btn-sm flex-fill" style="background:rgba(6,182,212,0.1); border:1px solid rgba(6,182,212,0.3); color:#06b6d4; border-radius:10px;" onclick="window.open('/admin/manifes/print/{{ $m->id }}', '_blank')"><i class="fas fa-file-pdf me-1"></i> PDF</button>
                                        @if(Auth::user() && Auth::user()->isAdmin())
                                            @if($m->status == 'Alat Diluar')
                                            <button class="btn btn-sm flex-fill" style="background:rgba(245,158,11,0.1); border:1px solid rgba(245,158,11,0.3); color:#f59e0b; border-radius:10px;" onclick="editManifes(this)" data-manifes="{{ json_encode($m, JSON_HEX_QUOT|JSON_HEX_APOS) }}"><i class="fas fa-edit me-1"></i> Edit</button>
                                            <form action="/admin/manifes/return/{{ $m->id }}" method="POST" class="d-inline flex-fill" onsubmit="return confirm('Konfirmasi barang sudah kembali?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm w-100" style="background:rgba(16,185,129,0.15); border:1px solid rgba(16,185,129,0.35); color:#10B981; border-radius:10px;"><i class="fas fa-undo-alt me-1"></i> Kembali</button>
                                            </form>
                                            @endif
                                            <form action="/admin/manifes/delete/{{ $m->id }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus manifes?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm" style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); color:#ef4444; border-radius:10px; width:40px;"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-5" style="color: rgba(255,255,255,0.3);"><i class="fas fa-file-invoice fa-2x mb-2 d-block"></i> Belum ada manifes</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- VENDOR -->
                    <div class="tab-pane fade" id="v-pills-vendor">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                            <h4 style="color:#10B981;" class="mb-0">Database Vendor Mitra</h4>
                            <button class="btn btn-hos" data-bs-toggle="modal" data-bs-target="#modalTambahVendor">+ Tambah Vendor</button>
                        </div>

                        <div class="d-none d-md-block">
                            <div class="card bg-dark border-0 shadow-lg"><div class="card-body p-0"><div class="table-responsive"><table class="table table-dark table-hover mb-0">
                                <thead><tr style="color: #aaa;"><th class="px-4">Nama Vendor</th><th>Layanan</th><th>Kontak</th><th class="text-center">Aksi</th></tr></thead>
                                <tbody>
                                    @foreach($vendors as $v)
                                    @php
                                        $cleanWa = preg_replace('/[^0-9]/', '', $v->nomor_telepon);
                                        if (str_starts_with($cleanWa, '0')) {
                                            $cleanWa = '62' . substr($cleanWa, 1);
                                        }
                                    @endphp
                                    <tr>
                                        <td class="px-4">{{ $v->nama_vendor }}</td>
                                        <td>{{ $v->kategori_layanan }}</td>
                                        <td>
                                            <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="text-hos text-decoration-none" style="color: var(--accent-green) !important;">
                                                <i class="fab fa-whatsapp me-1 text-success"></i> {{ $v->nomor_telepon }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <form action="/admin/vendor/delete/{{ $v->id }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data vendor?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table></div></div></div>
                        </div>

                        <div class="d-md-none">
                            @forelse($vendors as $v)
                            @php
                                $cleanWa = preg_replace('/[^0-9]/', '', $v->nomor_telepon);
                                if (str_starts_with($cleanWa, '0')) {
                                    $cleanWa = '62' . substr($cleanWa, 1);
                                }
                            @endphp
                            <div class="card mobile-vendor-card p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <div>
                                        <div class="fw-bold text-hos" style="font-size: 0.95rem;">{{ $v->nama_vendor }}</div>
                                        <div class="small text-white-50">{{ $v->kategori_layanan }}</div>
                                    </div>
                                    <form action="/admin/vendor/delete/{{ $v->id }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data vendor?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                                <div class="mt-3">
                                    <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="text-hos text-decoration-none d-flex align-items-center gap-2" style="color: var(--accent-green) !important;">
                                        <i class="fab fa-whatsapp text-success"></i>
                                        <span class="small">{{ $v->nomor_telepon }}</span>
                                    </a>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-5" style="color: rgba(255,255,255,0.35);">
                                <i class="fas fa-handshake fa-2x mb-2 d-block"></i>
                                Belum ada data vendor.
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- PROFILE -->                    <div class="tab-pane fade" id="v-pills-profile">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                            <div>
                                <h4 style="color:#10B981;" class="mb-1"><i class="fas fa-sliders-h me-2"></i>Master Kontrol Konten Website</h4>
                                <p class="text-white-50 small mb-0">Ubah visual, teks, kontak, dan tautan media sosial secara real-time.</p>
                            </div>
                        </div>

                        <form action="/admin/setting" method="POST" enctype="multipart/form-data" class="m-0">
                            @csrf
                            <div class="row g-4">
                                <div class="col-lg-9">
                                    
                                    <!-- BAGIAN 1: INFORMASI DASAR -->
                                    <div class="cms-section-card">
                                        <div class="cms-header-title">
                                            <i class="fas fa-info-circle"></i>
                                            <span>1. Informasi Kontak Bisnis</span>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-6 cms-input-group">
                                                <label>Nama Bisnis / Brand</label>
                                                <input type="text" name="company_name" class="form-control" value="{{ $settings['company_name'] ?? '' }}" placeholder="Nama bisnis Anda">
                                            </div>
                                            <div class="col-md-6 cms-input-group">
                                                <label>WhatsApp Utama (6281xxx)</label>
                                                <input type="text" name="whatsapp" class="form-control" value="{{ $settings['whatsapp'] ?? '' }}" placeholder="Contoh: 628123456789">
                                            </div>
                                            <div class="col-md-6 cms-input-group">
                                                <label>Email Admin</label>
                                                <input type="email" name="email" class="form-control" value="{{ $settings['email'] ?? '' }}" placeholder="admin@domain.com">
                                            </div>
                                            <div class="col-md-6 cms-input-group">
                                                <label>Nomor Telepon Display</label>
                                                <input type="text" name="phone" class="form-control" value="{{ $settings['phone'] ?? '' }}" placeholder="+62 812-3456-789">
                                            </div>
                                            <div class="col-12 cms-input-group mb-0">
                                                <label>Alamat Kantor / Gudang</label>
                                                <input type="text" name="address" class="form-control" value="{{ $settings['address'] ?? '' }}" placeholder="Alamat lengkap operasional bisnis">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- BAGIAN 2: VISUAL HERO (HALAMAN DEPAN) -->
                                    <div class="cms-section-card">
                                        <div class="cms-header-title">
                                            <i class="fas fa-magic"></i>
                                            <span>2. Visual & Teks Kalimat Pembuka (Hero)</span>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-4 cms-input-group">
                                                <label>Badge Teks Atas</label>
                                                <input type="text" name="hero_badge_text" class="form-control" placeholder="ex: THE MASTER OF EVENT" value="{{ $settings['hero_badge_text'] ?? '' }}">
                                            </div>
                                            <div class="col-md-4 cms-input-group">
                                                <label>Kata Awal (ex: Digitalisasi)</label>
                                                <input type="text" name="hero_prefix" class="form-control" value="{{ $settings['hero_prefix'] ?? 'Digitalisasi' }}">
                                            </div>
                                            <div class="col-md-4 cms-input-group">
                                                <label>Kalimat Utama (Warna Hijau)</label>
                                                <input type="text" name="hero_title" class="form-control" value="{{ $settings['hero_title'] ?? '' }}" placeholder="Judul utama landing page">
                                            </div>
                                            <div class="col-12 cms-input-group">
                                                <label>Paragraf Sambutan (Subtitle - Di bawah Judul)</label>
                                                <textarea name="hero_subtitle" class="form-control" rows="3" placeholder="Tulis kalimat sambutan anda di sini...">{{ $settings['hero_subtitle'] ?? '' }}</textarea>
                                            </div>
                                            <div class="col-md-6 cms-input-group mb-0">
                                                <div class="cms-stat-box">
                                                    <label class="text-hos mb-2 small fw-bold">Hero Stat #1</label>
                                                    <input type="text" name="hero_stat_1_label" class="form-control mb-2 form-control-sm" placeholder="Label Asset" value="{{ $settings['hero_stat_1_label'] ?? 'Premium Assets' }}">
                                                    <input type="text" name="hero_stat_1_val" class="form-control form-control-sm" placeholder="Value (ex: 50+)" value="{{ $settings['hero_stat_1_val'] ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 cms-input-group mb-0">
                                                <div class="cms-stat-box">
                                                    <label class="text-hos mb-2 small fw-bold">Hero Stat #2</label>
                                                    <input type="text" name="hero_stat_2_label" class="form-control mb-2 form-control-sm" placeholder="Label Event" value="{{ $settings['hero_stat_2_label'] ?? 'Epic Events' }}">
                                                    <input type="text" name="hero_stat_2_val" class="form-control form-control-sm" placeholder="Value (ex: 100+)" value="{{ $settings['hero_stat_2_val'] ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- BAGIAN 3: TENTANG KAMI (ABOUT US) -->
                                    <div class="cms-section-card">
                                        <div class="cms-header-title">
                                            <i class="fas fa-address-card"></i>
                                            <span>3. Narasi "Tentang Kami"</span>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-6 cms-input-group">
                                                <label>Judul Seksi (Kecil di Atas)</label>
                                                <input type="text" name="about_header" class="form-control" value="{{ $settings['about_header'] ?? 'PROFIL PERUSAHAAN' }}">
                                            </div>
                                            <div class="col-md-3 cms-input-group">
                                                <label>Poin Unggulan 1</label>
                                                <input type="text" name="about_point_1" class="form-control" value="{{ $settings['about_point_1'] ?? 'Asset Management' }}">
                                            </div>
                                            <div class="col-md-3 cms-input-group">
                                                <label>Poin Unggulan 2</label>
                                                <input type="text" name="about_point_2" class="form-control" value="{{ $settings['about_point_2'] ?? 'Event Production' }}">
                                            </div>
                                            <div class="col-12 cms-input-group mb-0">
                                                <label>Deskripsi Lengkap Perusahaan</label>
                                                <textarea name="company_description" class="form-control" rows="4" placeholder="Jelaskan sejarah singkat, kelebihan, atau visi misi perusahaan Anda...">{{ $settings['company_description'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- BAGIAN 4: LABEL & SOSIAL MEDIA -->
                                    <div class="cms-section-card">
                                        <div class="cms-header-title">
                                            <i class="fas fa-tags"></i>
                                            <span>4. Label Konten & Media Sosial</span>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-6 cms-input-group">
                                                <label>Judul Bagian Katalog</label>
                                                <input type="text" name="catalog_header" class="form-control" value="{{ $settings['catalog_header'] ?? '' }}" placeholder="ex: DAFTAR INVENTARIS ALAT">
                                            </div>
                                            <div class="col-md-6 cms-input-group">
                                                <label>Judul Bagian Masterpiece (Portfolio)</label>
                                                <input type="text" name="portfolio_header" class="form-control" value="{{ $settings['portfolio_header'] ?? '' }}" placeholder="ex: EVENT DOKUMENTASI TERBARU">
                                            </div>
                                            <div class="col-md-6 cms-input-group">
                                                <label>Teks Tombol Konsultasi</label>
                                                <input type="text" name="cta_text" class="form-control" value="{{ $settings['cta_text'] ?? '' }}" placeholder="ex: KONSULTASI EVENT SEKARANG">
                                            </div>
                                            <div class="col-md-6 cms-input-group">
                                                <label>Pesan Konsultasi WA Otomatis</label>
                                                <input type="text" name="wa_message" class="form-control" value="{{ $settings['wa_message'] ?? '' }}" placeholder="ex: Halo HOS, saya tertarik menyewa alat...">
                                            </div>
                                            <div class="col-md-4 cms-input-group mb-0">
                                                <label><i class="fab fa-instagram me-1 text-danger"></i> Instagram Link</label>
                                                <input type="text" name="sosmed_ig" class="form-control" value="{{ ltrim($settings['sosmed_ig'] ?? '', '#') }}" placeholder="https://instagram.com/username">
                                            </div>
                                            <div class="col-md-4 cms-input-group mb-0">
                                                <label><i class="fab fa-youtube me-1 text-danger"></i> YouTube Link</label>
                                                <input type="text" name="sosmed_yt" class="form-control" value="{{ ltrim($settings['sosmed_yt'] ?? '', '#') }}" placeholder="https://youtube.com/channel">
                                            </div>
                                            <div class="col-md-4 cms-input-group mb-0">
                                                <label><i class="fab fa-tiktok me-1 text-white"></i> TikTok Link</label>
                                                <input type="text" name="sosmed_tk" class="form-control" value="{{ ltrim($settings['sosmed_tk'] ?? '', '#') }}" placeholder="https://tiktok.com/@username">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="cms-sidebar-card sticky-top" style="top: 25px; z-index: 10;">
                                        <div class="cms-header-title mb-3 pb-2 fs-6">
                                            <i class="fas fa-image"></i>
                                            <span>5. Logo & Media Utama</span>
                                        </div>

                                        <!-- LOGO -->
                                        <div class="media-upload-card">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="small fw-bold text-white"><i class="fas fa-id-badge text-hos me-1"></i> Logo Website</span>
                                                @if(isset($settings['company_logo']))
                                                    <a href="/admin/setting/reset/company_logo" class="trash-action-btn" onclick="return confirm('Hapus logo dan kembali ke teks?')"><i class="fas fa-trash-alt" style="font-size: 0.75rem;"></i></a>
                                                @endif
                                            </div>
                                            <input type="file" name="company_logo" class="form-control form-control-sm" accept="image/*">
                                            @if(isset($settings['company_logo']))
                                                <div class="media-preview-box">
                                                    <img src="{{ asset('img/'.$settings['company_logo']) }}" class="media-preview-img" style="filter: brightness(0) invert(1);">
                                                </div>
                                            @endif
                                        </div>

                                        <!-- HERO BACKGROUND -->
                                        <div class="media-upload-card">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="small fw-bold text-white"><i class="fas fa-image text-hos me-1"></i> Hero Background</span>
                                                @if(isset($settings['hero_image']))
                                                    <a href="/admin/setting/reset/hero_image" class="trash-action-btn" onclick="return confirm('Hapus background custom?')"><i class="fas fa-trash-alt" style="font-size: 0.75rem;"></i></a>
                                                @endif
                                            </div>
                                            <input type="file" name="hero_image" class="form-control form-control-sm" accept="image/*">
                                            @if(isset($settings['hero_image']))
                                                <div class="media-preview-box">
                                                    <img src="{{ asset('img/'.$settings['hero_image']) }}" class="media-preview-img">
                                                </div>
                                            @endif
                                        </div>

                                        <!-- ABOUT IMAGE -->
                                        <div class="media-upload-card">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="small fw-bold text-white"><i class="fas fa-users text-hos me-1"></i> Profil Tentang Kami</span>
                                                @if(isset($settings['about_image']))
                                                    <a href="/admin/setting/reset/about_image" class="trash-action-btn" onclick="return confirm('Hapus foto profil?')"><i class="fas fa-trash-alt" style="font-size: 0.75rem;"></i></a>
                                                @endif
                                            </div>
                                            <input type="file" name="about_image" class="form-control form-control-sm" accept="image/*">
                                            @if(isset($settings['about_image']))
                                                <div class="media-preview-box">
                                                    <img src="{{ asset('img/'.$settings['about_image']) }}" class="media-preview-img">
                                                </div>
                                            @endif
                                        </div>

                                        <!-- SAVE BUTTON -->
                                        <button type="submit" class="btn active-btn-glow w-100 py-3 mt-3"><i class="fas fa-save me-2"></i> SIMPAN SEMUA</button>
                                        <p class="small text-muted text-center mt-3 mb-0" style="font-size: 0.7rem; line-height: 1.4;">Logo muncul di Navbar & Footer. Background muncul di bagian atas halaman depan.</p>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                    <!-- LAPORAN BULANAN -->
                    <div class="tab-pane fade" id="v-pills-laporan" role="tabpanel">
                        <!-- Page Hero Header -->
                        <div class="page-hero-header animate-fade-up">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="hero-icon" style="background: rgba(34,211,238,0.12); color: #22d3ee;">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <div>
                                        <h4 style="background: linear-gradient(135deg,#ffffff 0%,#22d3ee 70%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">Laporan Operasional Bulanan</h4>
                                        <p>Rekapitulasi arus keluar-masuk alat & aktivitas logistik per bulan.</p>
                                    </div>
                                </div>
                                <a href="/admin/laporan/print?month={{ $reportMonth }}&year={{ $reportYear }}" target="_blank" class="btn" style="background: linear-gradient(135deg,#22d3ee,#0891b2); color:#000; font-weight:700; border-radius:10px; padding:10px 20px;">
                                    <i class="fas fa-print me-2"></i>Cetak Laporan
                                </a>
                            </div>
                        </div>

                        <!-- Filter Bulan & Tahun -->
                        <div class="card border-0 shadow-lg mb-4" style="background: rgba(20,20,25,0.5); border: 1px solid rgba(34,211,238,0.15) !important; border-radius:16px; backdrop-filter:blur(12px);">
                            <div class="card-body p-3 p-md-4">
                                <form method="GET" action="/dashboard" id="laporanFilterForm" class="row g-3 align-items-end">
                                    <div class="col-12 col-md-4">
                                        <label class="text-muted mb-1" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:1px; font-weight:700;">Pilih Bulan</label>
                                        <select name="report_month" class="form-select">
                                            @php
                                                $bulanArr = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
                                            @endphp
                                            @foreach($bulanArr as $k => $v)
                                                <option value="{{ $k }}" {{ $reportMonth == $k ? 'selected' : '' }} style="background:#111; color:#fff;">{{ $v }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="text-muted mb-1" style="font-size:0.75rem; text-transform:uppercase; letter-spacing:1px; font-weight:700;">Tahun</label>
                                        <select name="report_year" class="form-select">
                                            @for($y = date('Y'); $y >= date('Y')-4; $y--)
                                                <option value="{{ $y }}" {{ $reportYear == $y ? 'selected' : '' }} style="background:#111; color:#fff;">{{ $y }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <button type="submit" class="btn btn-hos w-100"><i class="fas fa-filter me-2"></i>Terapkan Filter</button>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <a href="/admin/laporan/print?month={{ $reportMonth }}&year={{ $reportYear }}" target="_blank" class="btn w-100" style="background: rgba(34,211,238,0.1); border: 1px solid rgba(34,211,238,0.3); color:#22d3ee; border-radius:8px;"><i class="fas fa-print me-1"></i>Cetak</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Statistik Bulanan -->
                        @php
                            $namaBulanLabel = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'][$reportMonth] ?? $reportMonth;
                        @endphp
                        <div class="row g-3 g-md-4 mb-4">
                            <div class="col-6 col-lg-3 stats-card-container">
                                <div class="card p-3 p-md-4 h-100 border-0" style="background: linear-gradient(135deg,rgba(34,211,238,0.1),rgba(34,211,238,0.02)); border: 1px solid rgba(34,211,238,0.2) !important; border-radius:16px;">
                                    <div class="stat-icon-wrap mb-2" style="background:rgba(34,211,238,0.12); color:#22d3ee;"><i class="fas fa-file-invoice"></i></div>
                                    <div class="stat-number" style="color:#22d3ee; font-size:1.8rem; font-size-md:2.5rem;">{{ $monthlyStats['total_manifests'] }}</div>
                                    <p class="text-muted mb-0 mt-1" style="font-size:0.75rem; line-height:1.4;">Total Event / Manifes<br><small>{{ $namaBulanLabel }} {{ $reportYear }}</small></p>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 stats-card-container">
                                <div class="card p-3 p-md-4 h-100 border-0" style="background: linear-gradient(135deg,rgba(16,185,129,0.1),rgba(16,185,129,0.02)); border: 1px solid rgba(16,185,129,0.2) !important; border-radius:16px;">
                                    <div class="stat-icon-wrap mb-2" style="background:rgba(16,185,129,0.12); color:#10B981;"><i class="fas fa-check-circle"></i></div>
                                    <div class="stat-number" style="color:#10B981; font-size:1.8rem; font-size-md:2.5rem;">{{ $monthlyStats['completed'] }}</div>
                                    <p class="text-muted mb-0 mt-1" style="font-size:0.75rem; line-height:1.4;">Manifes Selesai<br><small>Alat sudah kembali</small></p>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 stats-card-container">
                                <div class="card p-3 p-md-4 h-100 border-0" style="background: linear-gradient(135deg,rgba(245,158,11,0.1),rgba(245,158,11,0.02)); border: 1px solid rgba(245,158,11,0.2) !important; border-radius:16px;">
                                    <div class="stat-icon-wrap mb-2" style="background:rgba(245,158,11,0.12); color:#f59e0b;"><i class="fas fa-truck-loading"></i></div>
                                    <div class="stat-number" style="color:#f59e0b; font-size:1.8rem; font-size-md:2.5rem;">{{ $monthlyStats['ongoing'] }}</div>
                                    <p class="text-muted mb-0 mt-1" style="font-size:0.75rem; line-height:1.4;">Manifes Berjalan<br><small>Alat masih di luar</small></p>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 stats-card-container">
                                <div class="card p-3 p-md-4 h-100 border-0" style="background: linear-gradient(135deg,rgba(139,92,246,0.1),rgba(139,92,246,0.02)); border: 1px solid rgba(139,92,246,0.2) !important; border-radius:16px;">
                                    <div class="stat-icon-wrap mb-2" style="background:rgba(139,92,246,0.12); color:#8b5cf6;"><i class="fas fa-boxes"></i></div>
                                    <div class="stat-number" style="color:#8b5cf6; font-size:1.8rem; font-size-md:2.5rem;">{{ $monthlyStats['total_items_qty'] }}</div>
                                    <p class="text-muted mb-0 mt-1" style="font-size:0.75rem; line-height:1.4;">Total Unit Alat Keluar<br><small>Akumulasi bulan ini</small></p>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 g-lg-4">
                            <!-- Tabel Manifes Bulanan -->
                            <div class="col-12 col-lg-8">
                                <div class="card border-0 shadow-lg" style="background: rgba(20,20,25,0.5); border: 1px solid rgba(34,211,238,0.1) !important; border-radius:16px;">
                                    <div class="card-header" style="background:transparent; border-bottom: 1px solid rgba(255,255,255,0.05); padding: 18px 24px;">
                                        <span style="font-family:'Outfit'; font-weight:700; color:#fff;"><i class="fas fa-list me-2" style="color:#22d3ee;"></i>Daftar Manifes — {{ $namaBulanLabel }} {{ $reportYear }}</span>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="d-none d-md-block">
                                            <div class="table-responsive">
                                                <table class="table table-dark table-hover mb-0">
                                                    <thead>
                                                        <tr style="color:#aaa;">
                                                            <th class="px-3 px-md-4">No. Manifes</th>
                                                            <th>Klien / Event</th>
                                                            <th>Tgl. Loading</th>
                                                            <th>Crew Chief</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($reportManifests as $m)
                                                        <tr>
                                                            <td class="px-3 px-md-4 fw-bold" style="color:#22d3ee;">{{ $m->nomor_manifes }}</td>
                                                            <td>{{ $m->klien_event }}</td>
                                                            <td style="font-size:0.82rem; color:#aaa;">{{ date('d M Y', strtotime($m->tanggal_loading)) }}</td>
                                                            <td>{{ $m->crew_chief }}</td>
                                                            <td>
                                                                @if($m->status == 'Alat Diluar')
                                                                    <span class="badge bg-warning text-dark"><i class="fas fa-truck-loading me-1"></i>Diluar</span>
                                                                @else
                                                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Kembali</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center py-5">
                                                                <i class="fas fa-calendar-times fa-2x mb-2" style="color:rgba(34,211,238,0.3);"></i>
                                                                <p class="text-muted mb-0">Tidak ada aktivitas manifes pada {{ $namaBulanLabel }} {{ $reportYear }}.</p>
                                                            </td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="d-md-none p-3">
                                            @forelse($reportManifests as $m)
                                            <div class="mobile-report-card p-3 mb-3">
                                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                                    <div>
                                                        <div class="fw-bold text-white">{{ $m->nomor_manifes }}</div>
                                                        <div class="small text-white-50">{{ $m->klien_event }}</div>
                                                    </div>
                                                    @if($m->status == 'Alat Diluar')
                                                        <span class="badge bg-warning text-dark"><i class="fas fa-truck-loading me-1"></i>Diluar</span>
                                                    @else
                                                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Kembali</span>
                                                    @endif
                                                </div>
                                                <div class="small text-white-50">Crew: {{ $m->crew_chief }}</div>
                                                <div class="small text-white-50 mt-1">Tanggal: {{ date('d M Y', strtotime($m->tanggal_loading)) }}</div>
                                            </div>
                                            @empty
                                            <div class="text-center py-5" style="color: rgba(255,255,255,0.35);">
                                                <i class="fas fa-calendar-times fa-2x mb-2 d-block"></i>
                                                Tidak ada aktivitas manifes pada {{ $namaBulanLabel }} {{ $reportYear }}.
                                            </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Top 5 Alat Paling Banyak Digunakan -->
                            <div class="col-12 col-lg-4">
                                <div class="card border-0 shadow-lg h-100" style="background: rgba(20,20,25,0.5); border: 1px solid rgba(139,92,246,0.15) !important; border-radius:16px;">
                                    <div class="card-header" style="background:transparent; border-bottom: 1px solid rgba(255,255,255,0.05); padding: 18px 24px;">
                                        <span style="font-family:'Outfit'; font-weight:700; color:#fff;"><i class="fas fa-trophy me-2" style="color:#f59e0b;"></i>Top 5 Alat Terbanyak</span>
                                    </div>
                                    <div class="card-body p-3 p-md-4">
                                        @if(count($monthlyStats['top_items']) > 0)
                                            @php $rank = 1; $maxQty = max(array_values($monthlyStats['top_items'])); @endphp
                                            @foreach($monthlyStats['top_items'] as $namaAlat => $jumlahUnit)
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span style="font-size:0.82rem; color:#e5e7eb; font-weight:600;">
                                                        <span class="me-1" style="color:{{ $rank==1 ? '#f59e0b' : ($rank==2 ? '#94a3b8' : '#b45309') }};">{{ $rank == 1 ? '🥇' : ($rank == 2 ? '🥈' : ($rank == 3 ? '🥉' : "#{$rank}")) }}</span>
                                                        {{ $namaAlat }}
                                                    </span>
                                                    <span class="badge" style="background:rgba(139,92,246,0.15); color:#8b5cf6; border: 1px solid rgba(139,92,246,0.3); font-size:0.7rem;">{{ $jumlahUnit }} Unit</span>
                                                </div>
                                                <div class="progress" style="height:6px; background:rgba(255,255,255,0.05); border-radius:4px;">
                                                    <div class="progress-bar" style="width:{{ round(($jumlahUnit/$maxQty)*100) }}%; background:linear-gradient(90deg,#8b5cf6,#22d3ee); border-radius:4px;"></div>
                                                </div>
                                            </div>
                                            @php $rank++; @endphp
                                            @endforeach
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fas fa-box-open fa-2x mb-2" style="color:rgba(139,92,246,0.3);"></i>
                                                <p class="text-muted mb-0" style="font-size:0.85rem;">Belum ada data alat untuk bulan ini.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END LAPORAN BULANAN -->

                    @if(Auth::user() && Auth::user()->isAdmin())
                                        <!-- KELOLA PENGGUNA -->
                    <div class="tab-pane fade" id="v-pills-users" role="tabpanel">
                        <!-- Page Hero Header -->
                        <div class="page-hero-header animate-fade-up">
                            <div class="d-flex align-items-center gap-3">
                                <div class="hero-icon" style="background: rgba(16,185,129,0.12); color: #10B981;">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div>
                                    <h4 style="background: linear-gradient(135deg,#ffffff 0%,#10B981 70%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">Manajemen Pengguna &amp; Akses</h4>
                                    <p>Kelola akun Admin &amp; Pegawai yang dapat masuk ke dashboard. Login menggunakan <strong style="color:#10B981;">username &amp; password</strong> — tanpa Gmail.</p>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <!-- Daftar Pengguna Terdaftar -->
                            <div class="col-lg-7">
                                <div class="card border-0 shadow-lg" style="background: rgba(20,20,25,0.5); border: 1px solid rgba(16,185,129,0.15) !important; border-radius:16px;">
                                    <div class="card-header" style="background:transparent; border-bottom:1px solid rgba(255,255,255,0.05); padding:18px 24px;">
                                        <span style="font-family:'Outfit'; font-weight:700; color:#fff;"><i class="fas fa-users me-2" style="color:#10B981;"></i>Pengguna Terdaftar</span>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="d-none d-lg-block">
                                            <div class="table-responsive" style="overflow: visible;">
                                                <table class="table table-dark table-hover mb-0" style="font-size:0.88rem;">
                                                    <thead>
                                                        <tr style="color:#aaa;">
                                                            <th class="px-4">Nama</th>
                                                            <th>Username</th>
                                                            <th>Gmail / Email</th>
                                                            <th>Role</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($adminUsers as $adminU)
                                                        <tr>
                                                            <td class="px-4 fw-bold" style="color:#fff;">
                                                                {{ $adminU->name }}
                                                                @if($adminU->id == Auth::id())
                                                                    <span class="badge ms-1" style="background:rgba(16,185,129,0.15); color:#10B981; border:1px solid rgba(16,185,129,0.3); font-size:0.6rem;">Anda</span>
                                                                @endif
                                                            </td>
                                                            <td style="color:#aaa;">
                                                                <code style="background:rgba(255,255,255,0.05); padding:2px 8px; border-radius:6px; color:#10B981; font-size:0.8rem;">{{ $adminU->username }}</code>
                                                            </td>
                                                            <td style="color:#aaa; font-size:0.82rem;">{{ $adminU->email }}</td>
                                                            <td>
                                                                @if($adminU->role === 'admin')
                                                                    <span class="badge bg-success" style="font-size:0.7rem;"><i class="fas fa-shield-alt me-1"></i>Admin</span>
                                                                @else
                                                                    <span class="badge bg-info text-dark" style="font-size:0.7rem;"><i class="fas fa-user me-1"></i>Pegawai</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="dropdown" style="display:inline-block;">
                                                                    <button class="btn btn-sm dropdown-toggle px-3 py-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size:0.75rem; font-weight:700; border-radius:8px; border:1px solid rgba(16,185,129,0.4); background:rgba(16,185,129,0.12); color:#10B981;">
                                                                        <i class="fas fa-cog me-1"></i>Kelola
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow-lg" style="background:#0f0f15; border:1px solid rgba(16,185,129,0.25); font-size:0.82rem; border-radius:10px; min-width:180px; z-index:9999;">
                                                                        <li>
                                                                            <button type="button" class="dropdown-item py-2" onclick="toggleUserForm({{ $adminU->id }}, 'uname')">
                                                                                <i class="fas fa-user-edit me-2" style="color:#a78bfa; width:16px;"></i>Ubah Username
                                                                            </button>
                                                                        </li>
                                                                        <li>
                                                                            <button type="button" class="dropdown-item py-2" onclick="toggleUserForm({{ $adminU->id }}, 'email')">
                                                                                <i class="fas fa-envelope me-2" style="color:#0ea5e9; width:16px;"></i>Ubah Email/Gmail
                                                                            </button>
                                                                        </li>
                                                                        <li>
                                                                            <button type="button" class="dropdown-item py-2" onclick="toggleUserForm({{ $adminU->id }}, 'pwd')">
                                                                                <i class="fas fa-key me-2" style="color:#eab308; width:16px;"></i>Ubah Password
                                                                            </button>
                                                                        </li>
                                                                        @if($adminU->id != Auth::id())
                                                                        <li><hr class="dropdown-divider" style="border-color:rgba(255,255,255,0.06);"></li>
                                                                        <li>
                                                                            <form action="/admin/users/delete/{{ $adminU->id }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengguna {{ $adminU->name }}?');">
                                                                                @csrf @method('DELETE')
                                                                                <button type="submit" class="dropdown-item py-2 text-danger">
                                                                                    <i class="fas fa-trash-alt me-2" style="width:16px;"></i>Hapus Akses
                                                                                </button>
                                                                            </form>
                                                                        </li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        {{-- Form Ganti Username --}}
                                                        <tr id="uname-form-{{ $adminU->id }}-desktop" class="d-none">
                                                            <td colspan="5" class="px-4 pb-3 pt-1.5" style="background:rgba(139,92,246,0.04); border-left:3px solid rgba(139,92,246,0.3);">
                                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                                    <i class="fas fa-user-edit" style="color:#a78bfa; font-size:0.8rem;"></i>
                                                                    <span style="color:#a78bfa; font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.8px;">Ganti Username untuk {{ $adminU->name }}</span>
                                                                </div>
                                                                <form action="/admin/users/{{ $adminU->id }}/username" method="POST" class="d-flex gap-2 align-items-center flex-wrap">
                                                                    @csrf
                                                                    <input type="text" name="username" class="form-control form-control-sm" placeholder="Username baru (huruf, angka, _)" required pattern="[a-zA-Z0-9_]+" value="{{ $adminU->username }}" style="max-width:220px; background:rgba(255,255,255,0.04); border-color:rgba(139,92,246,0.4); color:#fff; border-radius:8px;">
                                                                    <button type="submit" class="btn btn-sm" style="background:rgba(139,92,246,0.15); color:#a78bfa; border:1px solid rgba(139,92,246,0.3); border-radius:8px; font-size:0.78rem; font-weight:600; white-space:nowrap;">
                                                                        <i class="fas fa-save me-1"></i>Simpan
                                                                    </button>
                                                                    <button type="button" onclick="toggleUserForm({{ $adminU->id }}, 'uname')" class="btn btn-sm" style="background:rgba(255,255,255,0.05); color:#aaa; border:1px solid rgba(255,255,255,0.1); border-radius:8px; font-size:0.78rem;">
                                                                        Batal
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        {{-- Form Ganti Email --}}
                                                        <tr id="email-form-{{ $adminU->id }}-desktop" class="d-none">
                                                            <td colspan="5" class="px-4 pb-3 pt-1.5" style="background:rgba(14,165,233,0.04); border-left:3px solid rgba(14,165,233,0.3);">
                                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                                    <i class="fas fa-envelope" style="color:#0ea5e9; font-size:0.8rem;"></i>
                                                                    <span style="color:#0ea5e9; font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.8px;">Ganti Email/Gmail untuk {{ $adminU->name }}</span>
                                                                </div>
                                                                <form action="/admin/users/{{ $adminU->id }}/email" method="POST" class="d-flex gap-2 align-items-center flex-wrap">
                                                                    @csrf
                                                                    <input type="email" name="email" class="form-control form-control-sm" placeholder="Email baru" required value="{{ $adminU->email }}" style="max-width:220px; background:rgba(255,255,255,0.04); border-color:rgba(14,165,233,0.4); color:#fff; border-radius:8px;">
                                                                    <button type="submit" class="btn btn-sm" style="background:rgba(14,165,233,0.15); color:#0ea5e9; border:1px solid rgba(14,165,233,0.3); border-radius:8px; font-size:0.78rem; font-weight:600; white-space:nowrap;">
                                                                        <i class="fas fa-save me-1"></i>Simpan
                                                                    </button>
                                                                    <button type="button" onclick="toggleUserForm({{ $adminU->id }}, 'email')" class="btn btn-sm" style="background:rgba(255,255,255,0.05); color:#aaa; border:1px solid rgba(255,255,255,0.1); border-radius:8px; font-size:0.78rem;">
                                                                        Batal
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        {{-- Form Ganti Password --}}
                                                        <tr id="pwd-form-{{ $adminU->id }}-desktop" class="d-none">
                                                            <td colspan="5" class="px-4 pb-3 pt-1.5" style="background:rgba(6,182,212,0.04); border-left:3px solid rgba(6,182,212,0.3);">
                                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                                    <i class="fas fa-key" style="color:#22d3ee; font-size:0.8rem;"></i>
                                                                    <span style="color:#22d3ee; font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.8px;">Ganti Password untuk {{ $adminU->name }}</span>
                                                                </div>
                                                                <form action="/admin/users/{{ $adminU->id }}/password" method="POST" class="d-flex gap-2 align-items-center flex-wrap">
                                                                    @csrf
                                                                    <input type="password" name="password" class="form-control form-control-sm" placeholder="Password baru (min 6 karakter)" required minlength="6" style="max-width:220px; background:rgba(255,255,255,0.04); border-color:rgba(6,182,212,0.3); color:#fff; border-radius:8px;">
                                                                    <button type="submit" class="btn btn-sm" style="background:rgba(6,182,212,0.15); color:#22d3ee; border:1px solid rgba(6,182,212,0.3); border-radius:8px; font-size:0.78rem; font-weight:600; white-space:nowrap;">
                                                                        <i class="fas fa-save me-1"></i>Simpan
                                                                    </button>
                                                                    <button type="button" onclick="toggleUserForm({{ $adminU->id }}, 'pwd')" class="btn btn-sm" style="background:rgba(255,255,255,0.05); color:#aaa; border:1px solid rgba(255,255,255,0.1); border-radius:8px; font-size:0.78rem;">
                                                                        Batal
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="d-lg-none p-3">
                                            @foreach($adminUsers as $adminU)
                                            <div class="card mobile-user-card p-3 mb-3">
                                                <div class="d-flex justify-content-between align-items-start gap-2">
                                                    <div>
                                                        <div class="fw-bold text-white" style="font-size: 0.95rem;">
                                                            {{ $adminU->name }}
                                                            @if($adminU->id == Auth::id())
                                                                <span class="badge ms-1" style="background:rgba(16,185,129,0.15); color:#10B981; border:1px solid rgba(16,185,129,0.3); font-size:0.6rem;">Anda</span>
                                                            @endif
                                                        </div>
                                                        <div class="small text-white-50">{{ $adminU->username }}</div>
                                                        <div class="small text-white-50">{{ $adminU->email }}</div>
                                                        <div class="mt-2">
                                                            @if($adminU->role === 'admin')
                                                                <span class="badge bg-success" style="font-size:0.7rem;"><i class="fas fa-shield-alt me-1"></i>Admin</span>
                                                            @else
                                                                <span class="badge bg-info text-dark" style="font-size:0.7rem;"><i class="fas fa-user me-1"></i>Pegawai</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="d-lg-none">
                                                        <button class="btn btn-sm px-3 py-1" type="button" onclick="toggleUserActionPanel({{ $adminU->id }})" style="font-size:0.75rem; font-weight:700; border-radius:8px; border:1px solid rgba(16,185,129,0.4); background:rgba(16,185,129,0.12); color:#10B981;">
                                                            <i class="fas fa-sliders-h me-1"></i>Kelola
                                                        </button>
                                                        <div class="collapse mt-2" id="mobile-user-actions-{{ $adminU->id }}">
                                                            <div class="user-action-grid">
                                                                <button type="button" class="user-action-btn" onclick="toggleUserForm({{ $adminU->id }}, 'uname')">
                                                                    <i class="fas fa-user-edit"></i><span>Username</span>
                                                                </button>
                                                                <button type="button" class="user-action-btn" onclick="toggleUserForm({{ $adminU->id }}, 'email')">
                                                                    <i class="fas fa-envelope"></i><span>Email</span>
                                                                </button>
                                                                <button type="button" class="user-action-btn" onclick="toggleUserForm({{ $adminU->id }}, 'pwd')">
                                                                    <i class="fas fa-key"></i><span>Password</span>
                                                                </button>
                                                                @if($adminU->id != Auth::id())
                                                                <form action="/admin/users/delete/{{ $adminU->id }}" method="POST" class="d-block" onsubmit="return confirm('Hapus pengguna {{ $adminU->name }}?');">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit" class="user-action-btn text-danger w-100">
                                                                        <i class="fas fa-trash-alt"></i><span>Hapus</span>
                                                                    </button>
                                                                </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="uname-form-{{ $adminU->id }}-mobile" class="mt-3 p-3 rounded-3 d-none mobile-user-form-panel" style="background:rgba(139,92,246,0.06); border:1px solid rgba(139,92,246,0.2);">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <i class="fas fa-user-edit" style="color:#a78bfa; font-size:0.8rem;"></i>
                                                        <span style="color:#a78bfa; font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.8px;">Ganti Username</span>
                                                    </div>
                                                    <form action="/admin/users/{{ $adminU->id }}/username" method="POST" class="user-form">
                                                        @csrf
                                                        <input type="text" name="username" class="form-control form-control-sm" placeholder="Username baru" required pattern="[a-zA-Z0-9_]+" value="{{ $adminU->username }}" style="background:rgba(255,255,255,0.04); border-color:rgba(139,92,246,0.4); color:#fff; border-radius:8px;">
                                                        <button type="submit" class="btn btn-sm" style="background:rgba(139,92,246,0.15); color:#a78bfa; border:1px solid rgba(139,92,246,0.3); border-radius:8px; font-size:0.78rem; font-weight:600;">
                                                            <i class="fas fa-save me-1"></i>Simpan
                                                        </button>
                                                        <button type="button" onclick="toggleUserForm({{ $adminU->id }}, 'uname')" class="btn btn-sm" style="background:rgba(255,255,255,0.05); color:#aaa; border:1px solid rgba(255,255,255,0.1); border-radius:8px; font-size:0.78rem;">
                                                            Batal
                                                        </button>
                                                    </form>
                                                </div>

                                                <div id="email-form-{{ $adminU->id }}-mobile" class="mt-3 p-3 rounded-3 d-none mobile-user-form-panel" style="background:rgba(14,165,233,0.06); border:1px solid rgba(14,165,233,0.2);">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <i class="fas fa-envelope" style="color:#0ea5e9; font-size:0.8rem;"></i>
                                                        <span style="color:#0ea5e9; font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.8px;">Ganti Email/Gmail</span>
                                                    </div>
                                                    <form action="/admin/users/{{ $adminU->id }}/email" method="POST" class="user-form">
                                                        @csrf
                                                        <input type="email" name="email" class="form-control form-control-sm" placeholder="Email baru" required value="{{ $adminU->email }}" style="background:rgba(255,255,255,0.04); border-color:rgba(14,165,233,0.4); color:#fff; border-radius:8px;">
                                                        <button type="submit" class="btn btn-sm" style="background:rgba(14,165,233,0.15); color:#0ea5e9; border:1px solid rgba(14,165,233,0.3); border-radius:8px; font-size:0.78rem; font-weight:600;">
                                                            <i class="fas fa-save me-1"></i>Simpan
                                                        </button>
                                                        <button type="button" onclick="toggleUserForm({{ $adminU->id }}, 'email')" class="btn btn-sm" style="background:rgba(255,255,255,0.05); color:#aaa; border:1px solid rgba(255,255,255,0.1); border-radius:8px; font-size:0.78rem;">
                                                            Batal
                                                        </button>
                                                    </form>
                                                </div>

                                                <div id="pwd-form-{{ $adminU->id }}-mobile" class="mt-3 p-3 rounded-3 d-none mobile-user-form-panel" style="background:rgba(6,182,212,0.06); border:1px solid rgba(6,182,212,0.2);">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <i class="fas fa-key" style="color:#22d3ee; font-size:0.8rem;"></i>
                                                        <span style="color:#22d3ee; font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.8px;">Ganti Password</span>
                                                    </div>
                                                    <form action="/admin/users/{{ $adminU->id }}/password" method="POST" class="user-form">
                                                        @csrf
                                                        <input type="password" name="password" class="form-control form-control-sm" placeholder="Password baru" required minlength="6" style="background:rgba(255,255,255,0.04); border-color:rgba(6,182,212,0.3); color:#fff; border-radius:8px;">
                                                        <button type="submit" class="btn btn-sm" style="background:rgba(6,182,212,0.15); color:#22d3ee; border:1px solid rgba(6,182,212,0.3); border-radius:8px; font-size:0.78rem; font-weight:600;">
                                                            <i class="fas fa-save me-1"></i>Simpan
                                                        </button>
                                                        <button type="button" onclick="toggleUserForm({{ $adminU->id }}, 'pwd')" class="btn btn-sm" style="background:rgba(255,255,255,0.05); color:#aaa; border:1px solid rgba(255,255,255,0.1); border-radius:8px; font-size:0.78rem;">
                                                            Batal
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3 p-3" style="background:rgba(16,185,129,0.06); border:1px solid rgba(16,185,129,0.12); border-radius:12px; font-size:0.78rem; color:rgba(255,255,255,0.5); line-height:1.8;">
                                    <i class="fas fa-info-circle me-1" style="color:#10B981;"></i>
                                    <strong style="color:rgba(255,255,255,0.75);">Lupa password?</strong>
                                    Buka halaman <a href="/forgot-password" style="color:#10B981; text-decoration:underline;">Lupa Password</a>. Masukkan email Gmail terdaftar Anda, dan sistem akan mengirimkan link reset password baru secara langsung ke inbox Gmail Anda.
                                </div>
                            </div>

                            <!-- Kolom Kanan: Tambah Pengguna + PIN Setup -->
                            <div class="col-lg-5 d-flex flex-column gap-4">
                                <!-- Form Tambah Pengguna Baru -->
                                <div class="card border-0 shadow-lg" style="background: rgba(20,20,25,0.5); border: 1px solid rgba(34,211,238,0.15) !important; border-radius:16px;">
                                    <div class="card-body p-4">
                                        <h5 class="mb-1" style="color:#22d3ee; font-weight:700; font-family:'Outfit';"><i class="fas fa-user-plus me-2"></i>Tambah Pengguna Baru</h5>
                                        <p class="text-muted mb-4" style="font-size:0.8rem;">Buat username &amp; password untuk Admin atau Pegawai baru.</p>
                                        <form action="/admin/users" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="text-muted mb-1" style="font-size:0.72rem; text-transform:uppercase; letter-spacing:1px; font-weight:700;">Nama Lengkap</label>
                                                <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="text-muted mb-1" style="font-size:0.72rem; text-transform:uppercase; letter-spacing:1px; font-weight:700;">Username</label>
                                                <input type="text" name="username" class="form-control" placeholder="Contoh: budi_operator" required pattern="[a-zA-Z0-9_]+" title="Hanya huruf, angka, dan underscore">
                                                <div style="font-size:0.68rem; color:#555; margin-top:4px;">Hanya huruf, angka, dan underscore. Digunakan untuk login.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="text-muted mb-1" style="font-size:0.72rem; text-transform:uppercase; letter-spacing:1px; font-weight:700;">Gmail / Email</label>
                                                <input type="email" name="email" class="form-control" placeholder="budi@gmail.com" required>
                                                <div style="font-size:0.68rem; color:#555; margin-top:4px;">Digunakan untuk menerima link pemulihan password jika lupa.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="text-muted mb-1" style="font-size:0.72rem; text-transform:uppercase; letter-spacing:1px; font-weight:700;">Password</label>
                                                <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required minlength="6">
                                            </div>
                                            <div class="mb-4">
                                                <label class="text-muted mb-1" style="font-size:0.72rem; text-transform:uppercase; letter-spacing:1px; font-weight:700;">Hak Akses / Role</label>
                                                <select name="role" class="form-select">
                                                    <option value="pegawai" selected style="background:#111; color:#fff;">Pegawai (Akses Terbatas + Approval)</option>
                                                    <option value="admin" style="background:#111; color:#fff;">Admin (Akses Penuh)</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-hos w-100 py-2">
                                                <i class="fas fa-plus-circle me-2"></i>Tambahkan Pengguna
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END KELOLA PENGGUNA -->
                    @endif

                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- MODAL ADD ASET -->
    <div class="modal fade" id="modalTambahAset" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><form action="/admin/aset" method="POST" enctype="multipart/form-data">@csrf<div class="modal-header"><h5 class="modal-title text-hos">Tambah Aset Baru</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="mb-3"><label>Nama Alat</label><input type="text" name="nama_alat" class="form-control" placeholder="Contoh: Speaker Flying 15 Inch" required></div>
            <div class="mb-3"><label>Kategori</label><input type="text" name="kategori" class="form-control" list="kategoriList" placeholder="Ketik atau pilih kategori" required><datalist id="kategoriList">@foreach($inventories->pluck('kategori')->unique() as $kat)<option value="{{ $kat }}">@endforeach</datalist></div>
            <div class="mb-3"><label>Stok</label><input type="number" name="stok_tersedia" class="form-control" placeholder="1" min="1" required></div>
            <div class="mb-3">
                <label class="text-hos">Kondisi Alat <small class="text-muted fw-normal">(hanya tampil di dashboard admin)</small></label>
                <select name="kondisi_alat" class="form-select">
                    <option value="Baik" selected>✅ Baik</option>
                    <option value="Perlu Servis">⚠️ Perlu Servis</option>
                    <option value="Rusak">❌ Rusak</option>
                </select>
            </div>
            <div class="mb-0"><label class="text-hos">Foto Alat (Optional)</label><input type="file" name="foto_alat" class="form-control" accept="image/*"></div>
        </div>
        <div class="modal-footer border-0"><button class="btn btn-hos w-100 py-3">SIMPAN DATA ASET</button></div>
    </form></div></div></div>

    <!-- MODAL EDIT ASET -->
    <div class="modal fade" id="modalEditAset" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><form id="formEditAset" method="POST" enctype="multipart/form-data">@csrf
        <div class="modal-header"><h5 class="modal-title text-hos">Edit Data Aset</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="mb-3"><label>Nama Alat</label><input type="text" id="edit_nama_alat" name="nama_alat" class="form-control" required></div>
            <div class="mb-3"><label>Kategori</label><input type="text" id="edit_kategori" name="kategori" class="form-control" list="kategoriList" required></div>
            <div class="mb-3"><label>Stok Tersedia</label><input type="number" id="edit_stok" name="stok_tersedia" class="form-control" required></div>
            <div class="mb-3">
                <label class="text-hos">Kondisi Alat <small class="text-muted fw-normal">(hanya tampil di dashboard admin)</small></label>
                <select name="kondisi_alat" id="edit_kondisi_alat" class="form-select">
                    <option value="Baik">✅ Baik</option>
                    <option value="Perlu Servis">⚠️ Perlu Servis</option>
                    <option value="Rusak">❌ Rusak</option>
                </select>
            </div>
            <div class="mb-0">
                <label class="text-hos">Foto Alat (Pilih untuk ganti)</label>
                <input type="file" name="foto_alat" class="form-control mb-2" accept="image/*">
                <div id="edit_foto_preview" class="text-center p-2" style="background: rgba(255,255,255,0.05); border-radius: 8px;">
                    <small class="text-muted d-block mb-1">Foto Saat Ini:</small>
                    <img src="" id="img_preview" style="max-height:80px; border-radius: 5px;">
                </div>
            </div>
        </div>
        <div class="modal-footer border-0"><button class="btn btn-hos w-100 py-3">SIMPAN PERUBAHAN</button></div>
    </form></div></div></div>

    <!-- MODAL TAMBAH ALBUM -->
    <div class="modal fade" id="modalTambahAlbum" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form id="uploadForm" action="/admin/album" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title text-hos"><i class="fas fa-camera-retro me-2"></i>Upload Album Dokumentasi</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Judul Event</label>
                                    <input type="text" name="judul_event" class="form-control" placeholder="Contoh: Wedding Rian & Sisi" required>
                                </div>
                                <div class="mb-3">
                                    <label class="text-hos fw-bold">Tanggal Mulai Event</label>
                                    <input type="date" name="tanggal_event" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted">Tanggal Selesai Event <small class="ms-1">(opsional, isi jika event lebih dari 1 hari)</small></label>
                                    <input type="date" name="tanggal_selesai" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Deskripsi Event</label>
                                    <textarea name="deskripsi_event" class="form-control" rows="3" placeholder="Contoh: Dokumentasi sound system, lighting, panggung..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-hos fw-bold">Cover Album <small class="text-muted fw-normal">(ditampilkan di halaman utama)</small></label>
                                    <input type="file" name="cover_album" id="tambah_cover_input" class="form-control" accept="image/*" onchange="previewTambahCover(this)">
                                    <div id="tambah_cover_preview" class="mt-2 text-center" style="display:none">
                                        <img id="tambah_cover_img" src="" class="img-fluid rounded" style="max-height:120px; border: 2px solid var(--primary-green);">
                                        <small class="d-block text-muted mt-1">Preview Cover</small>
                                    </div>
                                    <small class="text-muted d-block mt-1">Jika tidak dipilih, foto pertama yang diunggah akan otomatis menjadi cover.</small>
                                </div>
                                <div class="mb-3">
                                    <label class="text-hos fw-bold">File Dokumentasi (Foto/Video)</label>
                                    <input type="file" name="dokumentasi[]" class="form-control" accept="image/*,video/*" multiple required>
                                    <small class="text-muted">Pilih beberapa foto/video sekaligus.</small>
                                </div>
                                <!-- Progress Bar Container -->
                                <div id="progressContainer" class="mt-3" style="display: none;">
                                    <label class="small text-muted d-block mb-1">Mengunggah: <span id="percentText" class="fw-bold text-hos">0%</span></label>
                                    <div class="progress" style="height: 10px; background: rgba(255,255,255,0.1); border-radius: 5px;">
                                        <div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: 0%; transition: width 0.1s ease; border-radius: 5px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" id="submitBtn" class="btn btn-hos w-100 py-3"><i class="fas fa-upload me-2"></i>UNGGAH ALBUM & FILE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT ALBUM -->
    <div class="modal fade" id="modalEditAlbum" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form id="formEditAlbum" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title text-hos">Edit Album Dokumentasi</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Judul Event</label>
                                    <input type="text" id="edit_judul_event" name="judul_event" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label class="text-hos fw-bold">Tanggal Mulai Event</label>
                                    <input type="date" id="edit_tanggal_event" name="tanggal_event" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted">Tanggal Selesai <small>(opsional)</small></label>
                                    <input type="date" id="edit_tanggal_selesai" name="tanggal_selesai" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Deskripsi</label>
                                    <textarea id="edit_deskripsi_event" name="deskripsi_event" class="form-control" rows="2"></textarea>
                                </div>
                                <div class="mb-2">
                                    <label class="text-hos fw-bold">Ganti Cover Album</label>
                                    <input type="file" name="cover_album" id="edit_cover_input" class="form-control" accept="image/*" onchange="previewEditCover(this)">
                                    <div id="edit_cover_preview" class="mt-2 text-center">
                                        <img id="edit_cover_img" src="" class="img-fluid rounded" style="max-height:90px; border: 2px solid var(--primary-green);">
                                        <small class="d-block text-muted mt-1">Cover Saat Ini</small>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <label class="text-hos fw-bold">Tambah File Baru (Foto/Video)</label>
                                    <input type="file" name="dokumentasi[]" class="form-control" accept="image/*,video/*" multiple>
                                    <small class="text-muted">Akan ditambahkan ke dokumentasi yang sudah ada.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-hos d-block mb-2">Dokumentasi Saat Ini <small class="text-muted">(klik sampah untuk hapus)</small></label>
                                <div id="editAlbumFilesContainer" class="row g-2 p-2 border border-secondary rounded mx-0" style="max-height: 360px; overflow-y: auto; background: rgba(0,0,0,0.3);">
                                    <!-- Populate thumbnails via JS -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 flex-column gap-2">
                        <!-- Progress bar untuk edit upload -->
                        <div id="editProgressContainer" class="w-100" style="display:none;">
                            <label class="small text-muted d-block mb-1">Mengunggah file: <span id="editPercentText" class="fw-bold text-hos">0%</span></label>
                            <div class="progress" style="height:10px; background:rgba(255,255,255,0.1); border-radius:5px;">
                                <div id="editProgressBar" class="progress-bar bg-success" role="progressbar" style="width:0%; transition:width 0.1s ease; border-radius:5px;"></div>
                            </div>
                            <small class="text-muted">Mohon tunggu, jangan tutup halaman ini...</small>
                        </div>
                        <button type="submit" id="editSubmitBtn" class="btn btn-hos w-100 py-3"><i class="fas fa-save me-2"></i>SIMPAN PERUBAHAN ALBUM</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL PREVIEW GALERI (FULLSCREEN LIGHTBOX) -->
    <div class="modal fade" id="modalPublik" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="background: #0d0d12; border: 1px solid var(--accent-green); border-radius: 20px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title text-hos" id="pubTitle"></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="pubContent" class="row g-3"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ZOOM MODAL (ADMIN VISUALIZER) -->
    <div class="modal fade" id="modalZoom" tabindex="-1" style="background: rgba(0,0,0,0.95); z-index: 10000;">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 bg-transparent">
                <div class="modal-body p-0 text-center position-relative">
                    <button class="btn text-white position-absolute start-0 top-50 translate-middle-y fs-1 px-4" onclick="prevFoto()" style="background:none; border:none; z-index:10001;"><i class="fas fa-chevron-left"></i></button>
                    <img id="zoomImg" src="" style="max-width: 100%; max-height: 90vh; border: 1px solid rgba(255,255,255,0.2); border-radius: 12px; box-shadow: 0 0 50px rgba(0,0,0,1);">
                    <button class="btn text-white position-absolute end-0 top-50 translate-middle-y fs-1 px-4" onclick="nextFoto()" style="background:none; border:none; z-index:10001;"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </div>
    {{-- =====================================================================
         MODAL TAMBAH MANIFES — Redesigned UI/UX (3 Tabs)
         ===================================================================== --}}
    <div class="modal fade" id="modalTambahManifes" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width:720px;">
            <div class="modal-content border-0" style="background: #0f0f14; border-radius: 20px; border: 1px solid rgba(16,185,129,0.18); box-shadow: 0 40px 80px rgba(0,0,0,0.8), 0 0 60px rgba(16,185,129,0.06);">
                <form id="formManifes" action="/admin/manifes" method="POST">
                    @csrf

                    {{-- === HEADER === --}}
                    <div class="d-flex align-items-center justify-content-between px-4 pt-4 pb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:40px;height:40px;background:rgba(16,185,129,0.12);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-file-alt" style="color:var(--primary-green);font-size:1rem;"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold text-white" id="manifestModalTitle" style="font-size:1.05rem;">Buat Manifes Baru</h5>
                                <small style="color:rgba(255,255,255,0.35); font-size:0.72rem; letter-spacing:0.5px;">Surat Jalan Keluar / Masuk Gudang</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup" style="opacity:0.4; transition:opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.4"></button>
                    </div>

                    {{-- === TAB NAVIGATOR === --}}
                    <div class="px-4 pb-0">
                        <ul class="nav gap-1 mb-0 p-0" role="tablist"
                            style="border-bottom: 2px solid rgba(255,255,255,0.07); list-style:none;">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active border-0 px-3 py-2 rounded-top text-white fw-semibold"
                                        data-bs-toggle="tab" data-bs-target="#tab-info" type="button"
                                        style="font-size:0.82rem; background:transparent; letter-spacing:0.3px; transition:all 0.2s;"
                                        id="tab-info-btn">
                                    <span class="me-2" style="background:rgba(16,185,129,0.15);color:var(--primary-green);border-radius:50%;width:20px;height:20px;display:inline-flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:700;">1</span>
                                    Info Utama & Catatan
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link border-0 px-3 py-2 rounded-top fw-semibold"
                                        data-bs-toggle="tab" data-bs-target="#tab-inventaris" type="button"
                                        style="font-size:0.82rem; background:transparent; color:rgba(255,255,255,0.45); letter-spacing:0.3px; transition:all 0.2s;"
                                        id="tab-inv-btn">
                                    <span class="me-2" style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.4);border-radius:50%;width:20px;height:20px;display:inline-flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:700;">2</span>
                                    Alat Inventaris
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link border-0 px-3 py-2 rounded-top fw-semibold"
                                        data-bs-toggle="tab" data-bs-target="#tab-luar" type="button"
                                        style="font-size:0.82rem; background:transparent; color:rgba(255,255,255,0.45); letter-spacing:0.3px; transition:all 0.2s;"
                                        id="tab-luar-btn">
                                    <span class="me-2" style="background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.4);border-radius:50%;width:20px;height:20px;display:inline-flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:700;">3</span>
                                    Alat Tambahan
                                </button>
                            </li>
                        </ul>
                    </div>

                    {{-- === TAB CONTENT === --}}
                    <div class="tab-content px-4 py-4" style="max-height:60vh; overflow-y:auto;">

                        {{-- ─── PANEL 1: INFO UTAMA & CATATAN ─────────────────────────────── --}}
                        <div class="tab-pane fade show active" id="tab-info" role="tabpanel">
                            <div class="row g-3 mb-3">
                                <div class="col-md-7">
                                    <label class="d-flex align-items-center gap-2 mb-2" style="font-size:0.78rem;font-weight:600;text-transform:uppercase;letter-spacing:0.8px;color:rgba(255,255,255,0.55);">
                                        <i class="fas fa-user-tie" style="color:var(--primary-green);font-size:0.72rem;"></i> Klien / Event
                                    </label>
                                    <input type="text" id="m_klien" name="klien_event"
                                           class="form-control"
                                           style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);color:#fff;border-radius:10px;padding:10px 14px;font-size:0.92rem;"
                                           placeholder="Nama klien atau event..." required>
                                </div>
                                <div class="col-md-5">
                                    <label class="d-flex align-items-center gap-2 mb-2" style="font-size:0.78rem;font-weight:600;text-transform:uppercase;letter-spacing:0.8px;color:rgba(255,255,255,0.55);">
                                        <i class="fas fa-calendar-day" style="color:var(--primary-green);font-size:0.72rem;"></i> Tanggal Loading
                                    </label>
                                    <input type="date" id="m_tanggal" name="tanggal_loading"
                                           class="form-control"
                                           style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);color:#fff;border-radius:10px;padding:10px 14px;font-size:0.92rem;"
                                           value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="d-flex align-items-center gap-2 mb-2" style="font-size:0.78rem;font-weight:600;text-transform:uppercase;letter-spacing:0.8px;color:rgba(255,255,255,0.55);">
                                    <i class="fas fa-hard-hat" style="color:var(--primary-green);font-size:0.72rem;"></i> Crew Chief / Penanggung Jawab
                                </label>
                                <input type="text" id="m_crew" name="crew_chief"
                                       class="form-control"
                                       style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);color:#fff;border-radius:10px;padding:10px 14px;font-size:0.92rem;"
                                       placeholder="Nama crew chief..." required>
                            </div>

                            <div style="border-top:1px dashed rgba(16,185,129,0.2);padding-top:1rem;margin-top:0.5rem;">
                                <label class="d-flex align-items-center gap-2 mb-2" style="font-size:0.78rem;font-weight:600;text-transform:uppercase;letter-spacing:0.8px;color:rgba(255,255,255,0.55);">
                                    <i class="fas fa-sticky-note" style="color:var(--primary-green);font-size:0.72rem;"></i> Catatan Khusus
                                </label>
                                <textarea id="m_catatan" name="catatan"
                                          class="form-control"
                                          style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);color:#fff;border-radius:10px;padding:12px 14px;font-size:0.9rem;resize:vertical;min-height:120px;"
                                          placeholder="Instruksi atau catatan khusus untuk surat jalan ini..."></textarea>
                                <p class="mt-2 mb-0" style="font-size:0.75rem;color:rgba(255,255,255,0.3);">
                                    <i class="fas fa-info-circle me-1"></i>Catatan ini akan tampil di bagian bawah surat jalan.
                                </p>
                            </div>
                        </div>

                        {{-- ─── PANEL 2: ALAT INVENTARIS ───────────────────────────────────── --}}
                        <div class="tab-pane fade" id="tab-inventaris" role="tabpanel">
                            {{-- Alert stok melebihi --}}
                            <div id="manifestStockAlert" class="d-none mb-3 p-3 rounded-3 d-flex align-items-start gap-3"
                                 style="background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.25);" role="alert">
                                <i class="fas fa-exclamation-triangle mt-1" style="color:#f87171;font-size:0.9rem;flex-shrink:0;"></i>
                                <div style="font-size:0.85rem;color:#fca5a5;">
                                    <strong style="color:#f87171;">Perhatian:</strong>
                                    Terdapat item dengan jumlah melebihi stok tersedia. Sesuaikan kuantitas sebelum menerbitkan manifes.
                                </div>
                            </div>

                            {{-- Search & Filter --}}
                            <div class="mb-3 p-3 rounded-3" style="background:rgba(16,185,129,0.04);border:1px solid rgba(16,185,129,0.14);">
                                <div class="d-flex gap-2 flex-wrap">
                                    <div class="position-relative flex-grow-1" style="min-width:180px;">
                                        <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3" style="color:rgba(16,185,129,0.5);font-size:0.75rem;pointer-events:none;"></i>
                                        <input type="text" id="inventorySearchFilter"
                                               class="form-control form-control-sm ps-5"
                                               placeholder="Cari nama alat..."
                                               style="background:rgba(255,255,255,0.05);border:1px solid rgba(16,185,129,0.18);color:#fff;border-radius:8px;font-size:0.85rem;"
                                               oninput="filterInventoryOptions(this.value, document.getElementById('categoryFilterSelect').value)">
                                    </div>
                                    <select id="categoryFilterSelect" class="form-select form-select-sm"
                                            style="max-width:150px;background:rgba(255,255,255,0.05);border:1px solid rgba(16,185,129,0.18);color:#fff;border-radius:8px;font-size:0.85rem;"
                                            onchange="filterInventoryOptions(document.getElementById('inventorySearchFilter').value, this.value)">
                                        <option value="" style="background:#111;">Semua Kategori</option>
                                        @foreach($inventories->pluck('kategori')->unique()->sort() as $kat)
                                        <option value="{{ $kat }}" style="background:#111;color:#fff;">{{ $kat }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-sm px-3"
                                            style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:rgba(255,255,255,0.45);border-radius:8px;font-size:0.82rem;white-space:nowrap;"
                                            onclick="document.getElementById('inventorySearchFilter').value=''; document.getElementById('categoryFilterSelect').value=''; filterInventoryOptions('','');">
                                        <i class="fas fa-times me-1"></i>Reset
                                    </button>
                                </div>
                                <div class="mt-2" id="filterResultInfo" style="font-size:0.7rem;color:rgba(16,185,129,0.6);"></div>
                            </div>

                            {{-- Item Rows Area --}}
                            <div id="manifestItemArea" class="d-flex flex-column gap-2">
                                <div class="item-row rounded-3 p-3"
                                     style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);">
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <div class="flex-grow-1" style="min-width:200px;">
                                            <select name="inventory_ids[]"
                                                    class="form-select form-select-sm select-inventory"
                                                    style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:#fff;border-radius:8px;font-size:0.85rem;padding:8px 12px;">
                                                <option value="">— Pilih Alat —</option>
                                                @foreach($inventories as $inv)
                                                <option value="{{ $inv->id }}"
                                                        data-kategori="{{ $inv->kategori }}"
                                                        data-nama="{{ strtolower($inv->nama_alat) }}"
                                                        data-stok="{{ $inv->stok_tersedia }}"
                                                        style="background:#111;color:#fff;">
                                                    {{ $inv->nama_alat }} ({{ $inv->kategori }})
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="stock-badge px-2 py-1 rounded-2"
                                                  style="font-size:0.72rem;font-weight:600;background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.4);border:1px solid rgba(255,255,255,0.1);white-space:nowrap;min-width:70px;text-align:center;">
                                                Stok: —
                                            </span>
                                            <input type="number" name="quantities[]"
                                                   class="form-control form-control-sm text-center"
                                                   min="1" value="1"
                                                   style="width:70px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:#fff;border-radius:8px;font-size:0.88rem;">
                                            <button type="button" class="btn btn-sm remove-row"
                                                    title="Hapus baris"
                                                    style="width:30px;height:30px;padding:0;border-radius:8px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#f87171;display:flex;align-items:center;justify-content:center;">
                                                <i class="fas fa-trash-alt" style="font-size:0.7rem;"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback row-error d-none mt-2" style="font-size:0.78rem;"></div>
                                </div>
                            </div>

                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                <p class="mb-0" style="font-size:0.78rem;color:rgba(255,255,255,0.3);">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Tambah inventaris terlebih dahulu sebelum menggunakan tab Alat Tambahan.
                                </p>
                                <button type="button" id="addMoreItems"
                                        class="btn btn-sm d-flex align-items-center gap-2"
                                        style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.25);color:var(--primary-green);border-radius:8px;font-size:0.82rem;padding:6px 14px;white-space:nowrap;">
                                    <i class="fas fa-plus" style="font-size:0.7rem;"></i> Tambah Baris
                                </button>
                            </div>
                        </div>

                        {{-- ─── PANEL 3: ALAT TAMBAHAN / LUAR ─────────────────────────────── --}}
                        <div class="tab-pane fade" id="tab-luar" role="tabpanel">
                            <div class="mb-3 p-3 rounded-3" style="background:rgba(245,158,11,0.05);border:1px solid rgba(245,158,11,0.15);">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-box-open" style="color:#fbbf24;font-size:0.85rem;"></i>
                                    <div>
                                        <p class="mb-0 fw-semibold" style="font-size:0.83rem;color:#fde68a;">Alat Tambahan / Luar (Manual)</p>
                                        <small style="color:rgba(255,255,255,0.35);font-size:0.72rem;">Item yang tidak tercatat di inventaris gudang. Tidak mempengaruhi stok.</small>
                                    </div>
                                </div>
                            </div>

                            <div id="manualItemArea" class="d-flex flex-column gap-2">
                                <div class="manual-row rounded-3 p-3"
                                     style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);">
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="text" name="manual_names[]"
                                               class="form-control form-control-sm flex-grow-1"
                                               placeholder="Nama barang (cth: Lakban, Tali, dll)"
                                               style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:#fff;border-radius:8px;font-size:0.85rem;padding:8px 12px;">
                                        <input type="number" name="manual_qtys[]"
                                               class="form-control form-control-sm text-center"
                                               min="1" value="1"
                                               style="width:70px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:#fff;border-radius:8px;font-size:0.88rem;">
                                        <button type="button" class="btn btn-sm remove-manual-row"
                                                title="Hapus baris"
                                                style="width:30px;height:30px;padding:0;border-radius:8px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#f87171;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                            <i class="fas fa-trash-alt" style="font-size:0.7rem;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 d-flex justify-content-end">
                                <button type="button" id="addMoreManual"
                                        class="btn btn-sm d-flex align-items-center gap-2"
                                        style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.25);color:#fbbf24;border-radius:8px;font-size:0.82rem;padding:6px 14px;">
                                    <i class="fas fa-plus" style="font-size:0.7rem;"></i> Tambah Item
                                </button>
                            </div>
                        </div>

                    </div>

                    {{-- === FOOTER === --}}
                    <div class="px-4 pb-4 pt-0">
                        <div style="border-top:1px solid rgba(255,255,255,0.06);padding-top:1rem;">
                            <button type="submit" id="btnSubmitManifes"
                                    class="btn w-100 py-3 fw-bold"
                                    style="background:linear-gradient(135deg,#10b981,#059669);color:#000;border:none;border-radius:12px;font-size:0.92rem;letter-spacing:1px;box-shadow:0 8px 24px rgba(16,185,129,0.3);transition:all 0.3s ease;"
                                    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 14px 32px rgba(16,185,129,0.45)';"
                                    onmouseout="this.style.transform='';this.style.boxShadow='0 8px 24px rgba(16,185,129,0.3)';">
                                <i class="fas fa-paper-plane me-2"></i>
                                TERBITKAN & SINKRONKAN STOK
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalTambahVendor" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><form action="/admin/vendor" method="POST">@csrf<div class="modal-header"><h5 class="modal-title text-hos">Tambah Vendor</h5></div><div class="modal-body"><div class="mb-3"><label>Nama Vendor</label><input type="text" name="nama_vendor" class="form-control" required></div><div class="mb-3"><label>Kategori</label><input type="text" name="kategori_layanan" class="form-control" required></div><div class="mb-3"><label>No. Telp</label><input type="text" name="nomor_telepon" class="form-control"></div></div><div class="modal-footer border-0"><button class="btn btn-hos w-100 py-3">SIMPAN DATA VENDOR</button></div></form></div></div></div>

    <!-- MODAL PREVIEW ASET INVENTARIS -->
    <div class="modal fade" id="modalPreviewAset" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-2xl" style="background: rgba(15, 15, 18, 0.98); backdrop-filter: blur(25px); border-radius: 20px; border: 1px solid rgba(16, 185, 129, 0.25);">
                <div class="modal-header border-bottom border-secondary-subtle p-4">
                    <h5 class="modal-title fw-bold text-white font-outfit"><i class="fas fa-boxes me-2" style="color: var(--accent-green);"></i>Detail & Tinjau Aset</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <img id="previewAsetFoto" src="" style="max-width: 100%; max-height: 250px; object-fit: cover; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); display: none;">
                        <div id="previewAsetPlaceholder" class="mx-auto" style="width: 120px; height: 120px; background: rgba(255,255,255,0.05); border-radius: 12px; display: flex; align-items:center; justify-content:center; border: 1px dashed rgba(255,255,255,0.15);"><i class="fas fa-box text-white-50 fa-3x"></i></div>
                    </div>
                    <div class="table-responsive border-0">
                        <table class="table table-dark table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-white-50 py-2" style="width: 35%; font-size: 0.88rem;">Nama Aset</td>
                                    <td id="previewAsetNama" class="text-white fw-bold py-2" style="font-size: 0.88rem;">-</td>
                                </tr>
                                <tr>
                                    <td class="text-white-50 py-2" style="font-size: 0.88rem;">Kategori</td>
                                    <td class="py-2"><span id="previewAsetKategori" class="badge" style="background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.85); border: 1px solid rgba(255,255,255,0.15); font-size: 0.75rem; padding: 4px 8px; font-weight: 500;">-</span></td>
                                </tr>
                                <tr>
                                    <td class="text-white-50 py-2" style="font-size: 0.88rem;">Stok Tersedia</td>
                                    <td class="py-2"><span id="previewAsetStok" class="badge bg-success" style="font-size: 0.75rem;">-</span></td>
                                </tr>
                                <tr>
                                    <td class="text-white-50 py-2" style="font-size: 0.88rem;">Kondisi</td>
                                    <td class="py-2"><span id="previewAsetKondisi" class="badge bg-info" style="font-size: 0.75rem;">-</span></td>
                                </tr>
                                <tr>
                                    <td class="text-white-50 py-2" style="font-size: 0.88rem;">Deskripsi</td>
                                    <td id="previewAsetDeskripsi" class="text-white-50 py-2" style="font-size: 0.85rem; line-height: 1.5; white-space: pre-line;">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary-subtle p-3 bg-black bg-opacity-20 d-flex gap-2">
                    <form id="previewAsetApproveForm" action="" method="POST" class="m-0 flex-fill">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold text-white"><i class="fas fa-check me-1"></i> Setujui Aset</button>
                    </form>
                    <button type="button" class="btn btn-danger flex-fill py-2 fw-bold text-white" onclick="bukaModalTolak(document.getElementById('previewAsetRejectForm').action, 'aset')"><i class="fas fa-times me-1"></i> Tolak Aset</button>
                    <form id="previewAsetRejectForm" action="" method="POST" class="d-none">@csrf</form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PREVIEW ALBUM EVENT -->
    <div class="modal fade" id="modalPreviewAlbum" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-2xl" style="background: rgba(15, 15, 18, 0.98); backdrop-filter: blur(25px); border-radius: 20px; border: 1px solid rgba(16, 185, 129, 0.25);">
                <div class="modal-header border-bottom border-secondary-subtle p-4">
                    <h5 class="modal-title fw-bold text-white font-outfit"><i class="fas fa-camera-retro me-2" style="color: var(--accent-green);"></i>Detail & Tinjau Album Event</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="max-height: calc(100vh - 220px); overflow-y: auto;">
                    <div class="row g-4">
                        <div class="col-12 col-md-5 text-center">
                            <img id="previewAlbumCover" src="" style="width: 100%; max-height: 250px; object-fit: cover; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); display: none;">
                            <div id="previewAlbumPlaceholder" class="mx-auto" style="width: 120px; height: 120px; background: rgba(255,255,255,0.05); border-radius: 12px; display: flex; align-items:center; justify-content:center; border: 1px dashed rgba(255,255,255,0.15);"><i class="fas fa-image text-white-50 fa-3x"></i></div>
                        </div>
                        <div class="col-12 col-md-7">
                            <h4 id="previewAlbumJudul" class="fw-bold text-white font-outfit mb-2">-</h4>
                            <p class="text-white-50 mb-3" style="font-size: 0.85rem;"><i class="far fa-calendar-alt me-1" style="color: var(--accent-green);"></i><span id="previewAlbumTanggal">-</span></p>
                            <h6 class="text-white fw-bold mb-1" style="font-size: 0.88rem;">Deskripsi Event:</h6>
                            <p id="previewAlbumDeskripsi" class="text-white-50" style="font-size: 0.85rem; line-height: 1.5; white-space: pre-line;">-</p>
                        </div>
                    </div>
                    
                    <hr class="border-secondary-subtle my-4">
                    
                    <h6 class="text-white fw-bold mb-3 font-outfit"><i class="fas fa-images me-2" style="color: var(--accent-green);"></i>File Galeri yang Diupload Staff:</h6>
                    <div id="previewAlbumGalleryContainer" class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3">
                        <!-- Dynamic galleries from JS -->
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary-subtle p-3 bg-black bg-opacity-20 d-flex gap-2">
                    <form id="previewAlbumApproveForm" action="" method="POST" class="m-0 flex-fill">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold text-white"><i class="fas fa-check me-1"></i> Setujui Album</button>
                    </form>
                    <button type="button" class="btn btn-danger flex-fill py-2 fw-bold text-white" onclick="bukaModalTolak(document.getElementById('previewAlbumRejectForm').action, 'album')"><i class="fas fa-times me-1"></i> Tolak Album</button>
                    <form id="previewAlbumRejectForm" action="" method="POST" class="d-none">@csrf</form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ALASAN PENOLAKAN (SESUAI ACTIVITY DIAGRAM) -->
    <div class="modal fade" id="modalTolakPersetujuan" tabindex="-1" aria-hidden="true" style="z-index: 10050;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-2xl" style="background: rgba(15, 15, 18, 0.98); backdrop-filter: blur(25px); border-radius: 20px; border: 1px solid rgba(239, 68, 68, 0.35);">
                <div class="modal-header border-bottom border-secondary-subtle p-4">
                    <h5 class="modal-title fw-bold text-white font-outfit"><i class="fas fa-exclamation-circle me-2 text-danger"></i>Alasan Penolakan Konten</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formModalTolak" action="" method="POST" onsubmit="return validasiAlasanPenolakan(this)">
                    @csrf
                    <div class="modal-body p-4">
                        <p class="text-white-50 small mb-3">Mohon berikan alasan/catatan penolakan untuk konten ini. Alasan ini wajib diisi sebelum menyimpan penolakan.</p>
                        <div class="mb-3">
                            <label class="form-label text-white small fw-bold">Catatan / Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea name="catatan_penolakan" id="inputCatatanPenolakan" class="form-control" rows="4" placeholder="Tuliskan alasan penolakan (cth: Foto buram, deskripsi kurang lengkap, dll)..." required style="background: rgba(255,255,255,0.05); color:#fff; border-color: rgba(255,255,255,0.15); border-radius: 10px;"></textarea>
                            <div id="errorCatatanPenolakan" class="invalid-feedback d-none text-danger mt-1 small"><i class="fas fa-exclamation-triangle me-1"></i>Wajib mengisikan alasan penolakan!</div>
                        </div>
                    </div>
                    <div class="modal-footer border-top border-secondary-subtle p-3 bg-black bg-opacity-20 d-flex gap-2">
                        <button type="button" class="btn btn-secondary flex-fill" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger flex-fill fw-bold"><i class="fas fa-paper-plane me-1"></i> Simpan Penolakan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('partials.scripts')
    <script>
        let listGaleri = [];
        let indexAktif = 0;

        function initGaleriAdmin(el) {
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
                let html = `<div class="col-md-6 mb-2">`;
                if(isVideo) {
                    html += `<video controls style="width:100%; border-radius:12px; border: 1px solid rgba(16,185,129,0.3);"><source src="/${item.file_path}"></video>`;
                } else {
                    html += `<img src="/${item.file_path}" class="img-fluid rounded-4 shadow-sm" style="border: 1px solid rgba(16,185,129,0.2); width:100%; height:200px; object-fit: cover; cursor: zoom-in;" onclick="zoomFoto(${index})">`;
                }
                html += `</div>`;
                content.innerHTML += html;
            });

            new bootstrap.Modal(document.getElementById('modalPublik')).show();
        }

        function zoomFoto(index) {
            indexAktif = index;
            const item = listGaleri[indexAktif];
            if(item.file_type === 'video') return;
            
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
                    indexAktif = tempIndex; found = true; break;
                }
            }
            if(found) document.getElementById('zoomImg').src = '/' + listGaleri[indexAktif].file_path;
        }

        function prevFoto() {
            let found = false;
            let tempIndex = indexAktif;
            while(tempIndex > 0) {
                tempIndex--;
                if(listGaleri[tempIndex].file_type !== 'video') {
                    indexAktif = tempIndex; found = true; break;
                }
            }
            if(found) document.getElementById('zoomImg').src = '/' + listGaleri[indexAktif].file_path;
        }

        // Keyboard Listener untuk Admin Lightbox
        document.addEventListener('keydown', function(e) {
            const zoomModal = document.getElementById('modalZoom');
            if (zoomModal && zoomModal.classList.contains('show')) {
                if (e.key === 'ArrowRight') nextFoto();
                if (e.key === 'ArrowLeft') prevFoto();
            }
        });

        // Search & Kategori Filter Konten di Dashboard
        const searchInput = document.getElementById('inventarisSearch');
        const kategoriFilter = document.getElementById('inventarisKategoriFilter');
        
        function applyInventarisFilter() {
            const searchVal = searchInput ? searchInput.value.toLowerCase() : '';
            const katVal = kategoriFilter ? kategoriFilter.value : 'all';
            
            const rows = document.querySelectorAll('#tableInventaris tbody tr');
            rows.forEach(row => {
                const namaCell = row.cells[1] ? row.cells[1].innerText.toLowerCase() : '';
                const katCell = row.cells[2] ? row.cells[2].innerText : '';
                
                const matchesSearch = namaCell.includes(searchVal);
                const matchesKat = (katVal === 'all' || katCell === katVal);
                
                if (matchesSearch && matchesKat) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        if(searchInput) searchInput.addEventListener('input', applyInventarisFilter);
        if(kategoriFilter) kategoriFilter.addEventListener('change', applyInventarisFilter);

        function editAset(btn) {
            const data = JSON.parse(btn.getAttribute('data-aset'));
            document.getElementById('edit_nama_alat').value = data.nama_alat;
            document.getElementById('edit_kategori').value = data.kategori;
            document.getElementById('edit_stok').value = data.stok_tersedia;
            document.getElementById('edit_kondisi_alat').value = data.kondisi_alat || 'Baik';
            document.getElementById('formEditAset').action = "/admin/aset/update/" + data.id;
            
            const preview = document.getElementById('edit_foto_preview');
            const img = document.getElementById('img_preview');
            if (data.foto_alat && data.foto_alat !== '-') {
                preview.style.display = 'block';
                img.src = "/" + data.foto_alat;
            } else {
                preview.style.display = 'none';
            }
            
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditAset')).show();
        }

        function editAlbum(btn) {
            const data = JSON.parse(btn.getAttribute('data-album'));
            document.getElementById('edit_judul_event').value = data.judul_event;
            document.getElementById('edit_tanggal_event').value = data.tanggal_event;
            document.getElementById('edit_tanggal_selesai').value = data.tanggal_selesai || '';
            document.getElementById('edit_deskripsi_event').value = data.deskripsi_event || '';
            document.getElementById('formEditAlbum').action = "/admin/album/update/" + data.id;

            // Show current cover
            const coverImg = document.getElementById('edit_cover_img');
            const coverPreview = document.getElementById('edit_cover_preview');
            if (data.cover_album && data.cover_album !== '-') {
                coverImg.src = '/' + data.cover_album;
                coverPreview.style.display = 'block';
            } else if (data.galleries && data.galleries.length > 0) {
                const firstImg = data.galleries.find(g => g.file_type !== 'video');
                if (firstImg) { coverImg.src = '/' + firstImg.file_path; coverPreview.style.display = 'block'; }
                else { coverPreview.style.display = 'none'; }
            } else {
                coverPreview.style.display = 'none';
            }

            // Reset file input
            document.getElementById('edit_cover_input').value = '';
            const filesContainer = document.getElementById('editAlbumFilesContainer');
            filesContainer.innerHTML = "";
            if (data.galleries && data.galleries.length > 0) {
                data.galleries.forEach(g => {
                    const col = document.createElement('div');
                    col.className = 'col-4 position-relative text-center mb-2 gallery-thumb-container';
                    col.id = `gallery-item-${g.id}`;
                    
                    let previewHtml = "";
                    if (g.file_type === 'video') {
                        previewHtml = `<div class="d-flex align-items-center justify-content-center bg-dark text-white rounded" style="height: 80px;"><i class="fas fa-video fa-2x"></i></div>`;
                    } else {
                        previewHtml = `<img src="/${g.file_path}" class="w-100 rounded object-fit-cover" style="height: 80px; object-fit: cover;">`;
                    }
                    
                    col.innerHTML = `
                        ${previewHtml}
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 p-0 m-1 rounded-circle d-flex align-items-center justify-content-center" onclick="deleteGalleryItem(${g.id})" style="width: 22px; height: 22px; font-size: 10px;">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                    filesContainer.appendChild(col);
                });
            } else {
                filesContainer.innerHTML = "<div class='col-12 text-center py-4 text-muted'>Belum ada dokumentasi.</div>";
            }

            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditAlbum')).show();
        }

        function deleteGalleryItem(id) {
            if (confirm("Hapus file dokumentasi ini secara permanen?")) {
                const csrfToken = document.querySelector('input[name="_token"]').value;
                fetch(`/admin/gallery/delete/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const el = document.getElementById(`gallery-item-${id}`);
                        if (el) {
                            el.style.transition = "all 0.3s";
                            el.style.opacity = 0;
                            el.style.transform = "scale(0.8)";
                            setTimeout(() => el.remove(), 300);
                        }
                    } else {
                        alert("Gagal menghapus file: " + data.message);
                    }
                })
                .catch(err => {
                    console.error("Error deleting file:", err);
                    alert("Terjadi kesalahan sistem saat menghapus file.");
                });
            }
        }

        function previewTambahCover(input) {
            const preview = document.getElementById('tambah_cover_preview');
            const img = document.getElementById('tambah_cover_img');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => { img.src = e.target.result; preview.style.display = 'block'; };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }

        function previewEditCover(input) {
            const coverImg = document.getElementById('edit_cover_img');
            const coverPreview = document.getElementById('edit_cover_preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => { coverImg.src = e.target.result; coverPreview.style.display = 'block'; };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function lihatAlbum(judul, galleriesJson) {
            // Deprecated - Replaced by initGaleriAdmin
        }

        // --- XHR Upload: TAMBAH ALBUM (dengan progress) ---
        const uploadForm = document.getElementById('uploadForm');
        if(uploadForm) {
            uploadForm.onsubmit = function(e) {
                e.preventDefault();
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengunggah...';
                const progressContainer = document.getElementById('progressContainer');
                progressContainer.style.display = 'block';
                const xhr = new XMLHttpRequest();
                xhr.upload.addEventListener('progress', e => {
                    if (e.lengthComputable) {
                        const percent = Math.round((e.loaded / e.total) * 100);
                        document.getElementById('progressBar').style.width = percent + '%';
                        document.getElementById('percentText').innerText = percent + '%';
                    }
                });
                xhr.onreadystatechange = () => {
                    if (xhr.readyState == 4) {
                        if (xhr.status >= 200 && xhr.status < 400) {
                            window.location.href = '/dashboard';
                        } else {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="fas fa-upload me-2"></i>UNGGAH ALBUM & FILE';
                            progressContainer.style.display = 'none';
                            alert('Gagal upload. Coba lagi atau kurangi ukuran file.');
                        }
                    }
                };
                xhr.open('POST', '/admin/album', true);
                xhr.send(new FormData(this));
            };
        }

        // --- XHR Upload: EDIT ALBUM (dengan progress) ---
        const editForm = document.getElementById('formEditAlbum');
        if (editForm) {
            editForm.onsubmit = function(e) {
                e.preventDefault();
                const editBtn = document.getElementById('editSubmitBtn');
                const editProgress = document.getElementById('editProgressContainer');
                const editBar = document.getElementById('editProgressBar');
                const editPercent = document.getElementById('editPercentText');

                editBtn.disabled = true;
                editBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                editProgress.style.display = 'block';

                const xhr = new XMLHttpRequest();
                xhr.upload.addEventListener('progress', ev => {
                    if (ev.lengthComputable) {
                        const pct = Math.round((ev.loaded / ev.total) * 100);
                        editBar.style.width = pct + '%';
                        editPercent.innerText = pct + '%';
                    }
                });
                xhr.onreadystatechange = () => {
                    if (xhr.readyState == 4) {
                        if (xhr.status >= 200 && xhr.status < 400) {
                            window.location.href = '/dashboard';
                        } else {
                            editBtn.disabled = false;
                            editBtn.innerHTML = '<i class="fas fa-save me-2"></i>SIMPAN PERUBAHAN ALBUM';
                            editProgress.style.display = 'none';
                            alert('Gagal menyimpan. Coba lagi atau periksa ukuran file (maks ~10MB per file).');
                        }
                    }
                };
                xhr.open('POST', editForm.action, true);
                xhr.send(new FormData(editForm));
            };
        }

        function editManifes(btn) {
            const data = JSON.parse(btn.getAttribute('data-manifes'));
            document.getElementById('manifestModalTitle').innerText = "Edit Manifes: " + data.nomor_manifes;
            document.getElementById('m_klien').value = data.klien_event;
            document.getElementById('m_tanggal').value = data.tanggal_loading;
            document.getElementById('m_crew').value = data.crew_chief;
            document.getElementById('m_catatan').value = data.catatan || "";
            document.getElementById('formManifes').action = "/admin/manifes/update/" + data.id;
            document.getElementById('btnSubmitManifes').innerText = "Simpan Perubahan & Sinkronkan Stok";

            // Populate Inventaris items
            const area = document.getElementById('manifestItemArea');
            const baseRow = area.querySelector('.item-row').cloneNode(true);
            area.innerHTML = "";
            if(data.items && data.items.length > 0) {
                data.items.forEach(item => {
                    const row = baseRow.cloneNode(true);
                    row.querySelector('select').value = item.inventory_id;
                    row.querySelector('input').value = item.qty;
                    area.appendChild(row);
                });
            } else {
                area.appendChild(baseRow);
            }

            // Populate Manual/Additional items
            const manualArea = document.getElementById('manualItemArea');
            const baseManual = manualArea.querySelector('.manual-row').cloneNode(true);
            manualArea.innerHTML = "";
            if(data.additional_items && data.additional_items.length > 0) {
                data.additional_items.forEach(item => {
                    const row = baseManual.cloneNode(true);
                    row.querySelector('input[type="text"]').value = item.name;
                    row.querySelector('input[type="number"]').value = item.qty;
                    manualArea.appendChild(row);
                });
            } else {
                manualArea.appendChild(baseManual);
            }

            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalTambahManifes')).show();
            // Default to first tab on edit
            const firstTab = document.querySelector('[data-bs-target="#tab-info"]');
            bootstrap.Tab.getOrCreateInstance(firstTab).show();
        }

        // Reset modal on + Buat Manifes click
        document.querySelector('[data-bs-target="#modalTambahManifes"]').addEventListener('click', function() {
            document.getElementById('manifestModalTitle').innerText = "Manifes Baru";
            document.getElementById('formManifes').reset();
            document.getElementById('formManifes').action = "/admin/manifes";
            document.getElementById('btnSubmitManifes').innerText = "Terbitkan Manifes & Kurangi Stok";
            
            // Default to first tab
            const firstTab = document.querySelector('[data-bs-target="#tab-info"]');
            bootstrap.Tab.getOrCreateInstance(firstTab).show();

            // Reset inventaris rows
            const area = document.getElementById('manifestItemArea');
            const rows = area.querySelectorAll('.item-row');
            while(rows.length > 1) rows[1].remove(); 

            // Reset manual rows
            const manualArea = document.getElementById('manualItemArea');
            const mrows = manualArea.querySelectorAll('.manual-row');
            while(mrows.length > 1) mrows[1].remove();
            validateManifestRows();
        });

        // Dynamic Manifest Items
        document.getElementById('addMoreItems').addEventListener('click', function() {
            const area = document.getElementById('manifestItemArea');
            const newRow = area.querySelector('.item-row').cloneNode(true);
            newRow.querySelector('select').value = "";
            newRow.querySelector('input').value = "1";
            area.appendChild(newRow);
            validateManifestRows();
        });

        document.getElementById('addMoreManual').addEventListener('click', function() {
            const area = document.getElementById('manualItemArea');
            const newRow = area.querySelector('.manual-row').cloneNode(true);
            newRow.querySelector('input[type="text"]').value = "";
            newRow.querySelector('input[type="number"]').value = "1";
            area.appendChild(newRow);
        });

        document.addEventListener('click', function(e) {
            if(e.target.closest('.remove-row')) {
                const rows = document.querySelectorAll('.item-row');
                if(rows.length > 1) e.target.closest('.item-row').remove();
            }
            if(e.target.closest('.remove-manual-row')) {
                const rows = document.querySelectorAll('.manual-row');
                if(rows.length > 1) e.target.closest('.manual-row').remove();
            }
        });

        // Tab Persistence logic (simple)
        @if($errors->any())
            // If error happens, likely from Manifest form
            const manifestTab = document.querySelector('[data-bs-target="#v-pills-manifes"]');
            if(manifestTab) bootstrap.Tab.getOrCreateInstance(manifestTab).show();
        @endif

        @if(session('success'))
            // If success, check message content to decide tab
            const msg = "{{ session('success') }}".toLowerCase();
            if(msg.includes('disetujui') || msg.includes('ditolak') || msg.includes('persetujuan')) {
                const approvalTab = document.querySelector('[data-bs-target="#v-pills-approval"]');
                if(approvalTab) bootstrap.Tab.getOrCreateInstance(approvalTab).show();
            } else if(msg.includes('manifes')) {
                const manifestTab = document.querySelector('[data-bs-target="#v-pills-manifes"]');
                if(manifestTab) bootstrap.Tab.getOrCreateInstance(manifestTab).show();
            } else if(msg.includes('aset')) {
                const asetTab = document.querySelector('[data-bs-target="#v-pills-inventaris"]');
                if(asetTab) bootstrap.Tab.getOrCreateInstance(asetTab).show();
            } else if(msg.includes('vendor')) {
                const vendorTab = document.querySelector('[data-bs-target="#v-pills-vendor"]');
                if(vendorTab) bootstrap.Tab.getOrCreateInstance(vendorTab).show();
            }
        @endif
    </script>
    <script>
        function switchTab(tabId) {
            const triggerEl = document.querySelector(`button[data-bs-target="#${tabId}"]`);
            if (triggerEl) {
                bootstrap.Tab.getInstance(triggerEl)?.show() || new bootstrap.Tab(triggerEl).show();
            }
        }

        function toggleUserActionPanel(userId) {
            const panel = document.getElementById('mobile-user-actions-' + userId);
            if (!panel) return;

            document.querySelectorAll('[id^="mobile-user-actions-"]').forEach(otherPanel => {
                if (otherPanel !== panel) {
                    const instance = bootstrap.Collapse.getInstance(otherPanel);
                    if (instance && otherPanel.classList.contains('show')) {
                        instance.hide();
                    }
                }
            });

            const instance = bootstrap.Collapse.getOrCreateInstance(panel);
            instance.toggle();
        }

        function toggleUserForm(userId, formType) {
            const forms = ['uname', 'email', 'pwd'];
            forms.forEach(f => {
                document.querySelectorAll(`[id^="${f}-form-${userId}"]`).forEach(el => {
                    if (f !== formType) {
                        el.classList.add('d-none');
                    }
                });
            });

            const targetEls = document.querySelectorAll(`[id^="${formType}-form-${userId}"]`);
            targetEls.forEach(el => {
                el.classList.toggle('d-none');
                if (!el.classList.contains('d-none')) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });

            const actionPanel = document.getElementById('mobile-user-actions-' + userId);
            if (actionPanel && actionPanel.classList.contains('show')) {
                const panelInstance = bootstrap.Collapse.getInstance(actionPanel);
                if (panelInstance) {
                    panelInstance.hide();
                }
            }
        }

        /**
         * Filter semua dropdown select-inventory di dalam modal manifes
         * berdasarkan teks pencarian dan/atau kategori yang dipilih.
         */
        function filterInventoryOptions(searchText, categoryValue) {
            const text   = searchText.trim().toLowerCase();
            const cat    = categoryValue.trim().toLowerCase();
            const selects = document.querySelectorAll('#manifestItemArea .select-inventory');

            selects.forEach(select => {
                let visibleCount = 0;
                const options = select.querySelectorAll('option');
                options.forEach(opt => {
                    if (!opt.value) { opt.style.display = ''; return; } // placeholder selalu tampil
                    const nama  = (opt.dataset.nama    || '').toLowerCase();
                    const kOpt  = (opt.dataset.kategori || '').toLowerCase();
                    const matchText = !text || nama.includes(text);
                    const matchCat  = !cat  || kOpt === cat;
                    if (matchText && matchCat) {
                        opt.style.display = '';
                        visibleCount++;
                    } else {
                        opt.style.display = 'none';
                    }
                });

                // Jika pilihan yang sedang dipilih tersembunyi, reset ke placeholder
                const selected = select.options[select.selectedIndex];
                if (selected && selected.style.display === 'none') {
                    select.value = '';
                }

                // Update info counter
                const infoEl = document.getElementById('filterResultInfo');
                if (infoEl) {
                    if (text || cat) {
                        infoEl.textContent = `${visibleCount} alat ditemukan`;
                    } else {
                        infoEl.textContent = '';
                    }
                }
            });
        }

        // Reset filter saat modal dibuka ulang
        document.getElementById('modalTambahManifes').addEventListener('show.bs.modal', function() {
            const searchEl = document.getElementById('inventorySearchFilter');
            const catEl    = document.getElementById('categoryFilterSelect');
            if (searchEl) searchEl.value = '';
            if (catEl)    catEl.value    = '';
            filterInventoryOptions('', '');
            validateManifestRows();
        });

        function validateManifestRows() {
            const rows = document.querySelectorAll('#manifestItemArea .item-row');
            let hasError = false;
            const selectedIds = {};
            rows.forEach(row => {
                const select = row.querySelector('select[name="inventory_ids[]"]');
                const qtyInput = row.querySelector('input[name="quantities[]"]');
                const stockInfo = row.querySelector('.stock-badge') || row.querySelector('.stock-info');
                const rowError = row.querySelector('.row-error');
                const selectedId = select ? select.value : '';
                const qty = Number(qtyInput ? qtyInput.value : 0);
                let errorText = '';
                let availableStock = 0;

                if (selectedId) {
                    availableStock = Number(select.selectedOptions[0]?.dataset?.stok || 0);
                    if (stockInfo && stockInfo.classList.contains('stock-badge')) {
                        stockInfo.textContent = availableStock ? `Stok: ${availableStock}` : 'Stok: -';
                    } else {
                        stockInfo.textContent = availableStock ? `Stok tersedia: ${availableStock} unit` : 'Stok tidak tersedia.';
                    }
                    if (qty < 1) {
                        errorText = 'Qty harus diisi minimal 1.';
                    } else if (qty > availableStock) {
                        errorText = `Qty melebihi stok (max ${availableStock}).`;
                    }
                    if (selectedIds[selectedId]) {
                        errorText = 'Item sudah dipilih di baris lain.';
                    } else {
                        selectedIds[selectedId] = true;
                    }
                } else {
                    if (stockInfo && stockInfo.classList.contains('stock-badge')) {
                        stockInfo.textContent = 'Stok: -';
                    } else if (stockInfo) {
                        stockInfo.textContent = '';
                    }
                    if (qty > 0) {
                        errorText = 'Pilih alat terlebih dahulu.';
                    }
                }

                if (errorText) {
                    rowError.textContent = errorText;
                    rowError.classList.remove('d-none');
                    row.classList.add('border', 'border-danger');
                    hasError = true;
                } else {
                    rowError.textContent = '';
                    rowError.classList.add('d-none');
                    row.classList.remove('border', 'border-danger');
                }
            });

            const manifestAlert = document.getElementById('manifestStockAlert');
            const submitBtn = document.getElementById('btnSubmitManifes');
            if (manifestAlert) {
                if (hasError) {
                    manifestAlert.classList.remove('d-none');
                    manifestAlert.innerHTML = '<strong>Perhatian:</strong> Terdapat item dengan jumlah melebihi stok tersedia. Sesuaikan kuantitas sebelum menerbitkan manifes.';
                } else {
                    manifestAlert.classList.add('d-none');
                    manifestAlert.innerHTML = '';
                }
            }
            if (submitBtn) {
                submitBtn.disabled = hasError;
            }
            return !hasError;
        }

        document.getElementById('manifestItemArea').addEventListener('input', function(e) {
            if (e.target.matches('select[name="inventory_ids[]"], input[name="quantities[]"]')) {
                validateManifestRows();
            }
        });
        // Also handle change events (select uses change)
        document.getElementById('manifestItemArea').addEventListener('change', function(e) {
            if (e.target.matches('select[name="inventory_ids[]"], input[name="quantities[]"]')) {
                validateManifestRows();
            }
        });

        document.addEventListener('click', function(e) {
            if(e.target.closest('.remove-row')) {
                const rows = document.querySelectorAll('.item-row');
                if(rows.length > 1) e.target.closest('.item-row').remove();
                validateManifestRows();
            }
            if(e.target.closest('.remove-manual-row')) {
                const rows = document.querySelectorAll('.manual-row');
                if(rows.length > 1) e.target.closest('.manual-row').remove();
            }
        });

        function tinjauAset(element) {
            const aset = JSON.parse(element.getAttribute('data-aset'));
            
            // Set image
            const fotoImg = document.getElementById('previewAsetFoto');
            const placeholder = document.getElementById('previewAsetPlaceholder');
            if (aset.foto_alat && aset.foto_alat !== '-') {
                fotoImg.src = '/' + aset.foto_alat.replace(/^\//, ''); // Clean leading slash
                fotoImg.style.display = 'block';
                placeholder.style.display = 'none';
            } else {
                fotoImg.style.display = 'none';
                placeholder.style.display = 'flex';
            }
            
            // Set text details
            document.getElementById('previewAsetNama').textContent = aset.nama_alat;
            document.getElementById('previewAsetKategori').textContent = aset.kategori;
            document.getElementById('previewAsetStok').textContent = `${aset.stok_tersedia} Unit`;
            document.getElementById('previewAsetKondisi').textContent = aset.kondisi_alat || 'Baik';
            document.getElementById('previewAsetDeskripsi').textContent = aset.deskripsi_alat || 'Tidak ada deskripsi.';
            
            // Set form action URLs dynamically
            document.getElementById('previewAsetApproveForm').action = `/admin/aset/approve/${aset.id}`;
            document.getElementById('previewAsetRejectForm').action = `/admin/aset/reject/${aset.id}`;
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('modalPreviewAset'));
            modal.show();
        }

        function tinjauAlbum(element) {
            const album = JSON.parse(element.getAttribute('data-album'));
            
            // Set cover
            const coverImg = document.getElementById('previewAlbumCover');
            const placeholder = document.getElementById('previewAlbumPlaceholder');
            
            // Determine cover path
            let coverPath = null;
            if (album.cover_album && album.cover_album !== '-') {
                coverPath = '/' + album.cover_album.replace(/^\//, '');
            } else if (album.galleries && album.galleries.length > 0) {
                const firstImg = album.galleries.find(g => g.file_type === 'image');
                if (firstImg) {
                    coverPath = '/' + firstImg.file_path.replace(/^\//, '');
                }
            }
            
            if (coverPath) {
                coverImg.src = coverPath;
                coverImg.style.display = 'block';
                placeholder.style.display = 'none';
            } else {
                coverImg.style.display = 'none';
                placeholder.style.display = 'flex';
            }
            
            // Set text details
            document.getElementById('previewAlbumJudul').textContent = album.judul_event;
            
            // Formatting Date
            const eventDate = new Date(album.tanggal_event);
            const options = { day: 'numeric', month: 'short', year: 'numeric' };
            let dateString = eventDate.toLocaleDateString('id-ID', options);
            if (album.tanggal_selesai) {
                const endDate = new Date(album.tanggal_selesai);
                dateString += ` s/d ${endDate.toLocaleDateString('id-ID', options)}`;
            }
            document.getElementById('previewAlbumTanggal').textContent = dateString;
            document.getElementById('previewAlbumDeskripsi').textContent = album.deskripsi_event || 'Tidak ada deskripsi.';
            
            // Load galleries
            const container = document.getElementById('previewAlbumGalleryContainer');
            container.innerHTML = '';
            
            if (album.galleries && album.galleries.length > 0) {
                album.galleries.forEach(item => {
                    const col = document.createElement('div');
                    col.className = 'col';
                    
                    let htmlContent = '';
                    const cleanPath = '/' + item.file_path.replace(/^\//, '');
                    
                    if (item.file_type === 'image') {
                        htmlContent = `
                            <a href="${cleanPath}" target="_blank" title="Klik untuk memperbesar">
                                <img src="${cleanPath}" style="width: 100%; height: 110px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);" onerror="this.src='https://placehold.co/150?text=Gambar+Rusak';">
                            </a>
                        `;
                    } else if (item.file_type === 'video') {
                        htmlContent = `
                            <video src="${cleanPath}" controls style="width: 100%; height: 110px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
                                Browser Anda tidak mendukung video HTML5.
                            </video>
                        `;
                    }
                    col.innerHTML = htmlContent;
                    container.appendChild(col);
                });
            } else {
                container.innerHTML = '<div class="col-12 text-center text-white-50 py-3" style="font-size:0.85rem;">Tidak ada foto/video galeri di dalam album ini.</div>';
            }
            
            // Set form action URLs dynamically
            document.getElementById('previewAlbumApproveForm').action = `/admin/album/approve/${album.id}`;
            document.getElementById('previewAlbumRejectForm').action = `/admin/album/reject/${album.id}`;
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('modalPreviewAlbum'));
            modal.show();
        }
    </script>
</body>
</html>

