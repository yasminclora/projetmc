<?php
namespace App\Mail;

use App\Models\CommandeItem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationProprietaireCommande extends Mailable
{
    use Queueable, SerializesModels;

    public $commandeItem;

    /**
     * Crée une nouvelle instance de NotificationProprietaireCommande.
     *
     * @param  \App\Models\CommandeItem  $commandeItem
     * @return void
     */
    public function __construct(CommandeItem $commandeItem)
    {
        $this->commandeItem = $commandeItem;
    }

    /**
     * Définir le contenu du message de l'email.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nouvelle commande reçue pour votre article')
                    ->view('emails.proprietaire-commande');
    }
}
