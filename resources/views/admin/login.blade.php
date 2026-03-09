<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - طريق الخير</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0a1f12 0%, #0d3520 40%, #0d7c3d 100%);
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: -200px;
            left: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(201, 162, 39, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -150px;
            right: -150px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(13, 124, 61, 0.2) 0%, transparent 70%);
            pointer-events: none;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 1;
        }

        .login-icon {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #0d7c3d, #1a9e50);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 24px;
            box-shadow: 0 8px 24px rgba(13, 124, 61, 0.3);
        }

        .login-card h1 {
            text-align: center;
            font-size: 26px;
            font-weight: 800;
            color: #065f2d;
            margin-bottom: 8px;
        }

        .login-card p {
            text-align: center;
            color: #5a6e5f;
            font-size: 15px;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1a2e1f;
            margin-bottom: 10px;
        }

        .form-group input {
            width: 100%;
            padding: 16px 18px;
            border: 2px solid #d4e4d9;
            border-radius: 14px;
            font-family: 'Tajawal', sans-serif;
            font-size: 16px;
            color: #1a2e1f;
            background: #f8faf9;
            transition: all 0.3s ease;
            direction: rtl;
        }

        .form-group input:focus {
            outline: none;
            border-color: #0d7c3d;
            box-shadow: 0 0 0 4px rgba(13, 124, 61, 0.1);
            background: white;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #0d7c3d, #1a9e50);
            color: white;
            border: none;
            border-radius: 14px;
            font-family: 'Tajawal', sans-serif;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(13, 124, 61, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(13, 124, 61, 0.4);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            border: 1px solid rgba(239, 68, 68, 0.2);
            text-align: center;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 24px;
            color: #5a6e5f;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #0d7c3d;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-icon">🔐</div>
        <h1>لوحة التحكم</h1>
        <p>أدخل كلمة المرور للوصول إلى لوحة التحكم</p>

        @if (session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>🔑 كلمة المرور</label>
                <input type="password" name="password" placeholder="أدخل كلمة المرور" required autofocus>
            </div>
            <button type="submit" class="btn-login">دخول ←</button>
        </form>

        <a href="/" class="back-link">→ العودة للموقع</a>
    </div>
</body>

</html>
