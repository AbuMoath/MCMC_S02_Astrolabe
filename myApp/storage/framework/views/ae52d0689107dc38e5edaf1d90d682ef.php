<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuthenticityHub — Malaysian Communications & Multimedia Commission</title>
    <meta name="description" content="AuthenticityHub is the official MCMC platform for submitting and tracking public inquiries. Secure, transparent, and efficient.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --navy: #0b1f3a;
            --navy-mid: #112d52;
            --blue: #1d5fdb;
            --blue-light: #3b82f6;
            --cyan: #06b6d4;
            --gold: #f59e0b;
            --text-primary: #e2e8f0;
            --text-secondary: #94a3b8;
            --glass-bg: rgba(255,255,255,0.06);
            --glass-border: rgba(255,255,255,0.12);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--navy);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        /* ============================
           ANIMATED BACKGROUND
        ============================ */
        .bg-mesh {
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 10%, rgba(29,95,219,0.25) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 80%, rgba(6,182,212,0.15) 0%, transparent 55%),
                radial-gradient(ellipse 50% 40% at 50% 50%, rgba(245,158,11,0.05) 0%, transparent 50%),
                linear-gradient(160deg, #0b1f3a 0%, #071529 60%, #050f1e 100%);
        }

        .bg-grid {
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image:
                linear-gradient(rgba(29,95,219,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(29,95,219,0.06) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* ============================
           NAVBAR
        ============================ */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            padding: 0 2rem;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(11,31,58,0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(11,31,58,0.97);
            box-shadow: 0 4px 30px rgba(0,0,0,0.4);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .nav-logo-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--blue), var(--cyan));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 15px rgba(29,95,219,0.4);
            flex-shrink: 0;
        }

        .nav-logo-icon i { color: #fff; font-size: 1rem; }

        .nav-brand-text {
            display: flex; flex-direction: column;
        }

        .nav-brand-name {
            font-weight: 800;
            font-size: 1.05rem;
            color: #fff;
            letter-spacing: -0.01em;
            line-height: 1.1;
        }

        .nav-brand-sub {
            font-size: 0.6rem;
            font-weight: 500;
            color: var(--cyan);
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            list-style: none;
        }

        .nav-links a {
            padding: 0.45rem 1rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-links a:hover {
            color: #fff;
            background: var(--glass-bg);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-ghost {
            padding: 0.5rem 1.25rem;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-primary);
            background: transparent;
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex; align-items: center; gap: 0.4rem;
        }

        .btn-ghost:hover {
            background: var(--glass-bg);
            border-color: rgba(255,255,255,0.25);
            color: #fff;
        }

        .btn-primary-nav {
            padding: 0.5rem 1.25rem;
            font-size: 0.88rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, var(--blue), #1a4fc4);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.25s ease;
            display: inline-flex; align-items: center; gap: 0.4rem;
            box-shadow: 0 4px 15px rgba(29,95,219,0.35);
        }

        .btn-primary-nav:hover {
            background: linear-gradient(135deg, #2670f5, var(--blue));
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(29,95,219,0.5);
        }

        /* Mobile menu toggle */
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 4px;
            background: none;
            border: none;
        }
        .hamburger span {
            width: 22px; height: 2px;
            background: var(--text-primary);
            border-radius: 2px;
            transition: all 0.3s ease;
            display: block;
        }

        .mobile-menu {
            display: none;
            position: fixed;
            top: 70px; left: 0; right: 0;
            background: rgba(11,31,58,0.98);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            padding: 1.5rem 2rem;
            z-index: 999;
            flex-direction: column;
            gap: 0.5rem;
        }

        .mobile-menu.open { display: flex; }

        .mobile-menu a {
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .mobile-menu a:hover { color: #fff; background: var(--glass-bg); }
        .mobile-menu .divider { border: none; border-top: 1px solid var(--glass-border); margin: 0.5rem 0; }

        /* ============================
           HERO SECTION
        ============================ */
        .hero {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 120px 2rem 80px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1rem;
            background: rgba(6,182,212,0.12);
            border: 1px solid rgba(6,182,212,0.3);
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--cyan);
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 1.75rem;
            animation: fadeSlideUp 0.7s ease forwards;
        }

        .hero-badge .dot {
            width: 6px; height: 6px;
            background: var(--cyan);
            border-radius: 50%;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }

        .hero h1 {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 900;
            line-height: 1.08;
            letter-spacing: -0.03em;
            margin-bottom: 1.5rem;
            animation: fadeSlideUp 0.7s ease 0.1s both;
        }

        .hero h1 .highlight {
            background: linear-gradient(135deg, var(--blue-light), var(--cyan));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-sub {
            font-size: clamp(1rem, 2.5vw, 1.2rem);
            font-weight: 400;
            color: var(--text-secondary);
            max-width: 620px;
            margin: 0 auto 2.5rem;
            line-height: 1.7;
            animation: fadeSlideUp 0.7s ease 0.2s both;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            animation: fadeSlideUp 0.7s ease 0.3s both;
        }

        .btn-hero-primary {
            display: inline-flex; align-items: center; gap: 0.6rem;
            padding: 0.9rem 2rem;
            font-size: 1rem; font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--blue), #1a4fc4);
            border: none; border-radius: 12px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 30px rgba(29,95,219,0.4);
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(29,95,219,0.6);
            background: linear-gradient(135deg, #2670f5, var(--blue));
        }

        .btn-hero-secondary {
            display: inline-flex; align-items: center; gap: 0.6rem;
            padding: 0.9rem 2rem;
            font-size: 1rem; font-weight: 600;
            color: var(--text-primary);
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-hero-secondary:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.25);
            transform: translateY(-2px);
            color: #fff;
        }

        .hero-stats {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2.5rem;
            margin-top: 4rem;
            flex-wrap: wrap;
            animation: fadeSlideUp 0.7s ease 0.5s both;
        }

        .hero-stat {
            text-align: center;
        }

        .hero-stat-val {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--blue-light), var(--cyan));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
        }

        .hero-stat-label {
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-top: 0.3rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .stat-divider {
            width: 1px;
            height: 40px;
            background: var(--glass-border);
        }

        /* ============================
           TRUST LOGOS BAR
        ============================ */
        .trust-bar {
            position: relative; z-index: 1;
            padding: 2.5rem 2rem;
            background: rgba(255,255,255,0.02);
            border-top: 1px solid var(--glass-border);
            border-bottom: 1px solid var(--glass-border);
            text-align: center;
        }

        .trust-bar-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 1.25rem;
        }

        .trust-logos {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 3rem;
            flex-wrap: wrap;
        }

        .trust-logo-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            color: rgba(255,255,255,0.35);
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            transition: color 0.2s ease;
        }

        .trust-logo-item:hover { color: rgba(255,255,255,0.7); }
        .trust-logo-item i { font-size: 1.4rem; }

        /* ============================
           HOW IT WORKS
        ============================ */
        .section {
            position: relative; z-index: 1;
            padding: 6rem 2rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-tag {
            display: inline-block;
            padding: 0.3rem 0.85rem;
            background: rgba(29,95,219,0.15);
            border: 1px solid rgba(29,95,219,0.3);
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--blue-light);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.15;
            margin-bottom: 1rem;
        }

        .section-desc {
            font-size: 1.05rem;
            color: var(--text-secondary);
            max-width: 560px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.5rem;
            max-width: 1100px;
            margin: 0 auto;
        }

        .step-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 2.25rem 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.35s ease;
            cursor: default;
        }

        .step-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--blue), var(--cyan));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .step-card:hover {
            transform: translateY(-8px);
            background: rgba(255,255,255,0.09);
            border-color: rgba(29,95,219,0.4);
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .step-card:hover::before { opacity: 1; }

        .step-number {
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--blue-light);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .step-number::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--glass-border);
        }

        .step-icon-wrap {
            width: 56px; height: 56px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 1.4rem;
        }

        .step-icon-wrap.blue { background: rgba(29,95,219,0.18); color: var(--blue-light); }
        .step-icon-wrap.cyan { background: rgba(6,182,212,0.18); color: var(--cyan); }
        .step-icon-wrap.gold { background: rgba(245,158,11,0.18); color: var(--gold); }

        .step-title {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 0.65rem;
            color: #fff;
        }

        .step-desc {
            font-size: 0.9rem;
            color: var(--text-secondary);
            line-height: 1.65;
        }

        /* ============================
           FEATURES SECTION
        ============================ */
        .features-section {
            background: rgba(255,255,255,0.02);
            border-top: 1px solid var(--glass-border);
            border-bottom: 1px solid var(--glass-border);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem;
            max-width: 1100px;
            margin: 0 auto;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.5rem;
            border-radius: 14px;
            transition: background 0.2s ease;
        }

        .feature-item:hover { background: var(--glass-bg); }

        .feature-icon {
            width: 42px; height: 42px;
            border-radius: 10px;
            background: rgba(29,95,219,0.15);
            display: flex; align-items: center; justify-content: center;
            color: var(--blue-light);
            font-size: 1rem;
            flex-shrink: 0;
        }

        .feature-content h4 {
            font-size: 0.95rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.35rem;
        }

        .feature-content p {
            font-size: 0.83rem;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* ============================
           CTA BANNER
        ============================ */
        .cta-section {
            position: relative; z-index: 1;
            padding: 6rem 2rem;
            text-align: center;
        }

        .cta-card {
            max-width: 800px;
            margin: 0 auto;
            background: linear-gradient(135deg, rgba(29,95,219,0.2), rgba(6,182,212,0.1));
            border: 1px solid rgba(29,95,219,0.3);
            border-radius: 28px;
            padding: 4rem 3rem;
            position: relative;
            overflow: hidden;
        }

        .cta-card::before {
            content: '';
            position: absolute;
            top: -50%; left: -20%;
            width: 140%; height: 200%;
            background: radial-gradient(ellipse at center, rgba(29,95,219,0.1) 0%, transparent 60%);
            pointer-events: none;
        }

        .cta-card h2 {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 1rem;
        }

        .cta-card p {
            font-size: 1.05rem;
            color: var(--text-secondary);
            margin-bottom: 2.5rem;
            line-height: 1.7;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* ============================
           FOOTER
        ============================ */
        footer {
            position: relative; z-index: 1;
            background: rgba(5,15,30,0.9);
            border-top: 1px solid var(--glass-border);
            padding: 3rem 2rem 2rem;
        }

        .footer-inner {
            max-width: 1100px;
            margin: 0 auto;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            padding-bottom: 2.5rem;
            border-bottom: 1px solid var(--glass-border);
            margin-bottom: 2rem;
        }

        .footer-brand p {
            font-size: 0.85rem;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-top: 0.75rem;
            max-width: 280px;
        }

        .footer-col h5 {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 0.6rem; }

        .footer-col ul li a {
            font-size: 0.87rem;
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .footer-col ul li a:hover { color: var(--blue-light); }

        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-bottom p {
            font-size: 0.8rem;
            color: rgba(148,163,184,0.6);
        }

        .footer-bottom p a {
            color: var(--blue-light);
            text-decoration: none;
        }

        .footer-bottom p a:hover { text-decoration: underline; }

        .footer-badges {
            display: flex; align-items: center; gap: 0.75rem;
        }

        .footer-badge {
            display: flex; align-items: center; gap: 0.4rem;
            padding: 0.3rem 0.7rem;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--text-secondary);
        }
        .footer-badge i { color: var(--cyan); font-size: 0.8rem; }

        /* ============================
           ANIMATIONS
        ============================ */
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ============================
           RESPONSIVE
        ============================ */
        @media (max-width: 900px) {
            .footer-top { grid-template-columns: 1fr 1fr; gap: 2rem; }
            .footer-brand { grid-column: 1 / -1; }
        }

        @media (max-width: 768px) {
            .nav-links, .nav-actions { display: none; }
            .hamburger { display: flex; }
            .hero-stats { gap: 1.5rem; }
            .stat-divider { display: none; }
            .footer-top { grid-template-columns: 1fr; gap: 1.5rem; }
        }

        @media (max-width: 480px) {
            .section { padding: 4rem 1.25rem; }
            .cta-card { padding: 2.5rem 1.5rem; }
        }
    </style>
</head>

<body>

    <!-- Animated background -->
    <div class="bg-mesh"></div>
    <div class="bg-grid"></div>

    <!-- ============================
         NAVBAR
    ============================ -->
    <nav class="navbar" id="navbar">
        <a href="<?php echo e(route('home')); ?>" class="nav-brand">
            <div class="nav-logo-icon">
                <i class="fas fa-shield-halved"></i>
            </div>
            <div class="nav-brand-text">
                <span class="nav-brand-name">AuthenticityHub</span>
                <span class="nav-brand-sub">MCMC Official Platform</span>
            </div>
        </a>

        <ul class="nav-links">
            <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
            <li><a href="#how-it-works">How It Works</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="#footer">Contact</a></li>
        </ul>

        <div class="nav-actions">
            <a href="<?php echo e(route('login')); ?>" class="btn-ghost" id="nav-login-btn">
                <i class="fas fa-arrow-right-to-bracket"></i> Login
            </a>
            <a href="<?php echo e(route('register')); ?>" class="btn-primary-nav" id="nav-register-btn">
                <i class="fas fa-user-plus"></i> Register
            </a>
        </div>

        <button class="hamburger" id="hamburger-btn" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobile-menu">
        <a href="<?php echo e(route('home')); ?>"><i class="fas fa-house"></i> Home</a>
        <a href="#how-it-works"><i class="fas fa-list-ol"></i> How It Works</a>
        <a href="#features"><i class="fas fa-star"></i> Features</a>
        <a href="#footer"><i class="fas fa-envelope"></i> Contact</a>
        <hr class="divider">
        <a href="<?php echo e(route('login')); ?>"><i class="fas fa-arrow-right-to-bracket"></i> Login</a>
        <a href="<?php echo e(route('register')); ?>" style="color: var(--blue-light); font-weight:700;"><i class="fas fa-user-plus"></i> Register Now</a>
    </div>

    <!-- ============================
         HERO SECTION
    ============================ -->
    <section class="hero">
        <div style="max-width: 860px; margin: 0 auto;">
            <div class="hero-badge">
                <span class="dot"></span>
                Official MCMC Inquiry Platform
            </div>

            <h1>
                Your Voice,<br>
                <span class="highlight">Officially Heard.</span>
            </h1>

            <p class="hero-sub">
                AuthenticityHub is the Malaysian Communications and Multimedia Commission's secure platform for submitting public inquiries, tracking their progress, and receiving transparent updates.
            </p>

            <div class="hero-actions">
                <a href="<?php echo e(route('register')); ?>" class="btn-hero-primary" id="hero-submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    Submit an Inquiry
                </a>
                <a href="<?php echo e(route('login')); ?>" class="btn-hero-secondary" id="hero-track-btn">
                    <i class="fas fa-magnifying-glass"></i>
                    Track Your Status
                </a>
            </div>

            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="hero-stat-val">2,400+</div>
                    <div class="hero-stat-label">Inquiries Resolved</div>
                </div>
                <div class="stat-divider"></div>
                <div class="hero-stat">
                    <div class="hero-stat-val">98%</div>
                    <div class="hero-stat-label">Satisfaction Rate</div>
                </div>
                <div class="stat-divider"></div>
                <div class="hero-stat">
                    <div class="hero-stat-val">48h</div>
                    <div class="hero-stat-label">Avg. Response Time</div>
                </div>
                <div class="stat-divider"></div>
                <div class="hero-stat">
                    <div class="hero-stat-val">24/7</div>
                    <div class="hero-stat-label">Platform Uptime</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         TRUST BAR
    ============================ -->
    <div class="trust-bar">
        <p class="trust-bar-label">Trusted & Endorsed By</p>
        <div class="trust-logos">
            <div class="trust-logo-item"><i class="fas fa-landmark"></i> MCMC Malaysia</div>
            <div class="trust-logo-item"><i class="fas fa-shield-halved"></i> MyDigital</div>
            <div class="trust-logo-item"><i class="fas fa-globe"></i> SKMM</div>
            <div class="trust-logo-item"><i class="fas fa-lock"></i> ISO 27001 Certified</div>
            <div class="trust-logo-item"><i class="fas fa-certificate"></i> PDPA Compliant</div>
        </div>
    </div>

    <!-- ============================
         HOW IT WORKS
    ============================ -->
    <section class="section" id="how-it-works">
        <div class="section-header reveal">
            <span class="section-tag">Simple Process</span>
            <h2 class="section-title">How AuthenticityHub Works</h2>
            <p class="section-desc">A transparent, three-step process designed to ensure your inquiry reaches the right agency and gets a proper response.</p>
        </div>

        <div class="steps-grid">
            <div class="step-card reveal">
                <div class="step-number">Step 01</div>
                <div class="step-icon-wrap blue">
                    <i class="fas fa-file-circle-plus"></i>
                </div>
                <h3 class="step-title">Register & Submit</h3>
                <p class="step-desc">Create a free public account and submit your inquiry through our secure, encrypted form. Provide all relevant details and attach any supporting documents.</p>
            </div>

            <div class="step-card reveal" style="transition-delay: 0.1s;">
                <div class="step-number">Step 02</div>
                <div class="step-icon-wrap cyan">
                    <i class="fas fa-sitemap"></i>
                </div>
                <h3 class="step-title">MCMC Reviews & Assigns</h3>
                <p class="step-desc">Our MCMC administrators review your submission and assign it to the most appropriate government agency for handling and investigation.</p>
            </div>

            <div class="step-card reveal" style="transition-delay: 0.2s;">
                <div class="step-number">Step 03</div>
                <div class="step-icon-wrap gold">
                    <i class="fas fa-bell"></i>
                </div>
                <h3 class="step-title">Track & Receive Updates</h3>
                <p class="step-desc">Monitor your inquiry status in real-time from your dashboard. Receive instant notifications at every stage until your inquiry is fully resolved.</p>
            </div>
        </div>
    </section>

    <!-- ============================
         FEATURES
    ============================ -->
    <section class="section features-section" id="features">
        <div class="section-header reveal">
            <span class="section-tag">Why AuthenticityHub</span>
            <h2 class="section-title">Built for Transparency<br>& Accountability</h2>
            <p class="section-desc">Every feature is designed with the public's trust and the government's efficiency in mind.</p>
        </div>

        <div class="features-grid">
            <div class="feature-item reveal">
                <div class="feature-icon"><i class="fas fa-lock"></i></div>
                <div class="feature-content">
                    <h4>End-to-End Security</h4>
                    <p>All data is encrypted in transit and at rest. Two-factor authentication protects sensitive government accounts.</p>
                </div>
            </div>
            <div class="feature-item reveal">
                <div class="feature-icon"><i class="fas fa-bell-concierge"></i></div>
                <div class="feature-content">
                    <h4>Real-Time Notifications</h4>
                    <p>Instant alerts keep you informed at every stage of your inquiry's progress.</p>
                </div>
            </div>
            <div class="feature-item reveal">
                <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                <div class="feature-content">
                    <h4>Status Tracking</h4>
                    <p>Follow your case from submission to resolution with a clear, transparent status timeline.</p>
                </div>
            </div>
            <div class="feature-item reveal">
                <div class="feature-icon"><i class="fas fa-users-gear"></i></div>
                <div class="feature-content">
                    <h4>Multi-Agency Workflow</h4>
                    <p>Efficiently routes inquiries to the correct government agency based on category and jurisdiction.</p>
                </div>
            </div>
            <div class="feature-item reveal">
                <div class="feature-icon"><i class="fas fa-mobile-screen"></i></div>
                <div class="feature-content">
                    <h4>Mobile Responsive</h4>
                    <p>Access the platform from any device — desktop, tablet, or smartphone — with a fully adaptive interface.</p>
                </div>
            </div>
            <div class="feature-item reveal">
                <div class="feature-icon"><i class="fas fa-file-shield"></i></div>
                <div class="feature-content">
                    <h4>PDPA Compliant</h4>
                    <p>Fully compliant with Malaysia's Personal Data Protection Act to safeguard your information.</p>
                </div>
            </div>
            <div class="feature-item reveal">
                <div class="feature-icon"><i class="fas fa-history"></i></div>
                <div class="feature-content">
                    <h4>Full Audit Trail</h4>
                    <p>Every action is logged with timestamps, creating a complete and accountable record for every inquiry.</p>
                </div>
            </div>
            <div class="feature-item reveal">
                <div class="feature-icon"><i class="fas fa-headset"></i></div>
                <div class="feature-content">
                    <h4>Dedicated Support</h4>
                    <p>Our help center and support team are available to guide you through the submission process.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================
         CTA SECTION
    ============================ -->
    <section class="cta-section">
        <div class="cta-card reveal">
            <h2>Ready to Submit Your Inquiry?</h2>
            <p>Join thousands of Malaysians who have used AuthenticityHub to raise their concerns directly with the relevant government authorities.</p>
            <div class="cta-buttons">
                <a href="<?php echo e(route('register')); ?>" class="btn-hero-primary" id="cta-register-btn">
                    <i class="fas fa-user-plus"></i> Create Free Account
                </a>
                <a href="<?php echo e(route('login')); ?>" class="btn-hero-secondary" id="cta-login-btn">
                    <i class="fas fa-arrow-right-to-bracket"></i> Sign In
                </a>
            </div>
        </div>
    </section>

    <!-- ============================
         FOOTER
    ============================ -->
    <footer id="footer">
        <div class="footer-inner">
            <div class="footer-top">
                <div class="footer-brand">
                    <a href="<?php echo e(route('home')); ?>" class="nav-brand" style="margin-bottom:0.75rem; display:inline-flex;">
                        <div class="nav-logo-icon">
                            <i class="fas fa-shield-halved"></i>
                        </div>
                        <div class="nav-brand-text">
                            <span class="nav-brand-name">AuthenticityHub</span>
                            <span class="nav-brand-sub">MCMC Official Platform</span>
                        </div>
                    </a>
                    <p>The official Malaysian Communications and Multimedia Commission platform for public inquiries. Secure, transparent, and accountable.</p>
                </div>

                <div class="footer-col">
                    <h5>Platform</h5>
                    <ul>
                        <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                        <li><a href="#how-it-works">How It Works</a></li>
                        <li><a href="#features">Features</a></li>
                        <li><a href="<?php echo e(route('register')); ?>">Register</a></li>
                        <li><a href="<?php echo e(route('login')); ?>">Login</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h5>Legal</h5>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">PDPA Statement</a></li>
                        <li><a href="#">Disclaimer</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h5>Contact MCMC</h5>
                    <ul>
                        <li><a href="mailto:support@mcmc.gov.my"><i class="fas fa-envelope" style="margin-right:0.4rem;font-size:0.75rem;"></i>support@mcmc.gov.my</a></li>
                        <li><a href="tel:1800888030"><i class="fas fa-phone" style="margin-right:0.4rem;font-size:0.75rem;"></i>1-800-888-030</a></li>
                        <li><a href="https://www.mcmc.gov.my" target="_blank"><i class="fas fa-globe" style="margin-right:0.4rem;font-size:0.75rem;"></i>www.mcmc.gov.my</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; <?php echo e(date('Y')); ?> AuthenticityHub &mdash; Malaysian Communications and Multimedia Commission. All rights reserved. <a href="#">Privacy Policy</a></p>
                <div class="footer-badges">
                    <div class="footer-badge"><i class="fas fa-lock"></i> SSL Secured</div>
                    <div class="footer-badge"><i class="fas fa-certificate"></i> PDPA Compliant</div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Session Success Notification -->
    <?php if(session('success')): ?>
        <div id="success-toast" style="
            position:fixed; bottom:2rem; right:2rem; z-index:9999;
            background:rgba(16,185,129,0.15); border:1px solid rgba(16,185,129,0.35);
            backdrop-filter:blur(16px); border-radius:14px; padding:1rem 1.5rem;
            display:flex; align-items:center; gap:0.75rem;
            box-shadow:0 10px 40px rgba(0,0,0,0.3);
            animation: fadeSlideUp 0.5s ease;
            max-width: 380px;
        ">
            <i class="fas fa-circle-check" style="color:#10b981; font-size:1.3rem;"></i>
            <span style="font-size:0.9rem; font-weight:500; color:#d1fae5;"><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?>

    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        });

        // Mobile menu toggle
        const hamburger = document.getElementById('hamburger-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        hamburger.addEventListener('click', () => {
            mobileMenu.classList.toggle('open');
        });

        // Close mobile menu on link click
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => mobileMenu.classList.remove('open'));
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Scroll reveal
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

        // Auto-hide success toast
        const toast = document.getElementById('success-toast');
        if (toast) {
            setTimeout(() => {
                toast.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(20px)';
                setTimeout(() => toast.remove(), 700);
            }, 4000);
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\khale\Desktop\MCMC_S02_Astrolabe\myApp\resources\views/home/home.blade.php ENDPATH**/ ?>