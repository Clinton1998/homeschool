<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Comprobante_d;

class NumberVoucherCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $next_number = null;
    public $id_serie = null;
    private $target;
    public function __construct(Comprobante_d $comprobante)
    {
        $numero_maximo = Comprobante_d::where([
            'id_colegio' => $comprobante->id_colegio,
            'id_serie' => $comprobante->id_serie,
        ])->max('n_numero');
        if(is_null($numero_maximo) || empty($numero_maximo)){
            $numero_maximo = 0;
        }
        $numero_maximo++;
        $this->next_number = str_pad($numero_maximo, 8, "0", STR_PAD_LEFT);
        $this->id_serie = (int)$comprobante->id_serie;
        $this->target = (int)$comprobante->creador;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('newnumberforvoucher.'.$this->target);
    }
}
