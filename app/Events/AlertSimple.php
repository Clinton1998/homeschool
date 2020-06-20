<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AlertSimple implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    private $users = array();
    public $alert = array(
        'title' => '',
        'text' => '',
        'type' => '',
        'timeout' => 0,
        'icon' => ''
    );
    public function __construct($usersId = array(),$title,$text,$type,$timeout,$icon)
    {
        $this->users = $usersId;
        $this->alert['title'] = $title;
        $this->alert['text'] = $text;
        $this->alert['type'] = $type;
        $this->alert['timeout'] = $timeout;
        $this->alert['icon'] = $icon;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channels = [];
        for($i = 0; $i<count($this->users); $i++){
            array_push($channels,new PrivateChannel('alertforuser.'.$this->users[$i]));
        }
        return $channels;
    }
}
