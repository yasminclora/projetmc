<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Storage;


class CommandeValideeNotification extends Notification
{
    protected $commande;

    public function __construct($commande)
    {
        $this->commande = $commande->load('items'); // Charge les items dès la construction
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Votre commande #'.$this->commande->id.' a été validée ✅')
            ->view('emails.acheteur-commande-validee', [
                'commande' => $this->commande,
                'user' => $notifiable,
            ]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => sprintf(
                'Nouvelle commande validée ',
                $this->commande->id,
                $this->commande->items->isNotEmpty() ? $this->commande->items->first()->article_nom : 'un article',
                $this->commande->items->sum('quantite')
            ),
            'commande_id' => $this->commande->id,
            'reference' => $this->commande->reference,
            'total' => $this->commande->total,
            'items' => $this->commande->items->map(function($item) {
                return [
                    'nom' => $item->article_nom,
                    'quantite' => $item->quantite,
                    'prix' => $item->prix_unitaire,
                    'article_image_url' => $this->getArticleImageUrl($item->article_image), // Alternative si tu stockes le chemin
                ];
            })->toArray()
        ];
    }

    // Fonction pour récupérer l'URL de l'image de l'article
    protected function getArticleImageUrl($image)
    {
        if (empty($image)) {
            return asset('images/default-product.jpg'); // Image par défaut si vide
        }
    
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }
    
        if (strpos($image, 'images/') === 0) {
            return asset('storage/' . $image);
        }
    
        return Storage::exists($image) 
            ? Storage::url($image) 
            : asset('images/default-product.jpg'); // Image par défaut si l'image n'existe pas
    }
    }
