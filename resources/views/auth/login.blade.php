@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="auth-container">
        <form class="auth-form" method="POST" action="{{ route('login') }}">
            @csrf

            <h1 class="auth-title">Войти</h1>

            <div class="mb-4">
                <label for="login" class="auth-label">Логин</label>
                <input type="text"
                       class="auth-input form-control @error('login') is-invalid @enderror"
                       id="login"
                       name="login"
                       value="{{ old('login') }}"
                       required
                       autofocus>
                @error('login')
                <div class="auth-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="auth-label">Пароль</label>
                <input type="password"
                       class="auth-input form-control @error('password') is-invalid @enderror"
                       id="password"
                       name="password"
                       required>
                @error('password')
                <div class="auth-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex align-items-center justify-content-between">
                <button type="submit" class="auth-btn btn">Войти</button>
                <p class="auth-switch">
                    Нет аккаунта? <a href="{{ route('register') }}">Создайте</a>
                </p>
            </div>
        </form>
    </div>
@endsection
