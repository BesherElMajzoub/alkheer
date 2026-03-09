@extends('admin.layouts.app')

@section('title', $event->name)

@section('styles')
    <style>
        .event-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .summary-item {
            background: var(--bg);
            border-radius: var(--radius-sm);
            padding: 16px 20px;
            text-align: center;
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
            color: var(--text-muted);
        }

        .transport-section {
            background: linear-gradient(135deg, rgba(18, 140, 126, 0.05), rgba(37, 211, 102, 0.05));
            border: 1px solid rgba(37, 211, 102, 0.15);
            border-radius: var(--radius);
            padding: 28px;
            margin-bottom: 24px;
        }

        .transport-title {
            font-size: 18px;
            font-weight: 700;
            color: #128C7E;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .driver-card {
            background: white;
            border-radius: var(--radius-sm);
            padding: 20px;
            margin-bottom: 16px;
            border: 1px solid var(--border);
            transition: var(--transition);
        }

        .driver-card:hover {
            box-shadow: var(--shadow);
        }

        .driver-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .driver-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .driver-avatar {
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

        .driver-name {
            font-weight: 700;
            font-size: 16px;
        }

        .driver-meta {
            font-size: 13px;
            color: var(--text-muted);
        }

        .driver-passengers {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px dashed var(--border);
        }

        .passenger-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            background: var(--bg);
            border-radius: 8px;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .passenger-item .name {
            font-weight: 600;
        }

        .assign-form {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px dashed var(--border);
        }

        .assign-form select {
            flex: 1;
            min-width: 180px;
            padding: 8px 12px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-family: 'Tajawal', sans-serif;
            font-size: 14px;
            color: var(--text);
            background: var(--bg);
            direction: rtl;
        }

        .assign-form select:focus {
            outline: none;
            border-color: var(--primary);
        }

        .reg-table-actions {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
    </style>
@endsection

@section('content')
    <div class="admin-header">
        <div>
            <h1>📋 {{ $event->name }}</h1>
            <p class="admin-header-sub">
                {{ $event->event_date->format('Y/m/d h:i A') }} | {{ $event->location }}
                @if ($event->is_active)
                    — <span style="color: var(--success);">نشطة</span>
                @else
                    — <span style="color: var(--error);">متوقفة</span>
                @endif
            </p>
        </div>
        <div class="btn-group">
            <a href="/admin/events/{{ $event->id }}/edit" class="btn btn-outline btn-sm">✏️ تعديل</a>
            <a href="/admin/events" class="btn btn-outline btn-sm">→ العودة</a>
        </div>
    </div>

    {{-- ── Event Summary ── --}}
    <div class="admin-card">
        <div class="event-summary">
            <div class="summary-item">
                <div class="number">{{ $event->registrations()->count() }}</div>
                <div class="label">إجمالي المسجلين</div>
            </div>
            <div class="summary-item">
                <div class="number">{{ $event->registrations()->drivers()->count() }}</div>
                <div class="label">🚗 لديهم سيارات</div>
            </div>
            <div class="summary-item">
                <div class="number">{{ $event->registrations()->needsRide()->count() }}</div>
                <div class="label">🚶 يحتاجون توصيل</div>
            </div>
            <div class="summary-item">
                <div class="number">{{ $event->registrations()->unassigned()->count() }}</div>
                <div class="label">⏳ بدون سائق</div>
            </div>
            <div class="summary-item">
                <div class="number">{{ $event->max_attendees ?? '∞' }}</div>
                <div class="label">الحد الأقصى</div>
            </div>
        </div>

        @if ($event->description)
            <p style="color: var(--text-muted); font-size: 15px; margin-bottom: 12px;">{{ $event->description }}</p>
        @endif

        @if ($event->notes)
            <div
                style="background: rgba(201,162,39,0.08); padding: 14px 18px; border-radius: 10px; border-right: 3px solid var(--gold); font-size: 14px; color: var(--text-muted);">
                📝 {{ $event->notes }}
            </div>
        @endif
    </div>

    {{-- ── Transportation Section ── --}}
    @if ($drivers->isNotEmpty())
        <div class="transport-section">
            <h3 class="transport-title">🚗 إدارة التوصيل</h3>

            @foreach ($drivers as $driver)
                <div class="driver-card">
                    <div class="driver-header">
                        <div class="driver-info">
                            <div class="driver-avatar">🚗</div>
                            <div>
                                <div class="driver-name">{{ $driver->name }}</div>
                                <div class="driver-meta">{{ $driver->area }} | {{ $driver->phone }} |
                                    {{ $driver->available_seats ?? '—' }} مقاعد | {{ $driver->passengers_count }} راكب
                                </div>
                            </div>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('admin.events.whatsapp', [$event, $driver]) }}" target="_blank"
                                class="btn btn-whatsapp btn-sm">
                                📱 إرسال واتساب
                            </a>
                        </div>
                    </div>

                    @if ($driver->passengers->isNotEmpty())
                        <div class="driver-passengers">
                            <div style="font-size: 13px; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">👥
                                الركاب المعيّنون:</div>
                            @foreach ($driver->passengers as $passenger)
                                <div class="passenger-item">
                                    <div>
                                        <span class="name">{{ $passenger->name }}</span>
                                        <span style="color: var(--text-muted);"> — {{ $passenger->area }}</span>
                                    </div>
                                    <form action="{{ route('admin.events.unassign-driver', $event) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="registration_id" value="{{ $passenger->id }}">
                                        <button type="submit" class="btn btn-danger btn-xs"
                                            title="إلغاء التعيين">✕</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($unassigned->isNotEmpty())
                        <form action="{{ route('admin.events.assign-driver', $event) }}" method="POST"
                            class="assign-form">
                            @csrf
                            <input type="hidden" name="driver_id" value="{{ $driver->id }}">
                            <select name="registration_id" required>
                                <option value="">— اختر طالب لتعيينه —</option>
                                @foreach ($unassigned as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }} — {{ $student->area }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-success btn-sm">✅ تعيين</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- ── Registrations Table ── --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">👥 قائمة المسجلين</h3>
        </div>

        <div class="filter-tabs">
            <a href="/admin/events/{{ $event->id }}?filter=all"
                class="filter-tab {{ $filter === 'all' ? 'active' : '' }}">
                📋 الكل ({{ $event->registrations()->count() }})
            </a>
            <a href="/admin/events/{{ $event->id }}?filter=drivers"
                class="filter-tab {{ $filter === 'drivers' ? 'active' : '' }}">
                🚗 لديهم سيارات ({{ $event->registrations()->drivers()->count() }})
            </a>
            <a href="/admin/events/{{ $event->id }}?filter=needs_ride"
                class="filter-tab {{ $filter === 'needs_ride' ? 'active' : '' }}">
                🚶 يحتاجون توصيل ({{ $event->registrations()->needsRide()->count() }})
            </a>
        </div>

        @if ($registrations->isEmpty())
            <div class="empty-state">
                <span class="emoji">📭</span>
                <h3>لا يوجد مسجلون</h3>
                <p>لم يسجل أحد في هذه الفعالية بعد</p>
            </div>
        @else
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الهاتف</th>
                        <th>المنطقة</th>
                        <th>سيارة</th>
                        <th>المقاعد</th>
                        <th>السائق المعيّن</th>
                        <th>تاريخ التسجيل</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registrations as $index => $reg)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $reg->name }}</strong></td>
                            <td dir="ltr" style="text-align: right;">{{ $reg->phone }}</td>
                            <td>{{ $reg->area }}</td>
                            <td>
                                @if ($reg->has_car)
                                    <span class="badge badge-success">🚗 نعم</span>
                                @else
                                    <span class="badge badge-warning">🚶 لا</span>
                                @endif
                            </td>
                            <td>{{ $reg->has_car ? $reg->available_seats ?? '—' : '—' }}</td>
                            <td>
                                @if ($reg->driver)
                                    <span class="badge badge-info">{{ $reg->driver->name }}</span>
                                @elseif(!$reg->has_car)
                                    <span class="badge badge-danger">غير معيّن</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td style="font-size: 13px; color: var(--text-muted);">
                                {{ $reg->created_at->format('m/d H:i') }}</td>
                            <td>
                                <div class="reg-table-actions">
                                    <form action="{{ route('admin.events.delete-registration', [$event, $reg]) }}"
                                        method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا التسجيل؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
