<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Conversation;
use Auth;

class NewMessageForGroup implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $conversation;
    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channels = [];
        foreach($this->conversation->group->users()->get() as $user){
            array_push($channels,new PrivateChannel('messagesforgroup.'.$user->id));
        }
        return $channels;

        //return new PrivateChannel('messagesforgroup.'.$this->conversation->group_id);
    }
    /*public function broadcastWith(){
        $this->conversation->load('fromGroup');
        return ["conversation" => $this->conversation];
    }*/
}
