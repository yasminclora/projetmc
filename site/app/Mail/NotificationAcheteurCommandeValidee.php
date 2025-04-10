<?php
namespace App\Mail;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class NotificationAcheteurCommandeValidee extends Mailable
{
    use Queueable, SerializesModels;

    public $commande;

    /**
     * Crée une nouvelle instance de NotificationAcheteurCommandeValidee.
     *
     * @param  \App\Models\Commande  $commande
     * @return void
     */
    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    /**
     * Définir le contenu du message de l'email.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Votre commande a été validée')
                    ->view('emails.acheteur-commande-validee');
    }
}

