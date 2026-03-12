@extends('layouts.app')

@section('title', $event->name . ' - طريق الخير')

@section('styles')
    <style>
        .event-detail {
            padding: 56px 0 80px;
        }

        .event-detail-grid {
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 36px;
            align-items: start;
        }

        .event-info-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 40px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
        }

        .event-info-card h1 {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 28px;
            line-height: 1.4;
        }

        .info-list {
            list-style: none;
            margin-bottom: 32px;
            background: var(--bg);
            border-radius: var(--radius-sm);
            padding: 8px 24px;
            border: 1px solid var(--border);
        }

        .info-list li {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 18px 0;
            border-bottom: 1px solid var(--border);
            font-size: 15px;
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .info-list .info-icon {
            width: 36px;
            height: 36px;
            background: var(--primary-soft);
            border-radius: var(--radius-xs);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .info-list .label {
            color: var(--text-secondary);
            min-width: 90px;
            font-weight: 500;
        }

        .info-list .value {
            font-weight: 700;
            color: var(--text);
        }

        .event-notes {
            background: var(--primary-soft);
            border-radius: var(--radius-sm);
            padding: 24px;
            border-right: 4px solid var(--primary);
            margin-top: 20px;
        }

        .event-notes h4 {
            color: var(--primary);
            margin-bottom: 10px;
            font-size: 15px;
            font-weight: 700;
        }

        .event-notes p {
            color: var(--text-secondary);
            font-size: 15px;
            line-height: 1.8;
        }

        /* ── Registration Form ── */
        .reg-form-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 40px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            position: sticky;
            top: 90px;
        }

        .reg-form-card h2 {
            font-size: 22px;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .reg-form-card .subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 10px;
        }

        .form-group label .required {
            color: var(--error);
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
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
            box-shadow: 0 0 0 4px rgba(24, 144, 255, 0.12);
        }

        .form-control::placeholder {
            color: #A0AEC0;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%236B7A90' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: left 16px center;
            padding-left: 40px;
        }

        .form-error {
            color: var(--error);
            font-size: 13px;
            margin-top: 8px;
            font-weight: 600;
        }

        /* ── Segmented Toggle ── */
        .radio-group {
            display: flex;
            gap: 0;
            background: var(--bg);
            border-radius: var(--radius-sm);
            padding: 4px;
            border: 1px solid var(--border);
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
            border-radius: var(--radius-xs);
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
            font-weight: 700;
            font-size: 15px;
            color: var(--text-secondary);
            background: transparent;
            margin-bottom: 0;
        }

        .radio-option input:checked+label {
            background: var(--bg-card);
            color: var(--primary);
            box-shadow: var(--shadow-sm);
        }

        .radio-option label:hover {
            color: var(--primary);
        }

        .conditional-field {
            display: none;
            animation: slideDown 0.3s ease;
        }

        .conditional-field.show {
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
            padding: 18px;
            font-size: 17px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 28px;
            transition: var(--transition-fast);
            padding: 8px 16px;
            border-radius: var(--radius-xs);
        }

        .back-link:hover {
            color: var(--primary);
            background: var(--primary-soft);
        }

        .full-state {
            text-align: center;
            padding: 64px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .full-state .full-icon {
            font-size: 52px;
            display: block;
            margin-bottom: 20px;
            opacity: 0.8;
        }

        .full-state h2 {
            justify-content: center;
            margin-bottom: 12px;
        }

        @media (max-width: 900px) {
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
                <div class="event-info-card animate-in">
                    <h1>{{ $event->name }}</h1>

                    <ul class="info-list">
                        <li>
                            <span class="info-icon">📅</span>
                            <span class="label">التاريخ</span>
                            <span class="value">{{ $event->event_date->format('Y/m/d') }}</span>
                        </li>
                        <li>
                            <span class="info-icon">🕐</span>
                            <span class="label">الوقت</span>
                            <span class="value">{{ $event->event_date->format('h:i A') }}</span>
                        </li>
                        <li>
                            <span class="info-icon">📍</span>
                            <span class="label">المكان</span>
                            <span class="value">{{ $event->location }}</span>
                        </li>
                        <li>
                            <span class="info-icon">👥</span>
                            <span class="label">المسجلين</span>
                            <span class="value">
                                {{ $event->registrations_count }}
                                @if ($event->max_attendees)
                                    / {{ $event->max_attendees }}
                                @endif
                            </span>
                        </li>
                        <li>
                            <span class="info-icon">📊</span>
                            <span class="label">الحالة</span>
                            @if ($event->isFull())
                                <span class="event-badge badge-full">اكتمل العدد</span>
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
                    <div class="reg-form-card animate-in animate-delay-1">
                        <h2>✍️ سجل حضورك</h2>
                        <p class="subtitle">أكمل البيانات التالية للتسجيل في الفعالية</p>

                        <form action="{{ route('events.register', $event) }}" method="POST" id="regForm">
                            @csrf

                            <div class="form-group">
                                <label>الاسم الكامل <span class="required">*</span></label>
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
                                <select name="area_id" class="form-control" required>
                                    <option value="">— اختر منطقتك —</option>
                                    @foreach ($axes as $axis)
                                        <optgroup label="{{ $axis->name }}">
                                            @foreach ($axis->areas as $area)
                                                <option value="{{ $area->id }}"
                                                    {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                                    {{ $area->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @error('area_id')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>أقرب نقطة / معلم</label>
                                <input type="text" name="nearest_landmark" class="form-control"
                                    placeholder="مثال: بجانب جامع النور" value="{{ old('nearest_landmark') }}">
                            </div>

                            <div class="form-group">
                                <label>هل لديك سيارة؟ <span class="required">*</span></label>
                                <div class="radio-group">
                                    <div class="radio-option">
                                        <input type="radio" name="has_car" id="has_car_no" value="0"
                                            {{ old('has_car', '0') == '0' ? 'checked' : '' }} onchange="toggleCarFields()">
                                        <label for="has_car_no">🚶 لا</label>
                                    </div>
                                    <div class="radio-option">
                                        <input type="radio" name="has_car" id="has_car_yes" value="1"
                                            {{ old('has_car') == '1' ? 'checked' : '' }} onchange="toggleCarFields()">
                                        <label for="has_car_yes">🚗 نعم</label>
                                    </div>
                                </div>
                            </div>

                            {{-- Fields for car owners --}}
                            <div class="conditional-field" id="carFields">
                                <div class="form-group">
                                    <label>عدد المقاعد المتاحة</label>
                                    <input type="number" name="available_seats" class="form-control"
                                        placeholder="كم مقعد متاح في سيارتك؟" min="1" max="20"
                                        value="{{ old('available_seats') }}">
                                </div>

                                <div class="form-group">
                                    <label>هل أنت مستعد للتوصيل؟</label>
                                    <div class="radio-group">
                                        <div class="radio-option">
                                            <input type="radio" name="willing_to_drive" id="willing_no" value="0"
                                                {{ old('willing_to_drive', '0') == '0' ? 'checked' : '' }}>
                                            <label for="willing_no">لا</label>
                                        </div>
                                        <div class="radio-option">
                                            <input type="radio" name="willing_to_drive" id="willing_yes"
                                                value="1" {{ old('willing_to_drive') == '1' ? 'checked' : '' }}>
                                            <label for="willing_yes">نعم، مستعد</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Fields for non-car owners --}}
                            <div class="conditional-field" id="noCarFields">
                                <div class="form-group">
                                    <label>هل تحتاج توصيل؟</label>
                                    <div class="radio-group">
                                        <div class="radio-option">
                                            <input type="radio" name="needs_ride" id="needs_ride_yes" value="1"
                                                {{ old('needs_ride', '1') == '1' ? 'checked' : '' }}>
                                            <label for="needs_ride_yes">نعم، أحتاج توصيل</label>
                                        </div>
                                        <div class="radio-option">
                                            <input type="radio" name="needs_ride" id="needs_ride_no" value="0"
                                                {{ old('needs_ride') == '0' ? 'checked' : '' }}>
                                            <label for="needs_ride_no">لا حاجة</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-submit">تسجيل الحضور ✓</button>
                        </form>
                    </div>
                @else
                    <div class="reg-form-card full-state animate-in animate-delay-1">
                        <span class="full-icon">🚫</span>
                        <h2>الفعالية ممتلئة</h2>
                        <p class="subtitle" style="margin-bottom: 0;">عذراً، تم الوصول للحد الأقصى من المسجلين</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function toggleCarFields() {
            const hasCar = document.getElementById('has_car_yes').checked;
            document.getElementById('carFields').classList.toggle('show', hasCar);
            document.getElementById('noCarFields').classList.toggle('show', !hasCar);
        }

        document.addEventListener('DOMContentLoaded', toggleCarFields);
    </script>
@endsection
