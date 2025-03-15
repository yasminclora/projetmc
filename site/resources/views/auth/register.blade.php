@extends('layouts.app')

@section('content')

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles généraux */
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        /* Conteneur principal */
        .container {
            margin-top: 50px;
        }

        /* Carte avec photo à gauche */
        .card-with-image {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Image à gauche */
        .card-image {
            flex: 1;
            background: url('bijouxi/BACKK.jpg') no-repeat center center;
            background-size: cover;
            background-position: center;
            height: 500px;
        }

        /* Formulaire à droite */
        .card-form {
            flex: 1;
            padding: 30px;
        }

        /* En-tête de la carte */
        .card-header {
            color: #6d4c41; /* Marron */
            font-size: 1.5rem;
            padding: 20px;
            text-align: center;
        }

        /* Styles pour les champs de formulaire */
        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 8px 12px;
            font-size: 0.9rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #6d4c41; /* Marron */
            box-shadow: 0 0 8px rgba(139, 69, 19, 0.5);
        }

        /* Styles pour les boutons */
        .btn-primary {
            background-color: #6d4c41; /* Marron */
            border: none;
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #5a3c30; /* Marron plus foncé */
        }

        /* Bouton "Se connecter" */
        .btn-secondary {
            background-color: #fff; /* Blanc */
            border: 1px solid #6d4c41; /* Bordure marron */
            color: #6d4c41; /* Texte marron */
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 0.9rem;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #6d4c41; /* Fond marron au survol */
            color: #fff; /* Texte blanc au survol */
        }

        /* Styles pour les icônes */
        .fas {
            margin-right: 8px;
        }

        /* Styles pour les messages d'erreur */
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.8rem;
        }
    </style>
</head>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card-with-image shadow-lg">
                <!-- Image à gauche -->
                <div class="card-image"></div>

                <!-- Formulaire à droite -->
                <div class="card-form">
                    <div class="card-header">
                        <h2><i class="fas fa-user-plus"></i> {{ __('Inscription') }}</h2>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Champ Nom -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold"><i class="fas fa-user"></i> {{ __('Nom') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Champ Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold"><i class="fas fa-envelope"></i> {{ __('Adresse Email') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Champ Mot de passe -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold"><i class="fas fa-lock"></i> {{ __('Mot de passe') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Champ Confirmation du mot de passe -->
                            <div class="mb-3">
                                <label for="password-confirm" class="form-label fw-bold"><i class="fas fa-lock"></i> {{ __('Confirmer le mot de passe') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <!-- Bouton d'inscription -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-user-plus"></i> {{ __('S\'inscrire') }}
                                </button>
                            </div>

                            <!-- Bouton "Se connecter" -->
                            <div class="d-grid mb-3">
                                <a href="{{ route('login') }}" class="btn btn-secondary">
                                    <i class="fas fa-sign-in-alt"></i> {{ __('Se connecter') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection