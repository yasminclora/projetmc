<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\CommandeItem;

class PaiementReussiNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $item;

    public function __construct($items)
    {
        // Si c'est un seul item, on le convertit en collection
        if ($items instanceof \App\Models\CommandeItem) {
            $this->items = collect([$items]);
        } else {
            $this->items = collect($items);
        }
    }
    

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Confirmation de votre paiement')
            ->view('emails.paiement_reussi', [
                'items' => $this->items,
                'user' => $notifiable
            ]);
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
