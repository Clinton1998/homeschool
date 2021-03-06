<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Queue\SerializesModels;
class NuevaTareaParaAlumnoNotification extends Notification
{
    /*Esta clase es reutilizable para todo tipo de notificaciones,no solo tareas*/
    use Queueable,SerializesModels;
    protected $notificacion;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notificacion)
    {
        $this->notificacion = $notificacion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'notificacion' => $this->notificacion,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'notificacion' => $this->notificacion,
        ];
    }
}
