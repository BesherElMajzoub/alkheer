@extends('admin.layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
    <div class="admin-header">
        <div>
            <h1>📊 لوحة التحكم</h1>
            <p class="admin-header-sub">مرحباً بك في نظام طريق الخير</p>
        </div>
        <a href="/admin/events/create" class="btn btn-primary">➕ إضافة فعالية</a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📅</div>
            <div class="stat-value">{{ $totalEvents }}</div>
            <div class="stat-label">إجمالي الفعاليات</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-value">{{ $activeEvents }}</div>
            <div class="stat-label">فعاليات نشطة</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📆</div>
            <div class="stat-value">{{ $upcomingEvents }}</div>
            <div class="stat-label">فعاليات قادمة</div>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">📋 آخر الفعاليات</h3>
            <a href="/admin/events" class="btn btn-outline btn-sm">عرض الكل</a>
        </div>

        @if ($recentEvents->isEmpty())
            <div class="empty-state">
                <span class="emoji">📭</span>
                <h3>لا توجد فعاليات بعد</h3>
                <p>أنشئ أول فعالية من خلال زر "إضافة فعالية"</p>
            </div>
        @else
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>الفعالية</th>
                        <th>التاريخ</th>
                        <th>المكان</th>
                        <th>المسجلين</th>
                        <th>الحالة</th>
                        <th>إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentEvents as $event)
                        <tr>
                            <td><strong>{{ $event->name }}</strong></td>
                            <td>{{ $event->event_date->format('Y/m/d h:i A') }}</td>
                            <td>{{ $event->location }}</td>
                            <td>
                                <span class="badge badge-primary">{{ $event->registrations_count }}</span>
                            </td>
                            <td>
                                @if ($event->is_active)
                                    <span class="badge badge-success">نشطة</span>
                                @else
                                    <span class="badge badge-danger">متوقفة</span>
                                @endif
                            </td>
                            <td>
                                <a href="/admin/events/{{ $event->id }}" class="btn btn-outline btn-xs">عرض</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
