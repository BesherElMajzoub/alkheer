<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="طريق الخير - منصة ذكية لتنظيم الفعاليات الإسلامية والتسجيل بسهولة">
    <title>@yield('title', 'طريق الخير')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        /* ── Design Tokens ── */
        :root {
            --primary: #1890FF;
            --primary-dark: #0F3D75;
            --primary-light: #36C2FF;
            --primary-soft: #EAF4FF;
            --accent: #36C2FF;

            --bg: #F7FAFC;
            --bg-card: #FFFFFF;
            --text: #15314B;
            --text-secondary: #6B7A90;
            --border: #E6EDF5;

            --success: #22C55E;
            --success-soft: #EAFBF3;
            --warning: #F59E0B;
            --warning-soft: #FFF6E8;
            --error: #EF4444;
            --error-soft: #FEF2F2;

            --shadow-xs: 0 1px 2px rgba(15, 61, 117, 0.04);
            --shadow-sm: 0 2px 8px rgba(15, 61, 117, 0.06);
            --shadow: 0 4px 16px rgba(15, 61, 117, 0.06);
            --shadow-md: 0 8px 30px rgba(15, 61, 117, 0.08);
            --shadow-lg: 0 16px 48px rgba(15, 61, 117, 0.10);

            --radius: 20px;
            --radius-md: 16px;
            --radius-sm: 12px;
            --radius-xs: 8px;

            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-fast: all 0.15s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.8;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Navbar ── */
        .navbar {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--border);
            transition: var(--transition);
        }

        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: var(--text);
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            background: var(--primary-soft);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            border: 1px solid rgba(24, 144, 255, 0.12);
        }

        .brand-text {
            font-size: 21px;
            font-weight: 800;
            color: var(--primary-dark);
            letter-spacing: -0.3px;
        }

        .brand-sub {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-secondary);
            display: block;
            margin-top: -3px;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-links a {
            color: var(--text-secondary);
            text-decoration: none;
            padding: 10px 18px;
            border-radius: var(--radius-xs);
            font-weight: 600;
            font-size: 15px;
            transition: var(--transition-fast);
        }

        .navbar-links a:hover {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .navbar-links .nav-cta {
            background: var(--primary);
            color: #fff;
            padding: 10px 24px;
            border-radius: var(--radius-sm);
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(24, 144, 255, 0.25);
        }

        .navbar-links .nav-cta:hover {
            background: var(--primary-dark);
            color: #fff;
            box-shadow: 0 4px 16px rgba(24, 144, 255, 0.35);
            transform: translateY(-1px);
        }

        /* Mobile menu toggle */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 26px;
            color: var(--text);
            cursor: pointer;
            padding: 8px;
            border-radius: var(--radius-xs);
            transition: var(--transition-fast);
        }

        .mobile-toggle:hover {
            background: var(--primary-soft);
        }

        /* ── Container ── */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 32px;
            position: relative;
            z-index: 1;
        }

        /* ── Hero ── */
        .hero {
            background: linear-gradient(160deg, #FFFFFF 0%, var(--primary-soft) 50%, #EDF6FF 100%);
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* Subtle Islamic geometric hint */
            background-image:
                radial-gradient(circle at 20% 80%, rgba(24, 144, 255, 0.04) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(54, 194, 255, 0.04) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Subtle geometric pattern overlay */
        .hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0.025;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%230F3D75' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            background: rgba(24, 144, 255, 0.08);
            border: 1px solid rgba(24, 144, 255, 0.15);
            border-radius: 99px;
            font-size: 14px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 24px;
        }

        .hero h1 {
            font-size: 42px;
            font-weight: 800;
            color: var(--primary-dark);
            line-height: 1.35;
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }

        .hero p {
            font-size: 18px;
            color: var(--text-secondary);
            max-width: 520px;
            margin-bottom: 36px;
            line-height: 1.8;
            font-weight: 400;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .hero-visual {
            position: relative;
            z-index: 2;
        }

        .hero-video-wrapper {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 10px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .hero-video-wrapper .video-inner {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            border-radius: var(--radius-sm);
            overflow: hidden;
        }

        .hero-video-wrapper .video-inner iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
            border-radius: var(--radius-sm);
        }

        /* ── Section ── */
        .section {
            padding: 80px 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 56px;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            background: var(--primary-soft);
            border-radius: 99px;
            font-size: 14px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 16px;
        }

        .section-title {
            font-size: 30px;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .section-subtitle {
            font-size: 17px;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* ── Event Cards ── */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 28px;
        }

        .event-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 32px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            transition: var(--transition);
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .event-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
            border-color: rgba(24, 144, 255, 0.2);
        }

        .event-card-header {
            margin-bottom: 20px;
        }

        .event-card h3 {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .event-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px 20px;
            margin-bottom: 20px;
        }

        .event-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .event-meta-item .meta-icon {
            width: 32px;
            height: 32px;
            background: var(--primary-soft);
            border-radius: var(--radius-xs);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .event-description {
            font-size: 15px;
            color: var(--text-secondary);
            margin-bottom: 24px;
            line-height: 1.8;
            flex-grow: 1;
        }

        .event-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            margin-top: auto;
        }

        /* ── Badges ── */
        .event-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: var(--radius-xs);
            font-size: 13px;
            font-weight: 700;
        }

        .badge-open {
            background: var(--success-soft);
            color: #059669;
        }

        .badge-limited {
            background: var(--warning-soft);
            color: #D97706;
        }

        .badge-full {
            background: var(--error-soft);
            color: #DC2626;
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 28px;
            border-radius: var(--radius-sm);
            font-family: 'Cairo', sans-serif;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            border: 2px solid transparent;
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
            line-height: 1.2;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 4px 14px rgba(24, 144, 255, 0.25);
        }

        .btn-primary:hover {
            background: #0c7ee6;
            box-shadow: 0 6px 20px rgba(24, 144, 255, 0.35);
            transform: translateY(-2px);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary-dark);
            border-color: var(--border);
        }

        .btn-outline:hover {
            background: var(--primary-soft);
            border-color: rgba(24, 144, 255, 0.3);
            color: var(--primary);
        }

        .btn-sm {
            padding: 10px 20px;
            font-size: 14px;
            border-radius: var(--radius-xs);
        }

        .btn-lg {
            padding: 18px 36px;
            font-size: 17px;
            border-radius: var(--radius-md);
        }

        /* ── Features Section ── */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        .feature-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 36px;
            border: 1px solid var(--border);
            text-align: center;
            transition: var(--transition);
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow);
            border-color: rgba(24, 144, 255, 0.15);
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            background: var(--primary-soft);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 20px;
        }

        .feature-card h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 10px;
        }

        .feature-card p {
            font-size: 15px;
            color: var(--text-secondary);
            line-height: 1.7;
        }

        /* ── Stats Section ── */
        .stats-section {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #1a5fa8 100%);
            padding: 72px 0;
            position: relative;
            overflow: hidden;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0.04;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23FFFFFF' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .stat-item .stat-number {
            font-size: 48px;
            font-weight: 900;
            color: #fff;
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-item .stat-label {
            font-size: 16px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.75);
        }

        /* ── CTA Section ── */
        .cta-section {
            padding: 80px 0;
        }

        .cta-card {
            background: linear-gradient(135deg, var(--primary-soft), #fff);
            border-radius: var(--radius);
            padding: 64px;
            text-align: center;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .cta-card::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0.02;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%230F3D75' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .cta-card h2 {
            font-size: 30px;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 16px;
            position: relative;
        }

        .cta-card p {
            font-size: 17px;
            color: var(--text-secondary);
            margin-bottom: 32px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
        }

        .cta-card .btn {
            position: relative;
        }

        /* ── Footer ── */
        .footer {
            background: var(--primary-dark);
            color: rgba(255, 255, 255, 0.7);
            padding: 48px 0;
            margin-top: 0;
        }

        .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .footer-text {
            font-size: 15px;
            font-weight: 500;
        }

        .footer-text strong {
            color: var(--accent);
            font-weight: 700;
        }

        .footer-links {
            display: flex;
            gap: 24px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: var(--transition-fast);
        }

        .footer-links a:hover {
            color: #fff;
        }

        /* ── Empty State ── */
        .empty-state {
            text-align: center;
            padding: 80px 24px;
            color: var(--text-secondary);
            background: var(--bg-card);
            border: 2px dashed var(--border);
            border-radius: var(--radius);
        }

        .empty-state .empty-icon {
            font-size: 48px;
            margin-bottom: 20px;
            display: block;
            opacity: 0.7;
        }

        .empty-state h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text);
        }

        .empty-state p {
            font-size: 15px;
            color: var(--text-secondary);
        }

        /* ── Alerts ── */
        .alert {
            padding: 16px 24px;
            border-radius: var(--radius-sm);
            margin-bottom: 24px;
            font-weight: 600;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow-xs);
        }

        .alert-success {
            background: var(--success-soft);
            color: #065F46;
            border: 1px solid #A7F3D0;
        }

        .alert-error {
            background: var(--error-soft);
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        /* ── Animations ── */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        .animate-delay-1 {
            animation-delay: 0.1s;
            opacity: 0;
        }

        .animate-delay-2 {
            animation-delay: 0.2s;
            opacity: 0;
        }

        .animate-delay-3 {
            animation-delay: 0.3s;
            opacity: 0;
        }

        .animate-delay-4 {
            animation-delay: 0.4s;
            opacity: 0;
        }

        /* ── Responsive ── */
        @media (max-width: 992px) {
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 48px;
                text-align: center;
            }

            .hero h1 {
                font-size: 34px;
            }

            .hero p {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-actions {
                justify-content: center;
            }

            .features-grid {
                grid-template-columns: 1fr 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 24px;
            }
        }

        @media (max-width: 768px) {
            .hero {
                padding: 60px 0 48px;
            }

            .hero h1 {
                font-size: 28px;
            }

            .hero p {
                font-size: 16px;
            }

            .events-grid {
                grid-template-columns: 1fr;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .stat-item .stat-number {
                font-size: 36px;
            }

            .section {
                padding: 56px 0;
            }

            .section-title {
                font-size: 24px;
            }

            .navbar-inner {
                height: 64px;
                padding: 0 20px;
            }

            .navbar-links {
                display: none;
                position: fixed;
                top: 64px;
                right: 0;
                left: 0;
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(20px);
                flex-direction: column;
                padding: 20px;
                border-bottom: 1px solid var(--border);
                box-shadow: var(--shadow-md);
                gap: 4px;
            }

            .navbar-links.open {
                display: flex;
            }

            .navbar-links a {
                width: 100%;
                text-align: center;
                padding: 14px;
                border-radius: var(--radius-xs);
            }

            .mobile-toggle {
                display: flex;
                align-items: center;
            }

            .brand-text {
                font-size: 18px;
            }

            .cta-card {
                padding: 40px 24px;
            }

            .container {
                padding: 0 20px;
            }

            .event-card {
                padding: 24px;
            }

            .btn-lg {
                padding: 14px 28px;
                font-size: 15px;
            }

            .footer-inner {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 24px;
            }

            .hero-actions {
                flex-direction: column;
            }

            .hero-actions .btn {
                width: 100%;
            }

            .event-meta {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <nav class="navbar" id="navbar">
        <div class="navbar-inner">
            <a href="/" class="navbar-brand">
                <div class="brand-icon">🕌</div>
                <div>
                    <span class="brand-text">طريق الخير</span>
                    <span class="brand-sub">تنظيم الفعاليات المجتمعية</span>
                </div>
            </a>

            <button class="mobile-toggle" onclick="toggleMobileMenu()" aria-label="القائمة">☰</button>

            <div class="navbar-links" id="navLinks">
                <a href="/">الرئيسية</a>
                <a href="/#events">الفعاليات</a>
                <a href="/admin/login">لوحة التحكم</a>
                <a href="/#events" class="nav-cta">استكشف الفعاليات</a>
            </div>
        </div>
    </nav>

    @yield('hero')

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-inner">
                <p class="footer-text">جميع الحقوق محفوظة &copy; {{ date('Y') }} — <strong>طريق الخير</strong></p>
                <div class="footer-links">
                    <a href="/">الرئيسية</a>
                    <a href="/#events">الفعاليات</a>
                    <a href="/admin/login">لوحة التحكم</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            document.getElementById('navLinks').classList.toggle('open');
        }

        // Close menu on link click
        document.querySelectorAll('.navbar-links a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('navLinks').classList.remove('open');
            });
        });
    </script>
    @yield('scripts')
</body>

</html>
