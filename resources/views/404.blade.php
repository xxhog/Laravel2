<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Страница не найдена</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Наш милый CSS -->


    <style>
        body {
            background: linear-gradient(135deg, #fff 0%, #fafafa 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            margin: 0;
            padding: 20px;
        }

        .error-container {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }

        .error-number {
            font-size: 8rem;
            font-weight: 800;
            color: #333;
            line-height: 1;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .error-number span {
            color: #ffd6e7;
            display: inline-block;
            transform: scale(1.1);
            margin: 0 0.5rem;
        }

        .error-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .error-text {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .error-accent {
            color: #ffd6e7;
            font-weight: 600;
        }

        .error-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .error-btn-pink {
            background-color: #ffd6e7;
            border: 2px solid #ffd6e7;
            color: #333;
            padding: 0.75rem 2rem;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .error-btn-pink:hover {
            background-color: #ffc0d0;
            border-color: #ffc0d0;
            color: #333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 214, 231, 0.4);
        }

        .error-btn-black {
            background-color: #333;
            border: 2px solid #333;
            color: white;
            padding: 0.75rem 2rem;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .error-btn-black:hover {
            background-color: transparent;
            color: #333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .error-divider {
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, transparent, #ffd6e7, transparent);
            margin: 2rem auto;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .error-float {
            animation: float 3s ease-in-out infinite;
        }

        @media (max-width: 768px) {
            .error-number { font-size: 6rem; }
            .error-title { font-size: 1.5rem; }
            .error-text { font-size: 1rem; }
            .error-buttons { flex-direction: column; }
            .error-btn-pink, .error-btn-black { width: 100%; }
        }
    </style>
</head>
<body>
<div class="error-container">
    <!-- ЦИФРА 404 -->
    <div class="error-number error-float">
        4<span>0</span>4
    </div>

    <!-- ЗАГОЛОВОК -->
    <h1 class="error-title">
        Ой! <span class="error-accent">Страница</span> не найдена
    </h1>

    <!-- ТЕКСТ -->
    <p class="error-text">
        Кажется, вы забрели не туда. Возможно, эта страница
        <span class="error-accent">ещё в разработке</span> или была удалена.
    </p>

    <!-- ИКОНКА -->
    <div class="error-float" style="margin: 2rem auto; max-width: 200px;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <circle cx="12" cy="12" r="10" stroke="#333" stroke-width="1.5"/>
            <path d="M12 8v4M12 16h.01" stroke="#333" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </div>

    <!-- РАЗДЕЛИТЕЛЬ -->
    <div class="error-divider"></div>

    <!-- КНОПКИ -->
    <div class="error-buttons">
        <a href="/" class="error-btn-pink">
            На главную
        </a>
        <a href="/catalog" class="error-btn-black">
            В каталог
        </a>
    </div>

    <!-- ССЫЛКА НА КОНТАКТЫ -->
    <p style="margin-top: 2rem; font-size: 0.9rem; color: #666;">
        я потом все сделаю!!!
    </p>
</div>
</body>
</html>
