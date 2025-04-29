<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\CommandeItem;

class NotificationProprietaire extends Notification implements ShouldQueue
{
    use Queueable;

    public $items; // Plusieurs articles payés

    public function __construct($items)
    {
        // On s'assure que c'est bien une collection d'articles
        $this->items = collect($items);
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        // L'utilisateur est le propriétaire de l'article
        $user = $notifiable;
        $items = $this->items;

        // On crée l'email avec la vue Blade personnalisée
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Paiement reçu pour vos articles - Commande #'.$items->first()->commande_id)
            ->view('emails.notification_proprietaire', compact('user', 'items'));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Paiement confirmé pour ' . $this->items->count() . ' article(s)',
            'total' => $this->items->sum(fn($item) => $item->quantite * $item->prix_unitaire),
            'articles' => $this->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nom' => $item->article_nom,
                    'quantite' => $item->quantite,
                    'prix' => $item->prix_unitaire,
                ];
            })
        ];
    }
}
