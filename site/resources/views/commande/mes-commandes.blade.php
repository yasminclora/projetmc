@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Mes Commandes</h2>
    
    @if($commandes->isEmpty())
        <div class="alert alert-info">
            Vous n'avez pas encore passé de commandes.
        </div>
    @else
        <!-- Menu de filtrage par statut -->
        <div class="mb-4">
            <div class="btn-group" role="group">
                <a href="?statut=all" class="btn btn-outline-secondary {{ request('statut', 'all') === 'all' ? 'active' : '' }}">
                    Toutes ({{ $commandes->count() }})
                </a>
                <a href="?statut=validee" class="btn btn-outline-success {{ request('statut') === 'validee' ? 'active' : '' }}">
                    Validées ({{ $commandes->where('statut', 'validee')->count() }})
                </a>
                <a href="?statut=en_attente" class="btn btn-outline-warning {{ request('statut') === 'en_attente' ? 'active' : '' }}">
                    En attente ({{ $commandes->where('statut', 'en_attente')->count() }})
                </a>
                <a href="?statut=refusee" class="btn btn-outline-danger {{ request('statut') === 'refusee' ? 'active' : '' }}">
                    Refusées ({{ $commandes->where('statut', 'refusee')->count() }})
                </a>
            </div>
        </div>

        @foreach($commandes as $commande)
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        Commande #{{ $commande->reference }}
                     <span   class="badge bg-{{ [
    'validee' => 'success',
    'en_attente' => 'warning',
    'refusee' => 'danger'
][$commande->statut] ?? 'secondary' }}">
                        statut: {{ $commande->statut }}

                     </span>
 

                    </h5>
                    <small class="text-muted">
                        {{ $commande->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        @foreach($commande->items as $item)
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                @if($item->article_image)
                                                    <img src="{{ asset('storage/'.str_replace('storage/', '', $item->article_image)) }}" 
                                                         class="img-fluid rounded">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                                        <span class="text-muted">Pas d'image</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-8">
                                                <h5>{{ $item->article_nom }}</h5>
                                                <p>
                                                    <strong>Type:</strong> {{ class_basename($item->article_type) }}<br>
                                                    <strong>Prix unitaire:</strong> {{ number_format($item->prix_unitaire, 2) }} DZD<br>
                                                    <strong>Quantité:</strong> {{ $item->quantite }}<br>
                                                    <strong>Total:</strong> {{ number_format($item->prix_unitaire * $item->quantite, 2) }} DZD <br>

                                                    <strong>Statut de l'article:</strong>
<span class="badge bg-{{ [
    'validee' => 'success',
    'en_attente' => 'warning',
    'refusee' => 'danger'
][$item->statut] ?? 'secondary' }}">
    {{ ucfirst(str_replace('_', ' ', $item->statut)) }}
</span>


                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-3 p-3 bg-light rounded">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-0">Total: {{ number_format($commande->total, 2) }} DZD</h5>
                            </div>
                            <div class="col-md-6 text-end">
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .img-fluid {
        max-height: 150px;
        object-fit: cover;
    }
</style>
@endsection