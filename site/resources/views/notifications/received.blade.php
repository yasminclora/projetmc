@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Notifications de Commandes</h2>

    @php
        // Séparer les notifications lues et non lues
        $unreadNotifications = $notifications->where('read_at', null);
        $readNotifications = $notifications->whereNotNull('read_at');
    @endphp

    @if($unreadNotifications->isEmpty() && $readNotifications->isEmpty())
        <div class="alert alert-info">Aucune notification disponible.</div>
    @else
        <!-- Notifications non lues -->
        @if($unreadNotifications->isNotEmpty())
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('notifications.markAllAsRead') }}" class="btn btn-success">
                    <i class="fas fa-check-double"></i> Tout marquer comme lu
                </a>
                <span class="badge bg-primary">{{ $unreadNotifications->count() }} non lue(s)</span>
            </div>

            <div class="row">
            @foreach($unreadNotifications as $notification)
                @php
                    $data = $notification->data;
                @endphp

                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Commande #{{ $data['commande_id'] }}</h5>
                            <small class="text-muted">{{ $notification->created_at->format('d/m/Y H:i') }}</small>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                @foreach($data['articles'] as $article)
                                    @php
                                        $imageUrl = $article['article_image_url'] ?? asset('images/default-product.jpg');
                                    @endphp

                                    <div class="col-md-4 text-center">
                                        <img src="{{ $imageUrl }}" 
                                             alt="{{ $article['article_nom'] }}"
                                             class="img-fluid rounded mb-3"
                                             style="max-height: 150px; width: auto; object-fit: contain;"
                                             onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                                    </div>

                                    <div class="col-md-8">
                                        <h4 class="text-primary">{{ $article['article_nom'] }}</h4>
                                        

                                        <div class="d-flex flex-wrap gap-3 mb-2">
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-box-open me-1"></i> Quantité: {{ $article['quantite'] }}
                                            </span>
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-tag me-1"></i> Prix: {{ number_format($article['prix_unitaire'], 2) }} DA
                                            </span>
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-calculator me-1"></i> Total: {{ number_format($article['quantite'] * $article['prix_unitaire'], 2) }} DA
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Reçue {{ $notification->created_at->diffForHumans() }}
                            </small>
                            <div class="d-flex gap-2">
                                <a href="{{ route('commandes_recues', $data['commande_id']) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i> Détails
                                </a>
                                <a href="{{ route('notifications.markAsRead', $notification->id) }}" 
                                   class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-check me-1"></i> Lire
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        @endif

        <!-- Notifications lues -->
        @if($readNotifications->isNotEmpty())
            <h4 class="mt-5">Notifications Lues</h4>
            <div class="row">
            @foreach($readNotifications as $notification)
                @php
                    $data = $notification->data;
                @endphp

                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Commande #{{ $data['commande_id'] }}</h5>
                            <small class="text-muted">{{ $notification->created_at->format('d/m/Y H:i') }}</small>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                @foreach($data['articles'] as $article)
                                    @php
                                        $imageUrl = $article['article_image_url'] ?? asset('images/default-product.jpg');
                                    @endphp

                                    <div class="col-md-4 text-center">
                                        <img src="{{ $imageUrl }}" 
                                             alt="{{ $article['article_nom'] }}"
                                             class="img-fluid rounded mb-3"
                                             style="max-height: 150px; width: auto; object-fit: contain;"
                                             onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                                    </div>

                                    <div class="col-md-8">
                                        <h4 class="text-primary">{{ $article['article_nom'] }}</h4>
                                        <p class="text-muted mb-3">{{ $data['message'] }}</p>

                                        <div class="d-flex flex-wrap gap-3 mb-2">
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-box-open me-1"></i> Quantité: {{ $article['quantite'] }}
                                            </span>
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-tag me-1"></i> Prix: {{ number_format($article['prix_unitaire'], 2) }} DA
                                            </span>
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-calculator me-1"></i> Total: {{ number_format($article['quantite'] * $article['prix_unitaire'], 2) }} DA
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Reçue {{ $notification->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        @endif
    @endif
</div>
@endsection
