@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Mes Notifications</h2>

    @if($notifications->isEmpty())
        <div class="alert alert-info">Aucune notification pour l’instant.</div>
    @else
        <ul class="list-group">
            @foreach($notifications as $notification)
            <li class="list-group-item">
    <strong>{{ $notification->created_at->diffForHumans() }} :</strong>
    {{ $notification->data['message'] ?? 'Notification' }}

    @if(isset($notification->data['commande_id']))
        <br>
        <a href="{{ route('commandes_recues', $notification->data['commande_id']) }}" class="btn btn-sm btn-primary mt-2">
            Voir la commande
        </a>
    @endif

    @if(is_null($notification->read_at))
        <a href="{{ route('notifications.markAsRead', $notification->id) }}" class="btn btn-sm btn-success mt-2 ms-2">
            Marquer comme lue
        </a>
    @else
        <span class="badge bg-secondary mt-2 ms-2">Lue</span>
    @endif
</li>


            @endforeach
        </ul>
    @endif
    
</div>
@endsection
