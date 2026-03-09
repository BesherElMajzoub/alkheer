@extends('layouts.app')

@section('title', 'طريق الخير - الفعاليات القادمة')

@section('hero')
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <span class="hero-icon">🕌</span>
                <h1>طريق الخير</h1>
                <p>نظام تنظيم حضور الطلاب للدروس والفعاليات في المساجد وتسهيل التوصيل</p>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="section">
        <div class="container">
            <h2 class="section-title">
                <span class="icon">📅</span>
                الفعاليات القادمة
            </h2>

            @if ($events->isEmpty())
                <div class="empty-state">
                    <span class="emoji">📭</span>
                    <h3>لا توجد فعاليات قادمة حالياً</h3>
                    <p>ترقبوا الفعاليات الجديدة قريباً بإذن الله</p>
                </div>
            @else
                <div class="events-grid">
                    @foreach ($events as $event)
                        <div class="event-card">
                            <div class="event-card-header">
                                <h3>{{ $event->name }}</h3>
                            </div>

                            <div class="event-meta">
                                <div class="event-meta-item">
                                    <span class="emoji">📅</span>
                                    {{ $event->event_date->format('Y/m/d') }}
                                </div>
                                <div class="event-meta-item">
                                    <span class="emoji">🕐</span>
                                    {{ $event->event_date->format('h:i A') }}
                                </div>
                                <div class="event-meta-item">
                                    <span class="emoji">📍</span>
                                    {{ $event->location }}
                                </div>
                                <div class="event-meta-item">
                                    <span class="emoji">👥</span>
                                    {{ $event->registrations_count }} مسجل
                                </div>
                            </div>

                            @if ($event->description)
                                <p class="event-description">{{ Str::limit($event->description, 120) }}</p>
                            @endif

                            <div class="event-card-footer">
                                @if ($event->isFull())
                                    <span class="event-badge badge-full">⛔ ممتلئة</span>
                                @elseif($event->max_attendees)
                                    <span class="event-badge badge-limited">🪑 متبقي {{ $event->remaining_seats }}
                                        مقعد</span>
                                @else
                                    <span class="event-badge badge-open">✅ مفتوحة للجميع</span>
                                @endif

                                @if (!$event->isFull())
                                    <a href="{{ route('events.show', $event) }}" class="btn btn-primary btn-sm">سجل الآن
                                        ←</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
