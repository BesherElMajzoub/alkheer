<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة السائق — طريق الخير</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: #F0F4F8;
            color: #15314B;
            min-height: 100vh;
            line-height: 1.7;
            -webkit-font-smoothing: antialiased;
        }

        .driver-header {
            background: linear-gradient(160deg, #0F3D75, #1890FF);
            padding: 28px 24px 48px;
            color: white;
            text-align: center;
            position: relative;
        }

        .driver-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 40px;
            background: #F0F4F8;
            border-radius: 20px 20px 0 0;
        }

        .driver-header h1 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .driver-header p {
            font-size: 14px;
            opacity: 0.8;
        }

        .container {
            max-width: 480px;
            margin: 0 auto;
            padding: 0 16px;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(15, 61, 117, 0.06);
            margin-bottom: 16px;
            border: 1px solid rgba(230, 237, 245, 0.8);
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: #0F3D75;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .event-info {
            margin-top: -10px;
        }

        .event-info .event-name {
            font-size: 20px;
            font-weight: 800;
            color: #0F3D75;
            margin-bottom: 4px;
        }

        .event-info .event-meta {
            font-size: 14px;
            color: #6B7A90;
        }

        .stat-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 16px;
        }

        .stat-box {
            background: #F7FAFC;
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            border: 1px solid #E6EDF5;
        }

        .stat-box .num {
            font-size: 24px;
            font-weight: 900;
            color: #1890FF;
            line-height: 1;
        }

        .stat-box .lbl {
            font-size: 12px;
            color: #6B7A90;
            margin-top: 4px;
        }

        .passenger-card {
            background: #F7FAFC;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 12px;
            border: 1px solid #E6EDF5;
        }

        .passenger-name {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 6px;
        }

        .passenger-detail {
            font-size: 14px;
            color: #6B7A90;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 4px;
        }

        .passenger-detail a {
            color: #1890FF;
            text-decoration: none;
            font-weight: 600;
        }

        /* Status Buttons */
        .status-section {
            margin-top: 8px;
        }

        .status-btn-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .status-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 14px;
            border: 2px solid #E6EDF5;
            border-radius: 12px;
            background: white;
            font-family: 'Cairo', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: #6B7A90;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .status-btn:hover {
            border-color: #1890FF;
            color: #1890FF;
        }

        .status-btn.active {
            border-color: #1890FF;
            background: #EAF4FF;
            color: #1890FF;
        }

        .status-btn.completed {
            border-color: #22C55E;
            background: #EAFBF3;
            color: #059669;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 16px;
            font-weight: 600;
            font-size: 14px;
            text-align: center;
        }

        .alert-success {
            background: #EAFBF3;
            color: #065F46;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        .no-ride {
            text-align: center;
            padding: 48px 24px;
            color: #6B7A90;
        }

        .no-ride .emoji {
            font-size: 48px;
            display: block;
            margin-bottom: 12px;
        }

        .no-ride h2 {
            font-size: 18px;
            color: #15314B;
            margin-bottom: 8px;
        }

        .route-note {
            background: #EAF4FF;
            border-radius: 12px;
            padding: 16px;
            border-right: 3px solid #1890FF;
            font-size: 14px;
            color: #0F3D75;
            margin-top: 16px;
        }
    </style>
</head>

<body>
    <div class="driver-header">
        <h1>🚗 لوحة السائق</h1>
        <p>{{ $driver->name }}</p>
    </div>

    <div class="container" style="margin-top: -8px; padding-bottom: 32px;">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($ride)
            <div class="card event-info">
                <div class="event-name">{{ $ride->event->name }}</div>
                <div class="event-meta">
                    📅 {{ $ride->event->event_date->format('Y/m/d') }} —
                    🕐 {{ $ride->event->event_date->format('h:i A') }} —
                    📍 {{ $ride->event->location }}
                </div>

                <div class="stat-row">
                    <div class="stat-box">
                        <div class="num">{{ $ride->seats_reserved }}</div>
                        <div class="lbl">ركاب حاليون</div>
                    </div>
                    <div class="stat-box">
                        <div class="num">{{ $ride->available_seats }}</div>
                        <div class="lbl">مقاعد متبقية</div>
                    </div>
                </div>
            </div>

            {{-- Status Update --}}
            <div class="card status-section">
                <div class="card-title">📍 حالة الرحلة</div>
                <div class="status-btn-group">
                    @php
                        $statuses = [
                            'pending' => ['label' => 'في الانتظار', 'icon' => '⏳'],
                            'ready' => ['label' => 'جاهز', 'icon' => '✅'],
                            'on_the_way' => ['label' => 'في الطريق', 'icon' => '🚗'],
                            'completed' => ['label' => 'اكتملت', 'icon' => '🏁'],
                        ];
                    @endphp
                    @foreach ($statuses as $key => $s)
                        <form action="{{ route('driver.update-status', $driver->driver_token) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="{{ $key }}">
                            <button type="submit"
                                class="status-btn {{ $ride->status === $key ? ($key === 'completed' ? 'completed' : 'active') : '' }}">
                                {{ $s['icon'] }} {{ $s['label'] }}
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>

            {{-- Passengers --}}
            <div class="card">
                <div class="card-title">👥 الركاب ({{ $ride->passengers->count() }})</div>

                @forelse($ride->passengers as $passenger)
                    <div class="passenger-card">
                        <div class="passenger-name">{{ $passenger->name }}</div>
                        <div class="passenger-detail">
                            📞 <a href="tel:{{ $passenger->phone }}">{{ $passenger->phone }}</a>
                        </div>
                        <div class="passenger-detail">
                            📍 {{ $passenger->areaModel?->name ?? $passenger->area }}
                            @if ($passenger->nearest_landmark)
                                — {{ $passenger->nearest_landmark }}
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: #6B7A90; padding: 24px;">
                        <p>لم يتم تعيين ركاب بعد</p>
                    </div>
                @endforelse
            </div>

            @if ($ride->route_note)
                <div class="route-note">
                    📝 <strong>ملاحظات المسار:</strong> {{ $ride->route_note }}
                </div>
            @endif
        @else
            <div class="card no-ride">
                <span class="emoji">🕐</span>
                <h2>لا توجد رحلة حالياً</h2>
                <p>لم يتم إنشاء رحلة لك بعد. ستظهر هنا بمجرد تعيينها.</p>
            </div>
        @endif
    </div>
</body>

</html>
