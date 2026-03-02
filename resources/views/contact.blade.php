@extends('layouts.app')
@section('content')
    <div class="container my-4">
        <h1 class="mb-4 text-center">Где нас найти?</h1>

        <div class="ratio ratio-16x9 mb-4">
            <iframe src="https://www.google.com/maps/embed?pb=..." width="600" height="450" style="border:0;"
                    allowfullscreen loading="lazy"></iframe>
        </div>
        <h2>Контактные данные</h2>
        <ul class="list-unstyled mb-5">
            <li><strong>Адрес:</strong> г. Москва, ул. Пушкина, д. 10</li>
            <li><strong>Телефон:</strong> +7 (495) 123-45-67</li>
            <li><strong>Email:</strong> info@company.ru</li>
        </ul>
    </div>
@endsection

