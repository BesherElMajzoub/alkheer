<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - طريق الخير</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(160deg, #0a1628 0%, #0F3D75 40%, #1a5fa8 100%);
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
            background: radial-gradient(circle, rgba(54, 194, 255, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -150px;
            right: -150px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(24, 144, 255, 0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 52px 44px;
            width: 100%;
            max-width: 430px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 1;
        }

        .login-icon {
            width: 64px;
            height: 64px;
            background: #EAF4FF;
            color: #1890FF;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 24px;
            border: 1px solid rgba(24, 144, 255, 0.12);
        }

        .login-card h1 {
            text-align: center;
            font-size: 24px;
            font-weight: 800;
            color: #0F3D75;
            margin-bottom: 8px;
        }

        .login-card p {
            text-align: center;
            color: #6B7A90;
            font-size: 15px;
            margin-bottom: 36px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #15314B;
            margin-bottom: 10px;
        }

        .form-group input {
            width: 100%;
            padding: 16px 18px;
            border: 1.5px solid #E6EDF5;
            border-radius: 12px;
            font-family: 'Cairo', sans-serif;
            font-size: 15px;
            color: #15314B;
            background: #fff;
            transition: all 0.2s ease;
            direction: rtl;
        }

        .form-group input:focus {
            outline: none;
            border-color: #1890FF;
            box-shadow: 0 0 0 4px rgba(24, 144, 255, 0.12);
        }

        .form-group input::placeholder {
            color: #A0AEC0;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: #1890FF;
            color: white;
            border: none;
            border-radius: 12px;
            font-family: 'Cairo', sans-serif;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(24, 144, 255, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            background: #0c7ee6;
            box-shadow: 0 6px 20px rgba(24, 144, 255, 0.35);
        }

        .alert-error {
            background: #FEF2F2;
            color: #991B1B;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid #FECACA;
            text-align: center;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 28px;
            color: #6B7A90;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #1890FF;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 40px 28px;
            }
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
