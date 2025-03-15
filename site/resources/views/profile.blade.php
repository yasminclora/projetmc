@extends('layouts.app')

@section('content')









<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profil') }}</div>

                <div class="card-body">
                    <!-- Informations de l'utilisateur -->
                    <div class="mb-4">
                        <p><strong>Nom :</strong> {{ Auth::user()->name }}</p>
                        <p><strong>Email :</strong> {{ Auth::user()->email }}</p>
                    </div>

                    <!-- Bouton pour modifier le profil -->
                    <a href="{{ route('edit') }}" class="btn btn-primary">
                        Modifier le profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection