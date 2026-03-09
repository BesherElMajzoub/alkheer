@extends('layouts.app')

@section('title', 'تم التسجيل بنجاح - طريق الخير')

@section('styles')
    <style>
        .success-page {
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 0;
        }

        .success-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 60px 48px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            text-align: center;
            max-width: 520px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .success-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--gold), var(--primary));
        }

        .success-icon {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.2));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 44px;
            margin: 0 auto 24px;
            animation: scaleIn 0.5s ease;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }

            to {
                transform: scale(1);
            }
        }

        .success-card h1 {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 12px;
        }

        .success-card p {
            font-size: 17px;
            color: var(--text-muted);
            margin-bottom: 8px;
            line-height: 1.8;
        }

        .success-event-name {
            display: inline-block;
            background: rgba(13, 124, 61, 0.08);
            padding: 8px 20px;
            border-radius: 99px;
            color: var(--primary);
            font-weight: 700;
            font-size: 16px;
            margin: 16px 0 32px;
        }

        .success-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }
    </style>
@endsection

@section('content')
    <section class="success-page">
        <div class="container">
            <div class="success-card">
                <div class="success-icon">✅</div>
                <h1>تم التسجيل بنجاح!</h1>
                <p>بارك الله فيك، تم تسجيل حضورك</p>

                @if (session('event_name'))
                    <div class="success-event-name">{{ session('event_name') }}</div>
                @endif

                <p>نسأل الله لك التوفيق والسداد</p>

                <div class="success-actions">
                    <a href="/" class="btn btn-primary">← العودة للرئيسية</a>
                </div>
            </div>
        </div>
    </section>
@endsection
