<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Аптека "Здоровье" — Онлайн каталог</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root { --primary-color: #00a884; --secondary-color: #2c3e50; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display: flex; flex-direction: column; min-height: 100vh; background-color: #fcfcfc; }
        .navbar { background-color: white; border-bottom: 2px solid #f8f9fa; }
        .footer { background-color: var(--secondary-color); color: white; margin-top: auto; }
        .main-content { flex: 1; }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); color: white; }
        .btn-primary:hover { background-color: #008f70; color: white; }
        .nav-link.active { color: var(--primary-color) !important; }
    </style>
</head>
<body>

    <header class="navbar navbar-expand-lg navbar-light sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center text-primary" href="{{ route('landing.home') }}">
                <i class="bi bi-capsule-pill me-2 fs-3"></i> Аптека "Здоровье"
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.home') ? 'active fw-bold' : '' }}" href="{{ route('landing.home') }}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.catalog') ? 'active fw-bold' : '' }}" href="{{ route('landing.catalog') }}">Каталог</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('landing.contact') }}">Контакты</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <form action="{{ route('landing.catalog') }}" method="GET" class="d-none d-md-flex">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Поиск..." value="{{ request('search') }}">
                    </form>
                    
                    <a href="{{ route('cart') }}" class="position-relative text-dark text-decoration-none mx-2">
                        <i class="bi bi-cart3 fs-4"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                            @auth
                                {{ Auth::user()->cartItems ? Auth::user()->cartItems->sum('quantity') : 0 }}
                            @else
                                0
                            @endauth
                        </span>
                    </a>

                    @guest
                        <div class="d-flex gap-2">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm px-3">Войти</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-3">Регистрация</a>
                            @endif
                        </div>
                    @else
                        <div class="dropdown">
                            <a class="btn btn-outline-secondary btn-sm dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
<ul class="dropdown-menu dropdown-menu-end shadow border-0">
    {{-- Ссылка только для админа --}}
    @if(Auth::user()->role === 'admin')
        <li><a class="dropdown-item fw-bold text-primary" href="{{ route('admin') }}">
            <i class="bi bi-speedometer2 me-1"></i> Панель управления
        </a></li>
        <li><hr class="dropdown-divider"></li>
    @endif

    <li><a class="dropdown-item" href="{{ route('landing.profile') }}">Профиль</a></li>
    <li><a class="dropdown-item" href="{{ route('landing.orders') }}">Заказы</a></li>
    <li><hr class="dropdown-divider"></li>
    <li>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="dropdown-item text-danger">Выйти</button>
        </form>
    </li>
</ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="footer py-5 mt-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-4 text-center text-md-start">
                    <h5 class="fw-bold mb-3">Аптека "Здоровье"</h5>
                    <p class="text-white-50 small">Ваш надежный партнер в мире здоровья. Мы работаем для вас 24/7.</p>
                </div>
                <div class="col-md-8 text-center text-md-end">
                    <p class="mb-0 text-white-50 small">&copy; 2026 Аптека "Здоровье". Все права защищены.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>