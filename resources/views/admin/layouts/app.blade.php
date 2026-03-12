<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم') - طريق الخير</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #1890FF;
            --primary-dark: #0F3D75;
            --primary-light: #36C2FF;
            --primary-soft: #EAF4FF;
            --accent: #36C2FF;

            --bg: #F7FAFC;
            --bg-card: #FFFFFF;
            --bg-sidebar: #0F172A;
            --text: #15314B;
            --text-secondary: #6B7A90;
            --border: #E6EDF5;

            --success: #22C55E;
            --success-soft: #EAFBF3;
            --error: #EF4444;
            --error-soft: #FEF2F2;
            --warning: #F59E0B;
            --warning-soft: #FFF6E8;
            --info: #3B82F6;

            --shadow-xs: 0 1px 2px rgba(15, 61, 117, 0.04);
            --shadow-sm: 0 2px 8px rgba(15, 61, 117, 0.06);
            --shadow: 0 4px 16px rgba(15, 61, 117, 0.06);
            --shadow-md: 0 8px 30px rgba(15, 61, 117, 0.08);

            --radius: 16px;
            --radius-sm: 12px;
            --radius-xs: 8px;
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.7;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Admin Layout ── */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 260px;
            background: var(--bg-sidebar);
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
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
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
            background: rgba(24, 144, 255, 0.15);
            border-radius: var(--radius-xs);
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
            color: rgba(255, 255, 255, 0.45);
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
            color: rgba(255, 255, 255, 0.3);
            text-transform: uppercase;
            padding: 8px 12px;
            letter-spacing: 1px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            border-radius: var(--radius-xs);
            font-size: 15px;
            font-weight: 600;
            transition: var(--transition);
            margin-bottom: 4px;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.9);
        }

        .sidebar-link.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(24, 144, 255, 0.3);
        }

        .sidebar-link .emoji {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
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
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
            border: none;
            border-radius: var(--radius-xs);
            font-family: 'Cairo', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .sidebar-logout:hover {
            background: rgba(239, 68, 68, 0.2);
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
            font-size: 24px;
            font-weight: 800;
            color: var(--primary-dark);
        }

        .admin-header-sub {
            font-size: 14px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        /* ── Cards ── */
        .admin-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 28px;
            box-shadow: var(--shadow-xs);
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
            box-shadow: var(--shadow-xs);
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
            border-color: rgba(24, 144, 255, 0.2);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 3px;
            border-radius: var(--radius) var(--radius) 0 0;
        }

        .stat-card:nth-child(1)::before {
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
        }

        .stat-card:nth-child(2)::before {
            background: linear-gradient(90deg, var(--success), #34D399);
        }

        .stat-card:nth-child(3)::before {
            background: linear-gradient(90deg, var(--info), #60A5FA);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 16px;
        }

        .stat-card:nth-child(1) .stat-icon {
            background: var(--primary-soft);
        }

        .stat-card:nth-child(2) .stat-icon {
            background: var(--success-soft);
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
            color: var(--text-secondary);
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
            color: var(--text-secondary);
            text-align: right;
            border-bottom: 1px solid var(--border);
        }

        .admin-table th:first-child {
            border-radius: 0 var(--radius-xs) var(--radius-xs) 0;
        }

        .admin-table th:last-child {
            border-radius: var(--radius-xs) 0 0 var(--radius-xs);
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
            background: rgba(24, 144, 255, 0.02);
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: var(--radius-xs);
            font-family: 'Cairo', sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            border: 1.5px solid transparent;
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 2px 8px rgba(24, 144, 255, 0.2);
        }

        .btn-primary:hover {
            background: #0c7ee6;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(24, 144, 255, 0.3);
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-whatsapp {
            background: #128C7E;
            color: white;
            box-shadow: 0 2px 8px rgba(37, 211, 102, 0.2);
        }

        .btn-whatsapp:hover {
            background: #0e7a6e;
            transform: translateY(-1px);
        }

        .btn-outline {
            background: transparent;
            color: var(--text);
            border-color: var(--border);
        }

        .btn-outline:hover {
            border-color: rgba(24, 144, 255, 0.3);
            background: var(--primary-soft);
            color: var(--primary);
        }

        .btn-danger {
            background: var(--error-soft);
            color: var(--error);
            border: 1px solid rgba(239, 68, 68, 0.15);
        }

        .btn-danger:hover {
            background: var(--error);
            color: white;
        }

        .btn-warning {
            background: var(--warning-soft);
            color: #B45309;
            border: 1px solid rgba(245, 158, 11, 0.15);
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 13px;
        }

        .btn-xs {
            padding: 5px 12px;
            font-size: 12px;
        }

        .btn-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* ── Forms ── */
        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
        }

        .form-group label .required {
            color: var(--error);
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-xs);
            font-family: 'Cairo', sans-serif;
            font-size: 15px;
            color: var(--text);
            background: #fff;
            transition: var(--transition);
            direction: rtl;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(24, 144, 255, 0.1);
        }

        .form-control::placeholder {
            color: #A0AEC0;
        }

        .form-error {
            color: var(--error);
            font-size: 13px;
            margin-top: 6px;
            font-weight: 600;
        }

        .form-hint {
            color: var(--text-secondary);
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
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-success {
            background: var(--success-soft);
            color: #059669;
        }

        .badge-warning {
            background: var(--warning-soft);
            color: #B45309;
        }

        .badge-danger {
            background: var(--error-soft);
            color: #DC2626;
        }

        .badge-info {
            background: rgba(59, 130, 246, 0.1);
            color: #2563EB;
        }

        .badge-primary {
            background: var(--primary-soft);
            color: var(--primary);
        }

        /* ── Alerts ── */
        .alert {
            padding: 16px 20px;
            border-radius: var(--radius-xs);
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: var(--success-soft);
            color: #065F46;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        .alert-error {
            background: var(--error-soft);
            color: #991B1B;
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
            font-family: 'Cairo', sans-serif;
            font-size: 14px;
            font-weight: 700;
            border: 1.5px solid var(--border);
            background: white;
            color: var(--text-secondary);
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
            color: var(--text-secondary);
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
            border-radius: var(--radius-xs);
            font-size: 20px;
            cursor: pointer;
            box-shadow: var(--shadow);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 90;
            backdrop-filter: blur(2px);
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
