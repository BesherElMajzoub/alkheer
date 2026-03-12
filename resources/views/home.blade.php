@extends('layouts.app')

@section('title', 'طريق الخير - منصة تنظيم الفعاليات الإسلامية')

@section('hero')
    <section class="hero">
        <div class="container">
            <div class="hero-grid">
                {{-- Right column: Text --}}
                <div class="hero-content animate-in">
                    <div class="hero-badge">
                        ✨ منصة ذكية لتنظيم الفعاليات
                    </div>
                    <h1>تنظيم الفعاليات والخدمات المجتمعية بروح عصرية وهوية إسلامية</h1>
                    <p>سجّل حضورك وتابع تفاصيل الدروس والفعاليات في المساجد بسهولة، مع تنسيق مريح للتوصيل والمشاركة
                        المجتمعية.</p>
                    <div class="hero-actions">
                        <a href="#events" class="btn btn-primary btn-lg">استكشف الفعاليات</a>
                        <a href="#video" class="btn btn-outline btn-lg">شاهد التعريف</a>
                    </div>
                </div>

                {{-- Left column: Video --}}
                <div class="hero-visual animate-in animate-delay-2">
                    <div class="hero-video-wrapper">
                        <div class="video-inner">
                            <iframe src="https://www.youtube.com/embed/o3L1-hjU_IY?si=oFdiE__oQ_IleQrQ"
                                title="تعريف منصة طريق الخير"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')

    {{-- ── Video Intro Section ── --}}
    <section class="section" id="video" style="background: #fff;">
        <div class="container">
            <div class="section-header">
                <div class="section-label">🎬 تعرّف على المنصة</div>
                <h2 class="section-title">شاهد كيف تعمل المنصة</h2>
                <p class="section-subtitle">في دقائق قليلة، تعرّف على كيفية تنظيم الفعاليات والتسجيل والتوصيل بكل سهولة</p>
            </div>
            <div style="max-width: 800px; margin: 0 auto;">
                <div class="hero-video-wrapper animate-in animate-delay-1">
                    <div class="video-inner">
                        <iframe src="https://www.youtube.com/embed/o3L1-hjU_IY?si=oFdiE__oQ_IleQrQ"
                            title="تعريف منصة طريق الخير"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Upcoming Events Section ── --}}
    <section class="section" id="events">
        <div class="container">
            <div class="section-header">
                <div class="section-label">📅 الفعاليات القادمة</div>
                <h2 class="section-title">سجّل حضورك في الفعاليات المتاحة</h2>
                <p class="section-subtitle">تصفّح الفعاليات القادمة وسجّل حضورك بنقرة واحدة</p>
            </div>

            @if ($events->isEmpty())
                <div class="empty-state animate-in">
                    <span class="empty-icon">📭</span>
                    <h3>لا توجد فعاليات قادمة حالياً</h3>
                    <p>ترقبوا الفعاليات الجديدة قريباً بإذن الله</p>
                </div>
            @else
                <div class="events-grid">
                    @foreach ($events as $event)
                        <div class="event-card animate-in animate-delay-{{ ($loop->index % 3) + 1 }}">
                            <div class="event-card-header">
                                <h3>{{ $event->name }}</h3>
                            </div>

                            <div class="event-meta">
                                <div class="event-meta-item">
                                    <span class="meta-icon">📅</span>
                                    {{ $event->event_date->format('Y/m/d') }}
                                </div>
                                <div class="event-meta-item">
                                    <span class="meta-icon">🕐</span>
                                    {{ $event->event_date->format('h:i A') }}
                                </div>
                                <div class="event-meta-item">
                                    <span class="meta-icon">📍</span>
                                    {{ $event->location }}
                                </div>
                                <div class="event-meta-item">
                                    <span class="meta-icon">👥</span>
                                    {{ $event->registrations_count }} مسجل
                                </div>
                            </div>

                            @if ($event->description)
                                <p class="event-description">{{ Str::limit($event->description, 120) }}</p>
                            @endif

                            <div class="event-card-footer">
                                @if ($event->isFull())
                                    <span class="event-badge badge-full">اكتمل العدد</span>
                                @elseif($event->max_attendees)
                                    <span class="event-badge badge-limited">متبقي {{ $event->remaining_seats }}
                                        مقعد</span>
                                @else
                                    <span class="event-badge badge-open">مفتوحة للتسجيل</span>
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

    {{-- ── Features Section ── --}}
    <section class="section" style="background: #fff;">
        <div class="container">
            <div class="section-header">
                <div class="section-label">🌟 مزايا المنصة</div>
                <h2 class="section-title">لماذا طريق الخير؟</h2>
                <p class="section-subtitle">نقدم لك أدوات حديثة وسهلة لتنظيم الفعاليات المجتمعية والإسلامية</p>
            </div>

            <div class="features-grid">
                <div class="feature-card animate-in animate-delay-1">
                    <div class="feature-icon">⚡</div>
                    <h3>تسجيل سريع وسهل</h3>
                    <p>سجّل حضورك لأي فعالية بخطوات بسيطة وواضحة، بدون تعقيد أو حسابات</p>
                </div>
                <div class="feature-card animate-in animate-delay-2">
                    <div class="feature-icon">🚗</div>
                    <h3>تنسيق التوصيل</h3>
                    <p>نظام ذكي لتنسيق التوصيل بين أصحاب السيارات والمحتاجين للتوصيل</p>
                </div>
                <div class="feature-card animate-in animate-delay-3">
                    <div class="feature-icon">📊</div>
                    <h3>لوحة تحكم متكاملة</h3>
                    <p>تابع الإحصائيات والتسجيلات وأدِر الفعاليات من لوحة تحكم احترافية</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Stats Section ── --}}
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item animate-in animate-delay-1">
                    <div class="stat-number">{{ $events->count() }}+</div>
                    <div class="stat-label">فعالية منظمة</div>
                </div>
                <div class="stat-item animate-in animate-delay-2">
                    <div class="stat-number">{{ $events->sum('registrations_count') }}+</div>
                    <div class="stat-label">مشارك مسجل</div>
                </div>
                <div class="stat-item animate-in animate-delay-3">
                    <div class="stat-number">{{ $events->where('is_active', true)->count() }}</div>
                    <div class="stat-label">فعالية نشطة حالياً</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CTA Section ── --}}
    <section class="cta-section">
        <div class="container">
            <div class="cta-card animate-in">
                <h2>هل لديك فعالية قادمة؟</h2>
                <p>تواصل معنا لتنظيم فعاليتك القادمة من خلال منصة طريق الخير</p>
                <a href="/#events" class="btn btn-primary btn-lg">ابدأ الآن</a>
            </div>
        </div>
    </section>
@endsection
