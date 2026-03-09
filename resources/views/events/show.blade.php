@extends('layouts.app')

@section('title', $event->name . ' - طريق الخير')

@section('styles')
    <style>
        .event-detail {
            padding: 48px 0;
        }

        .event-detail-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 32px;
            align-items: start;
        }

        .event-info-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 36px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }

        .event-info-card h1 {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 24px;
        }

        .info-list {
            list-style: none;
            margin-bottom: 24px;
        }

        .info-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
            font-size: 16px;
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .info-list .label {
            color: var(--text-muted);
            min-width: 100px;
        }

        .info-list .value {
            font-weight: 600;
        }

        .event-notes {
            background: rgba(201, 162, 39, 0.08);
            border-radius: var(--radius-sm);
            padding: 20px;
            border-right: 4px solid var(--gold);
            margin-top: 16px;
        }

        .event-notes h4 {
            color: var(--gold);
            margin-bottom: 8px;
            font-size: 15px;
        }

        .event-notes p {
            color: var(--text-muted);
            font-size: 15px;
            line-height: 1.8;
        }

        /* ── Registration Form ── */
        .reg-form-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 36px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            position: sticky;
            top: 90px;
        }

        .reg-form-card h2 {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .reg-form-card .subtitle {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 24px;
        }

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
            padding: 14px 16px;
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
            box-shadow: 0 0 0 4px rgba(13, 124, 61, 0.1);
        }

        .form-control::placeholder {
            color: #aab8af;
        }

        .form-error {
            color: var(--error);
            font-size: 13px;
            margin-top: 6px;
        }

        /* ── Radio Group ── */
        .radio-group {
            display: flex;
            gap: 12px;
        }

        .radio-option {
            flex: 1;
            position: relative;
        }

        .radio-option input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .radio-option label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px;
            border: 2px solid var(--border);
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
            font-weight: 600;
        }

        .radio-option input:checked+label {
            border-color: var(--primary);
            background: rgba(13, 124, 61, 0.06);
            color: var(--primary);
        }

        .radio-option label:hover {
            border-color: var(--primary-light);
        }

        .seats-field {
            display: none;
            animation: slideDown 0.3s ease;
        }

        .seats-field.show {
            display: block;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            font-size: 17px;
            justify-content: center;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 24px;
            transition: var(--transition);
        }

        .back-link:hover {
            color: var(--primary);
        }

        @media (max-width: 868px) {
            .event-detail-grid {
                grid-template-columns: 1fr;
            }

            .reg-form-card {
                position: static;
            }
        }
    </style>
@endsection

@section('content')
    <section class="event-detail">
        <div class="container">
            <a href="/" class="back-link">→ العودة للفعاليات</a>

            @if (session('error'))
                <div class="alert alert-error">⚠️ {{ session('error') }}</div>
            @endif

            <div class="event-detail-grid">
                <div class="event-info-card">
                    <h1>{{ $event->name }}</h1>

                    <ul class="info-list">
                        <li>
                            <span class="emoji">📅</span>
                            <span class="label">التاريخ</span>
                            <span class="value">{{ $event->event_date->format('Y/m/d') }}</span>
                        </li>
                        <li>
                            <span class="emoji">🕐</span>
                            <span class="label">الوقت</span>
                            <span class="value">{{ $event->event_date->format('h:i A') }}</span>
                        </li>
                        <li>
                            <span class="emoji">📍</span>
                            <span class="label">المكان</span>
                            <span class="value">{{ $event->location }}</span>
                        </li>
                        <li>
                            <span class="emoji">👥</span>
                            <span class="label">المسجلين</span>
                            <span class="value">{{ $event->registrations_count }}
                                @if ($event->max_attendees)
                                    / {{ $event->max_attendees }}
                                @endif
                            </span>
                        </li>
                        <li>
                            <span class="emoji">📊</span>
                            <span class="label">الحالة</span>
                            @if ($event->isFull())
                                <span class="event-badge badge-full">ممتلئة</span>
                            @elseif($event->max_attendees)
                                <span class="event-badge badge-limited">متبقي {{ $event->remaining_seats }} مقعد</span>
                            @else
                                <span class="event-badge badge-open">مفتوحة</span>
                            @endif
                        </li>
                    </ul>

                    @if ($event->description)
                        <p class="event-description">{{ $event->description }}</p>
                    @endif

                    @if ($event->notes)
                        <div class="event-notes">
                            <h4>📝 ملاحظات</h4>
                            <p>{{ $event->notes }}</p>
                        </div>
                    @endif
                </div>

                @if (!$event->isFull())
                    <div class="reg-form-card">
                        <h2>✍️ سجل حضورك</h2>
                        <p class="subtitle">أكمل البيانات التالية للتسجيل في الفعالية</p>

                        <form action="{{ route('events.register', $event) }}" method="POST" id="regForm">
                            @csrf

                            <div class="form-group">
                                <label>الاسم <span class="required">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="أدخل اسمك الكامل"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>رقم الهاتف <span class="required">*</span></label>
                                <input type="tel" name="phone" class="form-control" placeholder="09xxxxxxxx"
                                    value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>المنطقة / الحي <span class="required">*</span></label>
                                <input type="text" name="area" class="form-control" placeholder="مثال: حي النور"
                                    value="{{ old('area') }}" required>
                                @error('area')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>هل لديك سيارة؟ <span class="required">*</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" name="has_car" id="has_car_no" value="0"
                                            {{ old('has_car', '0') == '0' ? 'checked' : '' }} onchange="toggleSeats()">
                                        <label for="has_car_no">🚶 لا</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" name="has_car" id="has_car_yes" value="1"
                                            {{ old('has_car') == '1' ? 'checked' : '' }} onchange="toggleSeats()">
                                        <label for="has_car_yes">🚗 نعم</label>
                                    </div>
                                </div>
                                @error('has_car')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group seats-field" id="seatsField">
                                <label>عدد المقاعد المتاحة</label>
                                <input type="number" name="available_seats" class="form-control"
                                    placeholder="كم مقعد متاح في سيارتك؟" min="1" max="20"
                                    value="{{ old('available_seats') }}">
                                @error('available_seats')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-submit">تسجيل الحضور ✓</button>
                        </form>
                    </div>
                @else
                    <div class="reg-form-card" style="text-align: center; padding: 48px 36px;">
                        <span style="font-size: 48px; display: block; margin-bottom: 16px;">🚫</span>
                        <h2 style="justify-content: center;">الفعالية ممتلئة</h2>
                        <p class="subtitle" style="margin-bottom: 0;">عذراً، تم الوصول للحد الأقصى من المسجلين</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function toggleSeats() {
            const hasCarYes = document.getElementById('has_car_yes');
            const seatsField = document.getElementById('seatsField');

            if (hasCarYes.checked) {
                seatsField.classList.add('show');
            } else {
                seatsField.classList.remove('show');
            }
        }

        // Run on page load
        document.addEventListener('DOMContentLoaded', toggleSeats);
    </script>
@endsection
