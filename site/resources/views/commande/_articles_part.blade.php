@if($items->isEmpty())
    <div class="alert alert-info">
        Aucun article {{ $statut === 'validee' ? 'validé' : ($statut === 'refusee' ? 'refusé' : 'en attente') }}.
    </div>
@else
    <div class="row">
        @foreach($items as $item)
            <div class="col-md-6 mb-3">
                <div class="card card-article {{ $statut }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                @if($item->article_image)
                                    <img src="{{ asset('storage/' . str_replace('storage/', '', $item->article_image)) }}" 
                                         alt="{{ $item->article_nom }}" 
                                         class="img-fluid article-img">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                        <span class="text-muted">Pas d'image</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <h5>{{ $item->article_nom }}</h5>
                                <p>
                                    <strong>Vendeur:</strong> {{ $item->vendeur->name ?? 'Inconnu' }}<br>
                                    <strong>Quantité:</strong> {{ $item->quantite }}<br>
                                    <strong>Prix:</strong> {{ number_format($item->prix_unitaire * $item->quantite, 2) }} DZD
                                </p>
                                
                                @if($statut === 'refusee' && $item->raison_refus)
                                    <div class="alert alert-danger p-2">
                                        <strong>Raison:</strong> {{ $item->raison_refus }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif