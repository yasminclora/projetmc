@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Mes Commandes</h2>
    
    @if($commandes->isEmpty())
        <div class="alert alert-info">
            Vous n'avez pas encore passé de commandes.
        </div>
    @else
        <!-- Filtrage par statut -->
        <div class="mb-4">
            <div class="btn-group" role="group">
                @foreach(['all', 'validee', 'en_attente', 'refusee', 'payee'] as $statut)
                    <a href="{{ route('commandes.index', ['statut' => $statut]) }}" 
                       class="btn btn-outline-{{ [
                           'all' => 'secondary',
                           'validee' => 'success', 
                           'en_attente' => 'warning',
                           'refusee' => 'danger',
                           'payee' => 'primary'
                       ][$statut] }} {{ request('statut', 'all') === $statut ? 'active' : '' }}">
                        {{ [
                            'all' => 'Toutes',
                            'validee' => 'Validées',
                            'en_attente' => 'En attente',
                            'refusee' => 'Refusées',
                            'payee' => 'Payées'
                        ][$statut] }} ({{ $statut === 'all' ? $commandes->count() : $commandes->where('statut', $statut)->count() }})
                    </a>
                @endforeach
            </div>
        </div>

        @foreach($commandes as $commande)
            @php
                $tousValides = $commande->items->every(fn($item) => $item->statut === 'validee');
                $itemsAPayer = $commande->items->where('paiement', '!=', 'payee')->count();
            @endphp

            <div class="card mb-4 shadow-sm" id="commande-{{ $commande->id }}">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        Commande #{{ $commande->reference }}
                        <span class="badge bg-{{ [
                            'validee' => 'success',
                            'en_attente' => 'warning',
                            'refusee' => 'danger',
                            'payee' => 'primary'
                        ][$commande->statut] ?? 'secondary' }} ms-2">
                            {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                        </span>
                    </h5>
                    <div>
                        <small class="text-muted me-2">
                            {{ $commande->created_at->format('d/m/Y H:i') }}
                        </small>
                        @if($tousValides && $itemsAPayer > 0)
                            <span class="badge bg-info">
                                {{ $itemsAPayer }} article(s) à payer
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Bouton de paiement global -->
                    @if($tousValides && $itemsAPayer > 0)
                        <div class="text-end mb-3">
                            <button class="btn btn-primary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#paiementCommandeModal-{{ $commande->id }}">
                                <i class="fas fa-credit-card me-1"></i> Payer toute la commande ({{ number_format($commande->items->sum(fn($item) => $item->prix_unitaire * $item->quantite), 2) }} DZD)
                            </button>
                        </div>
                    @endif

                    <!-- Articles de la commande -->
                    <div class="d-flex flex-column gap-2 mb-3">
                        @foreach($commande->items as $item)
                            <div class="d-flex align-items-center border rounded p-2 bg-white shadow-sm">
                                <div class="me-3" style="width: 80px; height: 80px;">
                                    @if($item->article_image)
                                        <img src="{{ asset('storage/' . str_replace('public/', '', $item->article_image)) }}" 
                                             class="img-fluid rounded h-100 w-100" 
                                             style="object-fit: cover;"
                                             alt="{{ $item->article_nom }}">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center h-100 w-100 rounded">
                                            <span class="text-muted">Pas d'image</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $item->article_nom }} ({{ class_basename($item->article_type) }})</h6>
                                    <small class="text-muted">
                                        Quantité: {{ $item->quantite }} | 
                                        Prix: {{ number_format($item->prix_unitaire, 2) }} DZD | 
                                        Total: <strong>{{ number_format($item->prix_unitaire * $item->quantite, 2) }} DZD</strong>
                                    </small>
                                </div>

                                <div class="text-end">
                                    <span class="badge bg-{{ [
                                        'validee' => 'success',
                                        'en_attente' => 'warning',
                                        'refusee' => 'danger',
                                        'payee' => 'primary'
                                    ][$item->statut] ?? 'secondary' }}">
                                        {{ ucfirst(str_replace('_', ' ', $item->statut)) }}
                                    </span>
                                    
                                    @if($item->paiement == 'payee')
                                        <span class="badge bg-success ms-2">
                                            <i class="fas fa-check-circle me-1"></i> Payé
                                        </span>
                                    @elseif($item->statut === 'validee')
                                        @if(!$tousValides)
                                            <button type="button" class="btn btn-sm btn-primary ms-2"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#paiementItemModal-{{ $item->id }}">
                                                <i class="fas fa-credit-card me-1"></i> Payer
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <!-- Modal de paiement par article (seulement si nécessaire) -->
                            @if(!$tousValides && $item->statut === 'validee' && $item->paiement == 'en_attente')
                                <div class="modal fade" id="paiementItemModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form id="paymentItemForm-{{ $item->id }}" data-item-id="{{ $item->id }}" class="modal-content">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Paiement - {{ $item->article_nom }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Total: <strong>{{ number_format($item->prix_unitaire * $item->quantite, 2) }} DZD</strong></p>
                                                <div class="mb-3">
                                                    <label class="form-label">Numéro de carte</label>
                                                    <input type="text" class="form-control" name="card_number" required maxlength="16">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Expiration (MM/AA)</label>
                                                    <input type="text" class="form-control" name="expiry_date" required maxlength="5">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">CVV</label>
                                                    <input type="text" class="form-control" name="cvv" required maxlength="3">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nom sur la carte</label>
                                                    <input type="text" class="form-control" name="card_name" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Confirmer le paiement</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Modal de paiement global -->
            @if($tousValides && $itemsAPayer > 0)
                <div class="modal fade" id="paiementCommandeModal-{{ $commande->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="paymentCommandeForm-{{ $commande->id }}" data-commande-id="{{ $commande->id }}" class="modal-content">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Paiement - Commande #{{ $commande->reference }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Tous les articles de cette commande sont validés.
                                </div>
                                <p>Montant total: <strong>{{ number_format($commande->items->sum(fn($item) => $item->prix_unitaire * $item->quantite), 2) }} DZD</strong></p>
                                
                                <div class="mb-3">
                                    <label class="form-label">Numéro de carte</label>
                                    <input type="text" class="form-control" name="card_number" required maxlength="16">
                                </div>
                                <div class="mb-3">
    <label class="form-label">Expiration (MM/AA)</label>
    <input type="text" class="form-control" name="expiry_date" id="expiry_date" required maxlength="5" placeholder="MM/AA">
    <div class="invalid-feedback" id="expiry_error" style="display: none;">Date invalide ou expirée</div>
</div>
                                <div class="mb-3">
                                    <label class="form-label">CVV</label>
                                    <input type="text" class="form-control" name="cvv" required maxlength="3">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nom sur la carte</label>
                                    <input type="text" class="form-control" name="card_name" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-credit-card me-1"></i> Payer la commande
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Paiement par article
document.querySelectorAll('form[id^="paymentItemForm-"]').forEach(form => {
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const itemId = this.dataset.itemId;
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        try {
            const response = await fetch(`/paiement/article/${itemId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: new FormData(this)
            });

            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Erreur serveur');

            // Fermer le modal et recharger la page
            const modalElement = document.getElementById(`paiementItemModal-${itemId}`);
            if (modalElement) {
                const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modal.hide();
            }

            window.location.reload();
        } catch (error) {
            alert('Erreur: ' + error.message);
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });
});

// Paiement global de la commande
document.querySelectorAll('form[id^="paymentCommandeForm-"]').forEach(form => {
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const commandeId = this.dataset.commandeId;
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        try {
            const response = await fetch(`/paiement/commande/${commandeId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: new FormData(this)
            });

            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Erreur serveur');

            // Fermer le modal et recharger la page
            const modalElement = document.getElementById(`paiementCommandeModal-${commandeId}`);
            if (modalElement) {
                const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modal.hide();
            }

            window.location.reload();
        } catch (error) {
            alert('Erreur: ' + error.message);
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });
});



</script>
@endsection