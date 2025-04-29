<?php

namespace App\Http\Controllers;

use App\Models\CommandeItem; // Ton modèle pour les articles d'une commande
use App\Models\Paiement;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Notifications\NotificationProprietaire;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Mail;

use App\Notifications\PaiementReussiNotification;


class PaiementController extends Controller
{
    public function payerArticle(Request $request, $itemId)
    {
        $request->validate([
            'card_number' => 'required|string|size:16',
            'expiry_date' => 'required|string|regex:/^\d{2}\/\d{2}$/',
            'cvv' => 'required|string|size:3',
            'card_name' => 'required|string'
        ]);


         // Vérification que la date est valide et future
         [$month, $year] = explode('/', $request->expiry_date);
         $month = (int) $month;
         $year = (int) $year;
         
         // On suppose que "23" veut dire "2023"
         $year += 2000;
         
         // Vérifie que le mois est valide
         if ($month < 1 || $month > 12) {
             return response()->json(['error' => 'Mois invalide.'], 400);
         }
         
         // Crée une date à la fin du mois/année d’expiration
         $expiry = \Carbon\Carbon::createFromDate($year, $month, 1)->endOfMonth();
         
         // Comparaison avec la date actuelle
         if ($expiry->lt(now())) {
             return response()->json(['error' => 'La carte est expirée.'], 400);
         }
         
         
        DB::beginTransaction();

        try {
            $item = CommandeItem::with([
                'commande.user',
                'article'
            ])->findOrFail($itemId);
            // Vérification que l'article appartient bien à l'utilisateur connecté
            if ($item->commande->user_id !== auth()->id()) {
                return response()->json(['error' => 'Accès non autorisé'], 403);
            }

            // Vérification que l'article n'a pas déjà été payé
            if ($item->paiement=='payee') {
                return response()->json(['error' => 'Article déjà payé'], 400);
            }

            // Création du paiement
            $paiement = Paiement::create([
                'user_id' => auth()->id(),
                'commande_id' => $item->commande->id,
                'montant' => $item->quantite * $item->prix_unitaire,
                'methode' => 'carte',
                'reference' => 'PAY-' . now()->format('YmdHis'),
                'statut' => 'valide',
                'details' => [
                    'card_last4' => substr($request->card_number, -4),
                    'expiry' => $request->expiry_date,
                    'card_name' => $request->card_name
                ],
                'date_paiement' => now(),
            ]);

            // Marquer l'article comme payé
            $item->paiement = 'payee';
            $item->save();

            DB::commit();

 // Envoi de la notification avec logging
 \Log::info('Tentative d\'envoi de notification', [
    'user_id' => $item->commande->user->id,
    'item_id' => $item->id
]);

// Utilisez sendNow pour forcer l'envoi immédiat (debug)
\Notification::sendNow($item->commande->user, new PaiementReussiNotification($item));


\Notification::sendNow(
    $item->article->user,
    new NotificationProprietaire($item)
);



            return response()->json([
                'success' => true,
                'message' => 'Paiement effectué avec succès',
                'paiement' => $paiement
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du paiement: ' . $e->getMessage()
            ], 500);
        }
    }







    public function payCommande(Request $request, $commandeId)
    {
        $request->validate([
            'card_number' => 'required|string|size:16',
            'expiry_date' => 'required|string|regex:/^\d{2}\/\d{2}$/',
            'cvv' => 'required|string|size:3',
            'card_name' => 'required|string'
        ]);
    
        DB::beginTransaction();
    
        try {
            $commande = Commande::with(['items.article.user', 'user'])->findOrFail($commandeId);
    
            if ($commande->user_id !== auth()->id()) {
                return response()->json(['error' => 'Accès non autorisé'], 403);
            }
    
            // Vérifier que tous les articles sont validés
            if (!$commande->items->every(fn($item) => $item->statut === 'validee')) {
                return response()->json(['message' => 'Tous les articles ne sont pas encore validés.'], 400);
            }
    
            // Vérifier que des articles ne sont pas encore payés
            $articlesAPayer = $commande->items->filter(fn($item) => $item->paiement !== 'payee');
    
            if ($articlesAPayer->isEmpty()) {
                return response()->json(['message' => 'Tous les articles ont déjà été payés.'], 400);
            }
    
            // Créer un paiement global
            $paiement = Paiement::create([
                'user_id' => auth()->id(),
                'commande_id' => $commande->id,
                'montant' => $articlesAPayer->sum(fn($item) => $item->quantite * $item->prix_unitaire),
                'methode' => 'carte',
                'reference' => 'PAY-' . now()->format('YmdHis'),
                'statut' => 'valide',
                'details' => [
                    'card_last4' => substr($request->card_number, -4),
                    'expiry' => $request->expiry_date,
                    'card_name' => $request->card_name
                ],
                'date_paiement' => now(),
            ]);
    
            // Mise à jour des items + notifications
            foreach ($articlesAPayer as $item) {
                $item->paiement = 'payee';
                $item->save();
    
                // Notification au propriétaire de l’article
                \Notification::sendNow($item->article->user, new NotificationProprietaire($articlesAPayer));
            }
    
            // Notification à l'acheteur avec tous les articles payés
            \Notification::sendNow($commande->user, new PaiementReussiNotification($articlesAPayer));
    
            // Mettre à jour le statut de la commande
            $commande->statut = 'payee';
            $commande->save();
    
            DB::commit();
    
            return response()->json([
                'message' => 'Paiement de la commande effectué avec succès.',
                'paiement' => $paiement
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur lors du paiement : '.$e->getMessage());
            return response()->json([
                'message' => 'Erreur lors du paiement : ' . $e->getMessage()
            ], 500);
        }
    }
    

    
}
