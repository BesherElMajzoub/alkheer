@extends('admin.layouts.app')

@section('title', 'إدارة الفعاليات')

@section('content')
    <div class="admin-header">
        <div>
            <h1>📅 إدارة الفعاليات</h1>
            <p class="admin-header-sub">عرض وإدارة جميع الفعاليات</p>
        </div>
        <a href="/admin/events/create" class="btn btn-primary">➕ إضافة فعالية</a>
    </div>

    <div class="admin-card">
        @if ($events->isEmpty())
            <div class="empty-state">
                <span class="emoji">📭</span>
                <h3>لا توجد فعاليات</h3>
                <p>أنشئ أول فعالية من خلال زر "إضافة فعالية"</p>
            </div>
        @else
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم الفعالية</th>
                        <th>التاريخ والوقت</th>
                        <th>المكان</th>
                        <th>الحد الأقصى</th>
                        <th>المسجلين</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>{{ $event->id }}</td>
                            <td><strong>{{ $event->name }}</strong></td>
                            <td>{{ $event->event_date->format('Y/m/d h:i A') }}</td>
                            <td>{{ $event->location }}</td>
                            <td>
                                @if ($event->max_attendees)
                                    {{ $event->max_attendees }}
                                @else
                                    <span class="badge badge-success">مفتوحة</span>
                                @endif
                            </td>
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
                                <div class="btn-group">
                                    <a href="/admin/events/{{ $event->id }}" class="btn btn-outline btn-xs">👁️ عرض</a>
                                    <a href="/admin/events/{{ $event->id }}/edit" class="btn btn-warning btn-xs">✏️
                                        تعديل</a>
                                    <form action="/admin/events/{{ $event->id }}" method="POST" style="display:inline"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذه الفعالية؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs">🗑️ حذف</button>
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
