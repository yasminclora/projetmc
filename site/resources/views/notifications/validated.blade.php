@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Notifications Commandes Validées</h2>

    @php
        // Séparer les notifications non lues et lues
        $unreadNotifications = $notifications->filter(function($notification) {
            return is_null($notification->read_at);
        });

        $readNotifications = $notifications->filter(function($notification) {
            return !is_null($notification->read_at);
        });
    @endphp

    <!-- Afficher les notifications non lues -->
    @if($unreadNotifications->isEmpty())
        <div class="alert alert-info">Aucune nouvelle notification validée.</div>
    @else
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('notifications.markAllAsRead') }}" class="btn btn-outline-success btn-sm">
                <i class="fas fa-check-double"></i> Tout marquer comme lu
            </a>
            <span class="badge bg-primary">{{ $unreadNotifications->count() }} notification(s)</span>
        </div>

        <div class="list-group">
            @foreach($unreadNotifications as $notification)
                <div class="list-group-item list-group-item-action list-group-item-light">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="me-3 flex-grow-1">
                            <div class="mt-2 row">
                                <div class="col-md-8">
                                    <small>
                                        <strong>Référence:</strong> {{ $notification->data['reference'] ?? 'N/A' }}<br>
                                        <strong>Total:</strong> {{ number_format($notification->data['total'] ?? 0, 2, ',', ' ') }} DA
                                    </small>
                                    <div class="mt-2">
                                        <strong>Articles:</strong>
                                        <div class="row row-cols-1 g-2">
                                            @foreach($notification->data['items'] ?? [] as $item) 
                                                <div class="col">
                                                    <div class="d-flex align-items-start">
                                                        @if(isset($item['article_image_url']) && $item['article_image_url']) 
                                                            <div class="me-2" style="width: 60px; flex-shrink: 0;">
                                                                <img src="{{ $item['article_image_url'] }}" 
                                                                     class="img-thumbnail" 
                                                                     style="width: 100%; height: 60px; object-fit: cover;" 
                                                                     alt="{{ $item['nom'] ?? 'Image article' }}">
                                                            </div>
                                                        @else
                                                            <div class="me-2" style="width: 60px; flex-shrink: 0;">
                                                                <img src="{{ asset('images/default-product.jpg') }}" 
                                                                     class="img-thumbnail" 
                                                                     style="width: 100%; height: 60px; object-fit: cover;" 
                                                                     alt="Image par défaut">
                                                            </div>
                                                        @endif
                                                        <div class="flex-grow-1">
                                                            <div class="fw-medium">{{ $item['nom'] ?? 'Article sans nom' }}</div>
                                                            <small class="text-muted">
                                                                {{ $item['quantite'] ?? 0 }} x 
                                                                {{ number_format($item['prix'] ?? 0, 2, ',', ' ') }} DA
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <small class="text-muted">{{ $notification->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <div class="d-flex align-items-center">
                            @if(isset($notification->data['commande_id']))
                                <a href="{{ route('mes_commandes', $notification->data['commande_id']) }}" 
                                   class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                            @endif
                            <a href="{{ route('notifications.markAsRead', $notification->id) }}" 
                               class="btn btn-sm btn-outline-success">
                                <i class="fas fa-check"></i> Lire
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Afficher les notifications lues -->
    @if($readNotifications->isEmpty())
        <div class="alert alert-info">Aucune notification lue.</div>
    @else
        <div class="mt-4">
            <h3>Notifications Lues</h3>
            <div class="list-group">
                @foreach($readNotifications as $notification)
                    <div class="list-group-item list-group-item-action list-group-item-light">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="me-3 flex-grow-1">
                                <div class="mt-2 row">
                                    <div class="col-md-8">
                                        <small>
                                            <strong>Référence:</strong> {{ $notification->data['reference'] ?? 'N/A' }}<br>
                                            <strong>Total:</strong> {{ number_format($notification->data['total'] ?? 0, 2, ',', ' ') }} DA
                                        </small>
                                        <div class="mt-2">
                                            <strong>Articles:</strong>
                                            <div class="row row-cols-1 g-2">
                                                @foreach($notification->data['items'] ?? [] as $item) 
                                                    <div class="col">
                                                        <div class="d-flex align-items-start">
                                                            @if(isset($item['article_image_url']) && $item['article_image_url']) 
                                                                <div class="me-2" style="width: 60px; flex-shrink: 0;">
                                                                    <img src="{{ $item['article_image_url'] }}" 
                                                                         class="img-thumbnail" 
                                                                         style="width: 100%; height: 60px; object-fit: cover;" 
                                                                         alt="{{ $item['nom'] ?? 'Image article' }}">
                                                                </div>
                                                            @else
                                                                <div class="me-2" style="width: 60px; flex-shrink: 0;">
                                                                    <img src="{{ asset('images/default-product.jpg') }}" 
                                                                         class="img-thumbnail" 
                                                                         style="width: 100%; height: 60px; object-fit: cover;" 
                                                                         alt="Image par défaut">
                                                                </div>
                                                            @endif
                                                            <div class="flex-grow-1">
                                                                <div class="fw-medium">{{ $item['nom'] ?? 'Article sans nom' }}</div>
                                                                <small class="text-muted">
                                                                    {{ $item['quantite'] ?? 0 }} x 
                                                                    {{ number_format($item['prix'] ?? 0, 2, ',', ' ') }} DA
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <small class="text-muted">{{ $notification->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="d-flex align-items-center">
                                @if(isset($notification->data['commande_id']))
                                    <a href="{{ route('mes_commandes', $notification->data['commande_id']) }}" 
                                       class="btn btn-sm btn-outline-primary me-2">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                @endif
                                <a href="{{ route('notifications.markAsRead', $notification->id) }}" 
                                   class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-check"></i> Lu
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
