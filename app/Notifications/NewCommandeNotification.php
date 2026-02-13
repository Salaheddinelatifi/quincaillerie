<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewCommandeNotification extends Notification
{
    use Queueable;

    public $commande;

    public function __construct($commande)
    {
        $this->commande = $commande;
    }

    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'commande_id' => $this->commande->id,
            'client' => $this->commande->client->nom,
            'telephone' => $this->commande->client->telephone,
            'total' => $this->commande->total,
            'status' => $this->commande->status, // en_attente
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}
