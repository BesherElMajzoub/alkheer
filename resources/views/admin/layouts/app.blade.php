<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم') - طريق الخير</title>
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
            --bg: #f0f4f1;
            --bg-card: #ffffff;
            --bg-sidebar: #0a1f12;
            --text: #1a2e1f;
            --text-muted: #5a6e5f;
            --border: #d4e4d9;
            --success: #10b981;
            --error: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 12px 48px rgba(0, 0, 0, 0.1);
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

        /* ── Admin Layout ── */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, var(--bg-sidebar), #0d2916);
            padding: 0;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            transition: var(--transition);
        }

        .sidebar-header {
            padding: 28px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: white;
        }

        .sidebar-brand-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .sidebar-brand-text {
            font-size: 20px;
            font-weight: 800;
        }

        .sidebar-brand-sub {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.5);
            display: block;
            margin-top: -2px;
        }

        .sidebar-nav {
            padding: 20px 16px;
            flex: 1;
        }

        .sidebar-label {
            font-size: 11px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.35);
            text-transform: uppercase;
            padding: 8px 12px;
            letter-spacing: 1px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: var(--radius-sm);
            font-size: 15px;
            font-weight: 500;
            transition: var(--transition);
            margin-bottom: 4px;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            box-shadow: 0 4px 12px rgba(13, 124, 61, 0.3);
        }

        .sidebar-link .emoji {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-footer form {
            width: 100%;
        }

        .sidebar-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 12px 16px;
            background: rgba(239, 68, 68, 0.12);
            color: #fca5a5;
            border: none;
            border-radius: var(--radius-sm);
            font-family: 'Tajawal', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .sidebar-logout:hover {
            background: rgba(239, 68, 68, 0.25);
            color: #fecaca;
        }

        /* ── Main Content ── */
        .admin-main {
            flex: 1;
            margin-right: 260px;
            padding: 32px;
            min-height: 100vh;
        }

        .admin-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
        }

        .admin-header h1 {
            font-size: 26px;
            font-weight: 800;
            color: var(--primary-dark);
        }

        .admin-header-sub {
            font-size: 14px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* ── Cards ── */
        .admin-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 28px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            margin-bottom: 24px;
        }

        .admin-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .admin-card-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── Stats Grid ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            border-radius: 0 0 0 4px;
        }

        .stat-card:nth-child(1)::before {
            background: linear-gradient(180deg, var(--primary), var(--primary-light));
        }

        .stat-card:nth-child(2)::before {
            background: linear-gradient(180deg, var(--gold), var(--gold-light));
        }

        .stat-card:nth-child(3)::before {
            background: linear-gradient(180deg, var(--info), #60a5fa);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 16px;
        }

        .stat-card:nth-child(1) .stat-icon {
            background: rgba(13, 124, 61, 0.1);
        }

        .stat-card:nth-child(2) .stat-icon {
            background: rgba(201, 162, 39, 0.1);
        }

        .stat-card:nth-child(3) .stat-icon {
            background: rgba(59, 130, 246, 0.1);
        }

        .stat-value {
            font-size: 32px;
            font-weight: 900;
            color: var(--text);
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 14px;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* ── Table ── */
        .admin-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .admin-table th {
            background: var(--bg);
            padding: 14px 16px;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-muted);
            text-align: right;
            border-bottom: 2px solid var(--border);
        }

        .admin-table th:first-child {
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        }

        .admin-table th:last-child {
            border-radius: var(--radius-sm) 0 0 var(--radius-sm);
        }

        .admin-table td {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            vertical-align: middle;
        }

        .admin-table tbody tr {
            transition: var(--transition);
        }

        .admin-table tbody tr:hover {
            background: rgba(13, 124, 61, 0.02);
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: var(--radius-sm);
            font-family: 'Tajawal', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            box-shadow: 0 4px 12px rgba(13, 124, 61, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(13, 124, 61, 0.35);
        }

        .btn-success {
            background: linear-gradient(135deg, #059669, #10b981);
            color: white;
        }

        .btn-whatsapp {
            background: linear-gradient(135deg, #128C7E, #25D366);
            color: white;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
        }

        .btn-whatsapp:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--border);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            background: rgba(13, 124, 61, 0.04);
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .btn-danger:hover {
            background: var(--error);
            color: white;
        }

        .btn-warning {
            background: rgba(245, 158, 11, 0.1);
            color: #b45309;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 13px;
        }

        .btn-xs {
            padding: 4px 10px;
            font-size: 12px;
        }

        .btn-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* ── Forms ── */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 8px;
        }

        .form-group label .required {
            color: var(--error);
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: 'Tajawal', sans-serif;
            font-size: 15px;
            color: var(--text);
            background: var(--bg);
            transition: var(--transition);
            direction: rtl;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(13, 124, 61, 0.08);
            background: white;
        }

        .form-error {
            color: var(--error);
            font-size: 13px;
            margin-top: 6px;
        }

        .form-hint {
            color: var(--text-muted);
            font-size: 13px;
            margin-top: 4px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-check input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        /* ── Badges ── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.1);
            color: #b45309;
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .badge-info {
            background: rgba(59, 130, 246, 0.1);
            color: #2563eb;
        }

        .badge-primary {
            background: rgba(13, 124, 61, 0.1);
            color: var(--primary);
        }

        /* ── Alerts ── */
        .alert {
            padding: 16px 20px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            font-weight: 500;
            font-size: 14px;
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

        /* ── Filter Tabs ── */
        .filter-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 8px 20px;
            border-radius: 99px;
            font-family: 'Tajawal', sans-serif;
            font-size: 14px;
            font-weight: 600;
            border: 2px solid var(--border);
            background: white;
            color: var(--text-muted);
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
        }

        .filter-tab:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .filter-tab.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* ── Empty ── */
        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: var(--text-muted);
        }

        .empty-state .emoji {
            font-size: 44px;
            margin-bottom: 12px;
            display: block;
        }

        .empty-state h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
        }

        /* ── Mobile Toggle ── */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 16px;
            right: 16px;
            z-index: 200;
            width: 44px;
            height: 44px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 20px;
            cursor: pointer;
            box-shadow: var(--shadow);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 90;
        }

        /* ── Responsive ── */
        @media (max-width: 868px) {
            .sidebar {
                transform: translateX(100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.open {
                display: block;
            }

            .admin-main {
                margin-right: 0;
                padding: 24px 16px;
                padding-top: 72px;
            }

            .mobile-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .admin-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <button class="mobile-toggle" onclick="toggleSidebar()" id="mobileToggle">☰</button>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="admin-wrapper">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="/admin" class="sidebar-brand">
                    <div class="sidebar-brand-icon">🕌</div>
                    <div>
                        <span class="sidebar-brand-text">طريق الخير</span>
                        <span class="sidebar-brand-sub">لوحة التحكم</span>
                    </div>
                </a>
            </div>

            <nav class="sidebar-nav">
                <div class="sidebar-label">القائمة الرئيسية</div>
                <a href="/admin"
                    class="sidebar-link {{ request()->is('admin') && !request()->is('admin/events*') ? 'active' : '' }}">
                    <span class="emoji">📊</span>
                    لوحة التحكم
                </a>
                <a href="/admin/events" class="sidebar-link {{ request()->is('admin/events*') ? 'active' : '' }}">
                    <span class="emoji">📅</span>
                    الفعاليات
                </a>
                <a href="/admin/events/create"
                    class="sidebar-link {{ request()->is('admin/events/create') ? 'active' : '' }}">
                    <span class="emoji">➕</span>
                    إضافة فعالية
                </a>

                <div class="sidebar-label" style="margin-top: 20px;">روابط سريعة</div>
                <a href="/" class="sidebar-link" target="_blank">
                    <span class="emoji">🌐</span>
                    الموقع الرئيسي
                </a>
            </nav>

            <div class="sidebar-footer">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-logout">
                        <span>🚪</span>
                        تسجيل الخروج
                    </button>
                </form>
            </div>
        </aside>

        <main class="admin-main">
            @if (session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">⚠️ {{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }
    </script>
    @yield('scripts')
</body>

</html>
