@extends('layouts.auth')

@section('title', 'Lupa Kata Laluan')

@section('content')
    <div class="text-center mt-2">
        <h5 class="text-primary">Lupa Kata Laluan?</h5>
        <p class="text-muted">Masukkan emel anda dan kami akan hantar pautan reset.</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="p-2 mt-4">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Emel</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Masukkan emel" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <button class="btn btn-success w-100" type="submit">Hantar Pautan Reset</button>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-muted">Kembali ke log masuk</a>
            </div>
        </form>
    </div>
@endsection
