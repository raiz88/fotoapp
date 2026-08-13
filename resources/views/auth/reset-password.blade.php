@extends('layouts.auth')

@section('title', 'Reset Kata Laluan')

@section('content')
    <div class="text-center mt-2">
        <h5 class="text-primary">Reset Kata Laluan</h5>
        <p class="text-muted">Masukkan kata laluan baharu anda.</p>
    </div>

    <div class="p-2 mt-4">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-3">
                <label for="email" class="form-label">Emel</label>
                <input type="email" name="email" value="{{ old('email', $request->email) }}" class="form-control @error('email') is-invalid @enderror" id="email" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Kata Laluan Baharu</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Sahkan Kata Laluan</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
            </div>

            <div class="mt-4">
                <button class="btn btn-success w-100" type="submit">Reset Kata Laluan</button>
            </div>
        </form>
    </div>
@endsection
