@extends('admin.layouts.app')

@section('title', 'تعديل: ' . $event->name)

@section('content')
    <div class="admin-header">
        <div>
            <h1>✏️ تعديل الفعالية</h1>
            <p class="admin-header-sub">{{ $event->name }}</p>
        </div>
        <a href="/admin/events/{{ $event->id }}" class="btn btn-outline">→ العودة</a>
    </div>

    <div class="admin-card">
        <form action="{{ route('admin.events.update', $event) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>اسم الفعالية <span class="required">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $event->name) }}" required>
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>وصف الفعالية</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>المكان <span class="required">*</span></label>
                    <input type="text" name="location" class="form-control"
                        value="{{ old('location', $event->location) }}" required>
                    @error('location')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>التاريخ والوقت <span class="required">*</span></label>
                    <input type="datetime-local" name="event_date" class="form-control"
                        value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required>
                    @error('event_date')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label>العدد الأقصى للحضور</label>
                <input type="number" name="max_attendees" class="form-control" min="1"
                    value="{{ old('max_attendees', $event->max_attendees) }}">
                <div class="form-hint">اتركه فارغاً إذا كانت الفعالية مفتوحة بدون حد أقصى</div>
                @error('max_attendees')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>ملاحظات</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes', $event->notes) }}</textarea>
                @error('notes')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        {{ old('is_active', $event->is_active) ? 'checked' : '' }}>
                    <label for="is_active" style="margin-bottom: 0; cursor: pointer;">فعالية نشطة (ظهور في الموقع)</label>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">💾 حفظ التعديلات</button>
                <a href="/admin/events/{{ $event->id }}" class="btn btn-outline">إلغاء</a>
            </div>
        </form>
    </div>
@endsection
