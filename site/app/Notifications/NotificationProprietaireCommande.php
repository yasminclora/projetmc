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
         // Récupérer les articles de la table commande_item associés à cette commande
         $articlesDuVendeur = $this->commande->items->filter(function ($item) use ($notifiable) {
             // Vérifier si l'article appartient au vendeur
             $proprietaireId = null;
     
             // On récupère le modèle de l'article en fonction de l'ID
             $modelClass = $item->article_type;  // Ex: App\Models\Robe ou App\Models\Bijou
     
             if (class_exists($modelClass)) {
                 // Trouver l'article en fonction de l'ID dans le modèle
                 $article = $modelClass::find($item->article_id);
     
                 // Si l'article existe, récupérer l'ID du propriétaire
                 $proprietaireId = $article ? $article->user_id : null;
             }
     
             // On filtre les articles qui appartiennent au propriétaire de la notification
             return $proprietaireId === $notifiable->id;
         });
     
         // Retourner le mail avec les articles du vendeur filtrés
         return (new MailMessage)
             ->subject('Nouvelle commande reçue pour vos articles')
             ->view('emails.proprietaire-commande', [
                 'commande' => $this->commande,
                 'user' => $notifiable,
                 'articles' => $articlesDuVendeur, // ✅ Passer uniquement les articles du vendeur
             ]);
     }
     
     

public function toDatabase($notifiable)
{
    return [
        'message' => 'Vous avez une nouvelle commande pour vos articles.',
        'commande_id' => $this->commande->id,
        'user_id' => $this->commande->user_id,
        'total' => $this->commande->total,
        'articles' => $this->commande->items->map(function($item) {
            $proprietaireId = null;

            // Récupération du nom du modèle depuis article_type
            $modelClass = $item->article_type; // Ex: App\Models\Robe ou App\Models\Bijou

            if (class_exists($modelClass)) {
                $article = $modelClass::find($item->article_id);
                $proprietaireId = $article?->user_id;
            }

            return [
                'article_nom' => $item->article_nom,
                'quantite' => $item->quantite,
                'prix_unitaire' => $item->prix_unitaire,
                'article_image_url' => $this->getArticleImageUrl($item->article_image),
                'user_id' => $proprietaireId, // ✅ récupéré dynamiquement via le type
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

