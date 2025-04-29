<?php
 namespace App\Notifications;

use App\Models\Signalement;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SignalementNotification extends Notification
{
    protected $signalement;

    public function __construct(Signalement $signalement)
    {
        $this->signalement = $signalement;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Envoi par mail et enregistrement en base de données
    }

    public function toMail($notifiable)
    {
        $user = $notifiable; // Propriétaire de l'article
        $signalement = $this->signalement;
        $article = $signalement->signalable; // Bijou, Robe ou autre
        
        // Si l'utilisateur est authentifié, utiliser son nom, sinon "Visiteur non connecté"
        $userName = $user ? $user->name : 'Visiteur non connecté';
        
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Nouveau signalement reçu')
            ->view('emails.signalement_recu', compact('userName', 'signalement', 'article'));
    }
    
    
    

    public function toDatabase($notifiable)
    {
        // Si l'utilisateur est authentifié, utilisez son nom. Sinon, "Visiteur non connecté".
        $userName = $this->signalement->user ? $this->signalement->user->name : 'Visiteur non connecté';
    
        return [
            'signalement_id' => $this->signalement->id,
            'user_name' => $userName,
            'motif' => $this->signalement->motif,
        ];
    }
    
}
