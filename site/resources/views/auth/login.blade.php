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

        /* Carte avec photo à droite */
        .card-with-image {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Formulaire à gauche */
        .card-form {
            flex: 1;
            padding: 30px;
        }

        /* Image à droite */
        .card-image {
            flex: 1;
            background: url('bijouxi/BACKK.jpg') no-repeat center center;
            background-size: cover;
            background-position: center;
            height: 500px;
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
            box-shadow: 0 0 8px rgba(109, 76, 65, 0.5);
        }

        /* Styles pour les boutons */
        .btn-primary {
            background-color: #6d4c41; /* Marron */
            border: none;
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        /* Bouton "S'inscrire" */
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

        .btn-primary:hover {
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

        /* Styles pour le lien "Mot de passe oublié" */
        .btn-link {
            color: #6d4c41; /* Marron */
            text-decoration: none;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        /* Media Query pour les écrans de moins de 768px */
        @media (max-width: 768px) {
            .card-with-image {
                flex-direction: column; /* Empiler les éléments verticalement */
            }

            .card-image {
                height: 300px; /* Réduire la hauteur de l'image */
                width: 100%; /* Prendre toute la largeur */
                order: -1; /* Placer l'image en haut */
            }

            .card-form {
                padding: 20px; /* Réduire le padding */
            }

            .card-header {
                font-size: 1.25rem; /* Réduire la taille de la police */
                padding: 15px;
            }

            .form-control {
                font-size: 0.875rem; /* Réduire la taille de la police des champs */
            }

            .btn-primary {
                font-size: 0.875rem; /* Réduire la taille de la police du bouton */
                padding: 8px 12px;
            }

            .btn-link {
                font-size: 0.875rem; /* Réduire la taille de la police du lien */
            }
        }
    </style>
</head>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card-with-image shadow-lg">
                <!-- Formulaire à gauche -->
                <div class="card-form">
                    <div class="card-header">
                        <h2><i class="fas fa-sign-in-alt"></i> {{ __('Connexion') }}</h2>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Champ Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold"><i class="fas fa-envelope"></i> {{ __('Adresse Email') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Champ Mot de passe -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold"><i class="fas fa-lock"></i> {{ __('Mot de passe') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Case à cocher "Se souvenir de moi" -->
                            <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Se souvenir de moi') }}
                                </label>
                            </div>

                            <!-- Bouton de connexion -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt"></i> {{ __('Connexion') }}
                                </button>
                            </div>

                            <!-- Lien "Mot de passe oublié" -->
                            @if (Route::has('password.request'))
                                <div class="text-center">
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Mot de passe oublié ?') }}
                                    </a>
                                </div>
                            @endif

                            <!-- Bouton "S'inscrire" -->
                            <div class="d-grid mb-3">
                                <a href="{{ route('register') }}" class="btn btn-secondary">
                                    <i class="fas fa-user-plus"></i> {{ __('S\'inscrire') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Image à droite -->
                <div class="card-image"></div>
            </div>
        </div>
    </div>
</div>
@endsection