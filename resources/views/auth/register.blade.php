@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="auth-container">
        <h1 class="auth-title">Регистрация</h1>

        <form class="auth-form" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="auth-grid">
                <div class="mb-3">
                    <label for="name" class="auth-label">Имя </label>
                    <input type="text"
                           class="auth-input form-control @error('name') is-invalid @enderror"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           required>
                    @error('name')
                    <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="login" class="auth-label">Логин </label>
                    <input type="text"
                           class="auth-input form-control @error('login') is-invalid @enderror"
                           id="login"
                           name="login"
                           value="{{ old('login') }}"
                           required>
                    @error('login')
                    <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="auth-grid">
                <div class="mb-3">
                    <label for="password" class="auth-label">Пароль </label>
                    <input type="password"
                           class="auth-input form-control @error('password') is-invalid @enderror"
                           id="password"
                           name="password"
                           required>
                    @error('password')
                    <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="auth-label">Повторите пароль </label>
                    <input type="password"
                           class="auth-input form-control"
                           id="password_confirmation"
                           name="password_confirmation"
                           required>
                </div>
            </div>

            <div class="auth-checkbox">
                <div class="form-check">
                    <input class="form-check-input @error('rules') is-invalid @enderror"
                           type="checkbox"
                           id="rules"
                           name="rules"
                        {{ old('rules') ? 'checked' : '' }}>
                    <label class="form-check-label" for="rules">
                        Я согласен с
                        <a href="https://docs.google.com/spreadsheets/d/10he6paHdUmHUuqWbB5RmKs10wzNStv8oLocf2P96wnw/edit?gid=0#gid=0"
                           target="_blank">
                            правилами регистрации
                        </a>
                    </label>
                    @error('rules')
                    <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between">
                <button type="submit" class="auth-btn btn">Зарегистрироваться</button>
                <p class="auth-switch">
                    Есть аккаунт? <a href="{{ route('login') }}">Войдите</a>
                </p>
            </div>
        </form>
    </div>
@endsection
