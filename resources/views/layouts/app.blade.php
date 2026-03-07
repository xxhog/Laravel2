<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Аптека "Здоровье" — Забота о вас</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root { 
            --primary-color: #0d6efd; 
            --bg-light: #f8faff; 
            --card-radius: 20px;
        }

        body { 
            font-family: 'Inter', -apple-system, sans-serif; 
            display: flex; 
            flex-direction: column; 
            min-height: 100vh; 
            background-color: var(--bg-light); 
            color: #2c3e50;
        }

        .navbar { 
            background-color: rgba(255, 255, 255, 0.95); 
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .navbar-brand {
            font-size: 1.4rem;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 500;
            color: #555 !important;
            transition: color 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
        }

        .search-input {
            border-radius: 50px;
            padding-left: 1.5rem;
            background-color: #f1f3f5;
            border: 1px solid transparent;
            transition: all 0.3s;
        }

        .search-input:focus {
            background-color: white;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
            border-color: var(--primary-color);
        }

        .btn-primary { 
            border-radius: 50px; 
            padding: 0.5rem 1.5rem; 
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
        }

        .dropdown-menu {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 10px;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 8px 15px;
        }

        .footer { 
            background-color: white; 
            border-top: 1px solid #eee;
            color: #666;
            margin-top: auto; 
        }

        .alert {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .main-content { flex: 1; }
    </style>
</head>
<body>

    <header class="navbar navbar-expand-lg sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center text-primary" href="{{ route('landing.home') }}">
                <div class="bg-primary text-white rounded-3 p-2 me-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                    <i class="bi bi-capsule-pill fs-5"></i>
                </div>
                <span>Здоровье</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-2"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.home') ? 'active fw-bold' : '' }}" href="{{ route('landing.home') }}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.catalog') ? 'active fw-bold' : '' }}" href="{{ route('landing.catalog') }}">Каталог</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing.contact') ? 'active fw-bold' : '' }}" href="{{ route('landing.contact') }}">Контакты</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <form action="{{ route('landing.catalog') }}" method="GET" class="d-none d-md-flex position-relative">
                        <input type="text" name="search" class="form-control form-control-sm search-input px-4 py-2" placeholder="Найти лекарство..." value="{{ request('search') }}">
                        <i class="bi bi-search position-absolute end-0 me-3 mt-2 text-muted"></i>
                    </form>
                    
                    <a href="{{ route('cart') }}" class="position-relative text-dark text-decoration-none p-2 bg-light rounded-circle transition">
                        <i class="bi bi-bag-plus fs-5"></i>
                        @php $count = Auth::check() && Auth::user()->cartItems ? Auth::user()->cartItems->sum('quantity') : 0; @endphp
                        @if($count > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary border border-white" style="font-size: 0.6rem;">
                                {{ $count }}
                            </span>
                        @endif
                    </a>

                    @guest
                        <div class="d-flex gap-2 ms-2">
                            <a href="{{ route('login') }}" class="btn btn-link text-decoration-none text-dark fw-bold">Войти</a>
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-4">Регистрация</a>
                        </div>
                    @else
                        <div class="dropdown ms-2">
                            <a class="btn btn-light btn-sm dropdown-toggle rounded-pill px-3 border" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end mt-2 shadow-lg border-0">
                                @if(Auth::user()->role === 'admin')
                                    <li>
                                        <a class="dropdown-item fw-bold text-primary" href="{{ route('admin') }}">
                                            <i class="bi bi-speedometer2 me-2"></i> Админ-панель
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <a class="dropdown-item" href="{{ route('landing.profile') }}">
                                        <i class="bi bi-person me-2"></i> Профиль
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <i class="bi bi-box-seam me-2"></i> Мои заказы
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger fw-bold">
                                            <i class="bi bi-box-arrow-right me-2"></i> Выйти
                                        </button>
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
        <div class="container mt-4">
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <main class="main-content">
        @yield('content')
    </main>

<footer class="footer py-5 mt-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-5">
                    <div class="d-flex align-items-center text-primary fw-bold mb-3">
                        <i class="bi bi-capsule-pill fs-4 me-2"></i> Аптека "Здоровье"
                    </div>
                    <p class="small text-muted mb-3" style="max-width: 350px;">
                        Лицензированная аптека с доставкой по всей стране. Мы заботимся о вашем здоровье уже более 10 лет, предоставляя только сертифицированные препараты.
                    </p>
                    <div class="d-flex gap-3 fs-5 text-primary">
                        <i class="bi bi-telegram transition-icon" style="cursor: pointer;"></i>
                        <i class="bi bi-whatsapp transition-icon" style="cursor: pointer;"></i>
                        <i class="bi bi-vk transition-icon" style="cursor: pointer;"></i>
                    </div>
                </div>

                <div class="col-md-3 offset-md-1">
                    <h6 class="fw-bold text-dark mb-3">Навигация</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('landing.catalog') }}" class="text-decoration-none text-muted hover-link">Каталог товаров</a></li>
                        <li class="mb-2"><a href="{{ route('landing.contact') }}" class="text-decoration-none text-muted hover-link">Адреса аптек</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted hover-link">О компании</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted hover-link">Политика конфиденциальности</a></li>
                    </ul>
                </div>

                <div class="col-md-3 text-md-end">
                    <h6 class="fw-bold text-dark mb-3">Свяжитесь с нами</h6>
                    <p class="small text-muted mb-1">Горячая линия:</p>
                    <p class="fw-bold text-primary mb-3">8 (800) 555-35-35</p>
                    <p class="mb-0 text-muted small">&copy; 2026 ООО "Здоровье".<br>Все права защищены.</p>
                </div>
            </div>
        </div>
    </footer>

    <style>
        .footer {
            background-color: white;
            border-top: 1px solid #edf2f7;
        }
        .hover-link:hover {
            color: #0d6efd !important;
            padding-left: 5px;
            transition: all 0.2s ease;
        }
        .transition-icon:hover {
            transform: translateY(-3px);
            transition: transform 0.2s ease;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>