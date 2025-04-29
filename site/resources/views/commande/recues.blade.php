@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Commandes reçues sur mes articles</h2>

    @if($commandes->isEmpty())
        <div class="alert alert-info">
            Aucune commande reçue pour vos articles.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Référence</th>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Articles</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Statut</th>
                        
                        <th>Actions</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($commandes as $commande)
                    @php
                        $itemsVendeur = $commande->items->filter(function($item) {
                            return $item->article && $item->article->user_id === auth()->id();
                        });
                        $hasValidee = $itemsVendeur->contains('statut', 'validee');
                        $statuts = $itemsVendeur->pluck('statut')->unique();

                    @endphp
                    <tr>
                        <td>{{ $commande->reference }}</td>
                        <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $commande->user->email }}</td>
                        <td>
                            <ul class="list-unstyled">
                                @foreach($itemsVendeur as $item)
                                <li class="mb-2">
                                    <img src="{{ asset('storage/' . $item->article->image) }}" width="50" class="mr-2">
                                    {{ $item->article->nom }} ({{ class_basename($item->article_type) }})
                                </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @foreach($itemsVendeur as $item)
                            <div>{{ $item->quantite }}</div>
                            @endforeach
                        </td>
                        <td>
                            {{ number_format($itemsVendeur->sum(function($item) {
                                return $item->prix_unitaire * $item->quantite;
                            }), 2, ',', ' ') }} DZD
                        </td>
                        <td>
                            @foreach($statuts as $statut)
                                <span class="badge 
                                    @if($statut === 'en_attente') bg-warning
                                    @elseif($statut === 'validee') bg-success
                                    @elseif($statut === 'refusee') bg-danger
                                    @else bg-secondary @endif">
                                    {{ ucfirst($statut) }}
                                </span>
                            @endforeach
                        </td>
                       
                        <td>
                            <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" 
                               data-bs-target="#commandeModal{{ $commande->id }}">
                                Détails
                            </a>

                            <!-- Modal -->
                            <div class="modal fade" id="commandeModal{{ $commande->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Détails de la commande {{ $commande->reference }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6>Informations client</h6>
                                                    <p><strong>Nom:</strong> {{ $commande->user->name }}</p>
                                                    <p><strong>Email:</strong> {{ $commande->user->email }}</p>
                                                 
                                                </div>
                                                <div class="col-md-6">
                                                    <h6>Statut de vos articles</h6>
                                                    <form action="{{ route('commande_items.update_statuts_par_commande', $commande->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <select name="statut" class="form-select mb-3" @if($hasValidee) disabled @endif>
                                                            <option value="en_attente" {{ $statuts->contains('en_attente') ? 'selected' : '' }}>En attente</option>
                                                            <option value="validee" {{ $statuts->contains('validee') ? 'selected' : '' }}>Validée</option>
                                                            <option value="refusee" {{ $statuts->contains('refusee') ? 'selected' : '' }}>Refusée</option>
                                                        </select>
                                                        <button type="submit" class="btn btn-sm btn-primary" @if($hasValidee) disabled @endif>Mettre à jour</button>
                                                    </form>
                                                </div>
                                            </div>

                                            <hr>

                                            <h6>Vos articles dans cette commande</h6>
                                            <table class="table table-sm">
    <thead>
        <tr>
            <th>Image</th>
            <th>Nom</th>
            <th>Type</th>
            <th>Prix unitaire</th>
            <th>Quantité</th>
            <th>Total</th>
            <th>Statut</th>
            <th>Stock</th> <!-- Nouvelle colonne -->
            <th>Paiement</th> <!-- ✅ Nouvelle colonne -->
 
       
        </tr>
    </thead>
    <tbody>
        @foreach($itemsVendeur as $item)
        <tr>
            <td><img src="{{ asset('storage/' . $item->article->image) }}" width="50"></td>
            <td>{{ $item->article->nom }}</td>
            <td>{{ class_basename($item->article_type) }}</td>
            <td>{{ number_format($item->prix_unitaire, 2, ',', ' ') }} DZD</td>
            <td>{{ $item->quantite }}</td>
            <td>{{ number_format($item->prix_unitaire * $item->quantite, 2, ',', ' ') }} DZD</td>
            <td>
                <span class="badge 
                    @if($item->statut === 'en_attente') bg-warning
                    @elseif($item->statut === 'validee') bg-success
                    @elseif($item->statut === 'refusee') bg-danger
                    @else bg-secondary @endif">
                    {{ ucfirst($item->statut) }}
                </span>
            </td>
            <td>
                @if($item->article->quantite < $item->quantite)
                    <span class="text-danger" title="Stock insuffisant">
                        <i class="fas fa-exclamation-triangle"></i> {{ $item->article->quantite }} restant(s)
                    </span>
                @else
                    <span class="text-success">
                        {{ $item->article->quantite }} disponible(s)
                    </span>
                @endif


                
            </td>

            <td>
            @if($item->paiement=='payee')
                <span class="badge bg-success">Payé</span>
            @else
                <span class="badge bg-danger">Non payé</span>
            @endif
        </td>
        </tr>
        @endforeach
    </tbody>
</table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>



                        
            <td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $commandes->links() }}
    @endif
</div>
@endsection