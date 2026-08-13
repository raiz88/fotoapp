@extends('layouts.auth')

@section('title', 'Log Masuk')

@section('content')
    <div class="text-center mt-2">
        <h5 class="text-primary">Selamat Kembali!</h5>
        <p class="text-muted">Log masuk untuk teruskan ke dashboard admin.</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="p-2 mt-4">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Emel</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Masukkan emel" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="float-end">
                    <a href="{{ route('password.request') }}" class="text-muted">Lupa kata laluan?</a>
                </div>
                <label class="form-label" for="password">Kata Laluan</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Masukkan kata laluan" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>

            <div class="mt-4">
                <button class="btn btn-success w-100" type="submit">Log Masuk</button>
            </div>
        </form>
    </div>
@endsection
