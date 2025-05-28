@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Connexion</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Se souvenir de moi</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">Se connecter</button>

                <div class="text-center">
                    <p class="mb-0">Vous êtes un professeur ?</p>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary mt-2">Créer un compte</a>
                </div>
            </form>
        </div>
    </div>
@endsection
