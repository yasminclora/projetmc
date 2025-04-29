@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détail du Signalement</h1>

    <p><strong>Utilisateur :</strong> {{ $signalement->user->name ?? 'Visiteur' }}</p>
    <p><strong>Email :</strong> {{ $signalement->user->email ?? 'N/A' }}</p>
    <p><strong>Motif :</strong> {{ $signalement->motif }}</p>
    <p><strong>Date :</strong> {{ $signalement->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Objet :</strong> {{ $signalement->signalable->nom ?? 'Objet inconnu' }}</p>
</div>
@endsection
