@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-white" style="background-color: #6d4c41;">
                    <i class="fas fa-user-edit"></i> {{ __('Modifier le profil') }}
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
    @method('PUT')

    <div class="form-group">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" value="{{ Auth::user()->nom }}">
    </div>

    <div class="form-group">
        <label>Prénom</label>
        <input type="text" name="prenom" class="form-control" value="{{ Auth::user()->prenom }}">
    </div>

    <div class="form-group">
        <label>Adresse</label>
        <input type="text" name="adresse" class="form-control" value="{{ Auth::user()->adresse }}">
    </div>

    <div class="form-group">
        <label>Numéro</label>
        <input type="text" name="telephone" class="form-control" value="{{ Auth::user()->telephone }}">
    </div>

    <div class="form-group">
        <label>Image de profil</label>
        <input type="file" name="image" class="form-control-file">
    </div>




                        <!-- Bouton Soumettre -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" style="background-color: #6d4c41; border-color: #6d4c41;">
                                <i class="fas fa-save"></i> {{ __('Mettre à jour') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
