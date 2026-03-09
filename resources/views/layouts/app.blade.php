<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="طريق الخير - نظام تنظيم حضور الطلاب للدروس والفعاليات في المساجد">
    <title>@yield('title', 'طريق الخير')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #0d7c3d;
            --primary-dark: #065f2d;
            --primary-light: #1a9e50;
            --gold: #c9a227;
            --gold-light: #e6c84a;
            --bg: #f8faf9;
            --bg-card: #ffffff;
            --text: #1a2e1f;
            --text-muted: #5a6e5f;
            --border: #d4e4d9;
            --success: #10b981;
            --error: #ef4444;
            --shadow: 0 4px 24px rgba(13, 124, 61, 0.08);
            --shadow-lg: 0 12px 48px rgba(13, 124, 61, 0.12);
            --radius: 16px;
            --radius-sm: 10px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.7;
            min-height: 100vh;
        }

        /* ── Decorative Background ── */
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            right: -30%;
            width: 80vw;
            height: 80vw;
            background: radial-gradient(circle, rgba(13, 124, 61, 0.04) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* ── Navbar ── */
        .navbar {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: white;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            backdrop-filter: blur(10px);
        }

        .brand-text {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .brand-sub {
            font-size: 11px;
            font-weight: 400;
            opacity: 0.8;
            display: block;
            margin-top: -4px;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-links a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 10px;
            font-weight: 500;
            font-size: 15px;
            transition: var(--transition);
        }

        .navbar-links a:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        /* ── Container ── */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            position: relative;
            z-index: 1;
        }

        /* ── Hero ── */
        .hero {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 50%, var(--primary-light) 100%);
            padding: 80px 0 60px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -100px;
            left: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(201, 162, 39, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -80px;
            right: -50px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-content {
            text-align: center;
            color: white;
            position: relative;
            z-index: 2;
        }

        .hero-icon {
            font-size: 56px;
            margin-bottom: 20px;
            display: inline-block;
            animation: floatIcon 3s ease-in-out infinite;
        }

        @keyframes floatIcon {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .hero h1 {
            font-size: 44px;
            font-weight: 900;
            margin-bottom: 16px;
            letter-spacing: -1px;
        }

        .hero p {
            font-size: 19px;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
            font-weight: 300;
        }

        /* ── Section ── */
        .section {
            padding: 60px 0;
        }

        .section-title {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 32px;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title .icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }

        /* ── Event Cards ── */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 24px;
        }

        .event-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 28px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .event-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--primary), var(--gold));
            border-radius: 0 0 0 4px;
        }

        .event-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .event-card-header {
            margin-bottom: 16px;
        }

        .event-card h3 {
            font-size: 21px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }

        .event-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 16px;
        }

        .event-meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            color: var(--text-muted);
        }

        .event-meta-item .emoji {
            font-size: 16px;
        }

        .event-description {
            font-size: 15px;
            color: var(--text-muted);
            margin-bottom: 20px;
            line-height: 1.8;
        }

        .event-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .event-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 13px;
            font-weight: 600;
        }

        .badge-open {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
        }

        .badge-limited {
            background: rgba(201, 162, 39, 0.1);
            color: #a17f1a;
        }

        .badge-full {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: var(--radius-sm);
            font-family: 'Tajawal', sans-serif;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            box-shadow: 0 4px 16px rgba(13, 124, 61, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(13, 124, 61, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .btn-sm {
            padding: 8px 18px;
            font-size: 13px;
        }

        /* ── Footer ── */
        .footer {
            background: var(--primary-dark);
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            padding: 32px 0;
            margin-top: 40px;
        }

        .footer-text {
            font-size: 14px;
            font-weight: 300;
        }

        .footer-text strong {
            color: var(--gold-light);
            font-weight: 700;
        }

        /* ── Empty State ── */
        .empty-state {
            text-align: center;
            padding: 80px 24px;
            color: var(--text-muted);
        }

        .empty-state .emoji {
            font-size: 56px;
            margin-bottom: 16px;
            display: block;
        }

        .empty-state h3 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text);
        }

        /* ── Alerts ── */
        .alert {
            padding: 16px 24px;
            border-radius: var(--radius-sm);
            margin-bottom: 24px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 30px;
            }

            .hero p {
                font-size: 16px;
            }

            .hero {
                padding: 50px 0 40px;
            }

            .hero-icon {
                font-size: 40px;
            }

            .events-grid {
                grid-template-columns: 1fr;
            }

            .section-title {
                font-size: 22px;
            }

            .navbar-inner {
                height: 60px;
            }

            .brand-text {
                font-size: 18px;
            }

            .navbar-links a {
                padding: 6px 12px;
                font-size: 13px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 16px;
            }

            .event-card {
                padding: 20px;
            }

            .event-meta {
                gap: 10px;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="/" class="navbar-brand">
                <div class="brand-icon">🕌</div>
                <div>
                    <span class="brand-text">طريق الخير</span>
                    <span class="brand-sub">تنظيم الفعاليات والتوصيل</span>
                </div>
            </a>
            <div class="navbar-links">
                <a href="/">الرئيسية</a>
                <a href="/admin/login">لوحة التحكم</a>
            </div>
        </div>
    </nav>

    @yield('hero')

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <p class="footer-text">جميع الحقوق محفوظة &copy; {{ date('Y') }} — <strong>طريق الخير</strong></p>
        </div>
    </footer>

    @yield('scripts')
</body>

</html>
