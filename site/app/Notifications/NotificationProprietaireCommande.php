<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NotificationProprietaireCommande extends Notification
{
    use Queueable;

    protected $commande;

    public function __construct($commande)
    {
        $this->commande = $commande;
    }
    
     // Définir les canaux par lesquels la notification sera envoyée (ici base de données et mail)
     public function via($notifiable)
     {
         return ['database', 'mail'];  // Envoie notification par base de données et email
     }
    public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('Nouvelle commande reçue pour vos articles')
        ->view('emails.proprietaire-commande', [
            'commande' => $this->commande, // Passe toute la commande pour afficher tous les articles
            'user' => $notifiable,  // Le propriétaire de l'article
        ]);
}

    
public function toDatabase($notifiable)
{
    return [
        'message' => 'Vous avez une nouvelle commande pour vos articles.',
        'commande_id' => $this->commande->id,
        'total' => $this->commande->total,
        'articles' => $this->commande->items->map(function($item) {
            return [
                'article_nom' => $item->article_nom,
                'quantite' => $item->quantite,
                'prix_unitaire' => $item->prix_unitaire,
                'article_image_url' => $this->getArticleImageUrl($item->article_image), // Vérification de l'image
            ];
        }),
    ];
}

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

