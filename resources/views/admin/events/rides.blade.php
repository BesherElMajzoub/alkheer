@extends('admin.layouts.app')

@section('title', 'تنظيم التوصيل — ' . $event->name)

@section('styles')
    <style>
        .page-header {
            margin-bottom: 32px;
        }

        .page-header h1 {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 4px;
        }

        .page-header p {
            color: var(--text-secondary);
            font-size: 14px;
        }

        /* ── Summary Grid ── */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .summary-item {
            background: var(--bg-card);
            border-radius: var(--radius-xs);
            padding: 20px;
            text-align: center;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-xs);
        }

        .summary-item .number {
            font-size: 28px;
            font-weight: 900;
            color: var(--primary-dark);
            line-height: 1;
            margin-bottom: 4px;
        }

        .summary-item .label {
            font-size: 13px;
            color: var(--text-secondary);
            font-weight: 600;
        }

        .summary-item.warning .number {
            color: var(--warning);
        }

        .summary-item.success .number {
            color: var(--success);
        }

        .summary-item.danger .number {
            color: var(--error);
        }

        /* ── Action Bar ── */
        .action-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 32px;
            padding: 20px 24px;
            background: var(--bg-card);
            border-radius: var(--radius-xs);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-xs);
        }

        /* ── Axis Breakdown ── */
        .axis-breakdown {
            margin-bottom: 32px;
        }

        .axis-breakdown h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .axis-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 16px;
        }

        .axis-card {
            background: var(--bg-card);
            border-radius: var(--radius-xs);
            padding: 20px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-xs);
        }

        .axis-card h4 {
            font-size: 15px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 14px;
        }

        .axis-card .meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .axis-card .meta span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .surplus {
            color: var(--success);
            font-weight: 700;
        }

        .deficit {
            color: var(--error);
            font-weight: 700;
        }

        /* ── Rides Section ── */
        .rides-section h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ride-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 24px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-xs);
            margin-bottom: 20px;
            transition: var(--transition);
        }

        .ride-card:hover {
            border-color: rgba(24, 144, 255, 0.2);
            box-shadow: var(--shadow-sm);
        }

        .ride-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .ride-driver {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ride-avatar {
            width: 46px;
            height: 46px;
            background: var(--primary-soft);
            border-radius: var(--radius-xs);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .ride-driver-name {
            font-weight: 700;
            font-size: 16px;
        }

        .ride-driver-meta {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .ride-badges {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .ride-seat-bar {
            height: 6px;
            background: var(--bg);
            border-radius: 99px;
            overflow: hidden;
            margin-bottom: 16px;
        }

        .ride-seat-fill {
            height: 100%;
            border-radius: 99px;
            transition: width 0.4s ease;
        }

        .ride-seat-fill.good {
            background: var(--success);
        }

        .ride-seat-fill.mid {
            background: var(--warning);
        }

        .ride-seat-fill.full {
            background: var(--error);
        }

        .ride-passengers {
            margin-top: 12px;
        }

        .passenger-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            background: var(--bg);
            border-radius: var(--radius-xs);
            margin-bottom: 6px;
            font-size: 14px;
        }

        .passenger-info {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .passenger-info .name {
            font-weight: 600;
        }

        .passenger-info .area {
            color: var(--text-secondary);
            font-size: 13px;
        }

        .passenger-reason {
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 700;
        }

        .reason-same_area {
            background: #EAFBF3;
            color: #059669;
        }

        .reason-same_axis {
            background: rgba(59, 130, 246, 0.1);
            color: #2563EB;
        }

        .reason-neighbor_axis {
            background: #FFF6E8;
            color: #B45309;
        }

        .reason-manual_override {
            background: rgba(139, 92, 246, 0.1);
            color: #7C3AED;
        }

        .ride-add-form {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px dashed var(--border);
        }

        .ride-add-form select {
            flex: 1;
            min-width: 180px;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-xs);
            font-family: 'Cairo', sans-serif;
            font-size: 14px;
            color: var(--text);
            background: #fff;
            direction: rtl;
        }

        .ride-add-form select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(24, 144, 255, 0.1);
        }

        /* ── Unassigned Section ── */
        .unassigned-section {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.03), rgba(239, 68, 68, 0.03));
            border: 1px solid rgba(245, 158, 11, 0.15);
            border-radius: var(--radius);
            padding: 28px;
            margin-bottom: 28px;
        }

        .unassigned-section h3 {
            color: #B45309;
        }

        .unassigned-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 12px;
        }

        .unassigned-item {
            background: white;
            padding: 16px;
            border-radius: var(--radius-xs);
            border: 1px solid var(--border);
            font-size: 14px;
        }

        .unassigned-item .name {
            font-weight: 700;
            margin-bottom: 4px;
        }

        .unassigned-item .detail {
            color: var(--text-secondary);
            font-size: 13px;
        }

        /* ── Create Manual Ride ── */
        .manual-ride-form {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
            padding: 20px 24px;
            background: var(--bg-card);
            border-radius: var(--radius-xs);
            border: 1px solid var(--border);
            margin-bottom: 28px;
        }

        .manual-ride-form select {
            flex: 1;
            min-width: 200px;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-xs);
            font-family: 'Cairo', sans-serif;
            font-size: 14px;
            direction: rtl;
        }

        .manual-ride-form label {
            font-weight: 700;
            font-size: 14px;
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .axis-grid {
                grid-template-columns: 1fr;
            }

            .unassigned-list {
                grid-template-columns: 1fr;
            }
        }

        .status-badge {
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 700;
        }

        .status-pending {
            background: #F3F4F6;
            color: #6B7280;
        }

        .status-ready {
            background: rgba(59, 130, 246, 0.1);
            color: #2563EB;
        }

        .status-on_the_way {
            background: #FFF6E8;
            color: #B45309;
        }

        .status-completed {
            background: #EAFBF3;
            color: #059669;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div class="admin-header">
            <div>
                <h1>🚗 تنظيم التوصيل — {{ $event->name }}</h1>
                <p>{{ $event->event_date->format('Y/m/d h:i A') }} | {{ $event->location }}</p>
            </div>
            <div class="btn-group">
                <a href="{{ route('admin.events.show', $event) }}" class="btn btn-outline btn-sm">→ تفاصيل الفعالية</a>
                <a href="{{ route('admin.events.index') }}" class="btn btn-outline btn-sm">→ كل الفعاليات</a>
            </div>
        </div>
    </div>

    {{-- ── Summary ── --}}
    <div class="summary-grid">
        <div class="summary-item">
            <div class="number">{{ $summary['total_need_ride'] }}</div>
            <div class="label">🚶 يحتاجون توصيل</div>
        </div>
        <div class="summary-item success">
            <div class="number">{{ $summary['assigned'] }}</div>
            <div class="label">✅ تم توزيعهم</div>
        </div>
        <div class="summary-item {{ $summary['unassigned'] > 0 ? 'danger' : '' }}">
            <div class="number">{{ $summary['unassigned'] }}</div>
            <div class="label">⏳ بدون توزيع</div>
        </div>
        <div class="summary-item">
            <div class="number">{{ $summary['eligible_drivers'] }}</div>
            <div class="label">🚗 سائقون متاحون</div>
        </div>
        <div class="summary-item">
            <div class="number">{{ $summary['total_seats'] }}</div>
            <div class="label">💺 مجموع المقاعد</div>
        </div>
        <div class="summary-item">
            <div class="number">{{ $summary['rides_count'] }}</div>
            <div class="label">🛣️ رحلات مُنشأة</div>
        </div>
    </div>

    {{-- ── Action Bar ── --}}
    <div class="action-bar">
        <form action="{{ route('admin.events.rides.auto-distribute', $event) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm"
                onclick="return confirm('سيتم إنشاء توزيع تلقائي. متابعة؟')">
                ⚡ توزيع تلقائي
            </button>
        </form>

        <form action="{{ route('admin.events.rides.clear-auto', $event) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('سيتم حذف جميع الرحلات التلقائية. متأكد؟')">
                🗑️ حذف التوزيع التلقائي
            </button>
        </form>
    </div>

    {{-- ── Axis Breakdown ── --}}
    @if (count($summary['axis_breakdown']) > 0)
        <div class="axis-breakdown">
            <h3>📊 توزيع حسب المحاور</h3>
            <div class="axis-grid">
                @foreach ($summary['axis_breakdown'] as $axis)
                    @if ($axis['needs_ride'] > 0 || $axis['drivers'] > 0)
                        <div class="axis-card">
                            <h4>{{ $axis['axis_name'] }}</h4>
                            <div class="meta">
                                <span>🚶 {{ $axis['needs_ride'] }} يحتاج</span>
                                <span>🚗 {{ $axis['drivers'] }} سائق</span>
                                <span>💺 {{ $axis['total_seats'] }} مقعد</span>
                                <span>✅ {{ $axis['assigned'] }} معيّن</span>
                                @if ($axis['surplus'] >= 0)
                                    <span class="surplus">+{{ $axis['surplus'] }} فائض</span>
                                @else
                                    <span class="deficit">{{ $axis['surplus'] }} عجز</span>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

    {{-- ── Manual Ride Creation ── --}}
    @if ($availableDrivers->isNotEmpty())
        <form action="{{ route('admin.events.rides.create-manual', $event) }}" method="POST" class="manual-ride-form">
            @csrf
            <label>➕ إنشاء رحلة يدوية:</label>
            <select name="driver_registration_id" required>
                <option value="">— اختر سائقاً —</option>
                @foreach ($availableDrivers as $d)
                    <option value="{{ $d->id }}">{{ $d->name }} — {{ $d->areaModel?->name ?? $d->area }}
                        ({{ $d->available_seats }} مقعد)
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm">إنشاء رحلة</button>
        </form>
    @endif

    {{-- ── Unassigned Passengers ── --}}
    @if ($unassigned->isNotEmpty())
        <div class="unassigned-section">
            <h3>⏳ غير موزعين ({{ $unassigned->count() }})</h3>
            <div class="unassigned-list">
                @foreach ($unassigned as $u)
                    <div class="unassigned-item">
                        <div class="name">{{ $u->name }}</div>
                        <div class="detail">
                            📍 {{ $u->areaModel?->name ?? $u->area }}
                            @if ($u->nearest_landmark)
                                — {{ $u->nearest_landmark }}
                            @endif
                            | 📞 {{ $u->phone }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ── Rides List ── --}}
    <div class="rides-section">
        <h3>🛣️ الرحلات ({{ $rides->count() }})</h3>

        @forelse($rides as $ride)
            @php
                $fillPercent =
                    $ride->seats_capacity > 0 ? round(($ride->seats_reserved / $ride->seats_capacity) * 100) : 0;
                $fillClass = $fillPercent >= 100 ? 'full' : ($fillPercent >= 60 ? 'mid' : 'good');
                $statusLabels = [
                    'pending' => 'في الانتظار',
                    'ready' => 'جاهز',
                    'on_the_way' => 'في الطريق',
                    'completed' => 'مكتملة',
                ];
                $reasonLabels = [
                    'same_area' => 'نفس المنطقة',
                    'same_axis' => 'نفس المحور',
                    'neighbor_axis' => 'محور قريب',
                    'manual_override' => 'يدوي',
                ];
            @endphp

            <div class="ride-card">
                <div class="ride-header">
                    <div class="ride-driver">
                        <div class="ride-avatar">🚗</div>
                        <div>
                            <div class="ride-driver-name">{{ $ride->driverRegistration->name }}</div>
                            <div class="ride-driver-meta">
                                📍 {{ $ride->driverRegistration->areaModel?->name ?? $ride->driverRegistration->area }}
                                | 📞 {{ $ride->driverRegistration->phone }}
                                | 💺 {{ $ride->seats_reserved }}/{{ $ride->seats_capacity }}
                            </div>
                        </div>
                    </div>
                    <div class="ride-badges">
                        <span class="badge {{ $ride->assignment_source === 'auto' ? 'badge-info' : 'badge-primary' }}">
                            {{ $ride->assignment_source === 'auto' ? '⚡ تلقائي' : '✋ يدوي' }}
                        </span>
                        <span class="status-badge status-{{ $ride->status }}">{{ $statusLabels[$ride->status] }}</span>
                        {{-- @if ($ride->driverRegistration->driver_token)
                            <a href="{{ route('driver.dashboard', $ride->driverRegistration->driver_token) }}"
                                target="_blank" class="btn btn-outline btn-xs" title="رابط السائق">🔗</a>
                        @endif --}}
                        @php
                            $phone = preg_replace('/[^0-9]/', '', $ride->driverRegistration->phone);

                            if (str_starts_with($phone, '09')) {
                                $phone = '963' . substr($phone, 1);
                            }
                        @endphp

                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ride->driverRegistration->phone) }}?text={{ urlencode("السلام عليكم\nهذه صفحة التوصيلات الخاصة بك:\n" . route('driver.dashboard', $ride->driverRegistration->driver_token)) }}"
                            target="_blank" class="btn btn-success btn-xs" title="واتساب السائق">
                            واتساب
                        </a>
                        <form action="{{ route('admin.events.rides.delete', [$event, $ride]) }}" method="POST"
                            style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs"
                                onclick="return confirm('حذف الرحلة؟')">🗑️</button>
                        </form>
                    </div>
                </div>

                <div class="ride-seat-bar">
                    <div class="ride-seat-fill {{ $fillClass }}" style="width: {{ $fillPercent }}%"></div>
                </div>

                @if ($ride->passengers->isNotEmpty())
                    <div class="ride-passengers">
                        @foreach ($ride->passengers as $p)
                            <div class="passenger-row">
                                <div class="passenger-info">
                                    <span class="name">{{ $p->name }}</span>
                                    <span class="area">— {{ $p->areaModel?->name ?? $p->area }}</span>
                                    @if ($p->nearest_landmark)
                                        <span class="area">({{ $p->nearest_landmark }})</span>
                                    @endif
                                </div>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span class="passenger-reason reason-{{ $p->pivot->assignment_reason }}">
                                        {{ $reasonLabels[$p->pivot->assignment_reason] ?? $p->pivot->assignment_reason }}
                                    </span>
                                    <form action="{{ route('admin.events.rides.remove-passenger', $event) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="ride_id" value="{{ $ride->id }}">
                                        <input type="hidden" name="registration_id" value="{{ $p->id }}">
                                        <button type="submit" class="btn btn-danger btn-xs" title="إزالة">✕</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (!$ride->isFull() && $unassigned->isNotEmpty())
                    <form action="{{ route('admin.events.rides.add-passenger', $event) }}" method="POST"
                        class="ride-add-form">
                        @csrf
                        <input type="hidden" name="ride_id" value="{{ $ride->id }}">
                        <select name="registration_id" required>
                            <option value="">— إضافة راكب —</option>
                            @foreach ($unassigned as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} —
                                    {{ $u->areaModel?->name ?? $u->area }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-success btn-sm">✅ إضافة</button>
                    </form>
                @endif
            </div>
        @empty
            <div class="empty-state">
                <span class="emoji">🛣️</span>
                <h3>لا توجد رحلات بعد</h3>
                <p>استخدم زر "التوزيع التلقائي" أو أنشئ رحلة يدوية</p>
            </div>
        @endforelse
    </div>
@endsection
