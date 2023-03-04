<?php

namespace App\Events;

use App\Models\Customer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMailProcessed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email;
    public $subject;
    public $body;

    /**
     * Create a new event instance.
     *
     * @param string $email
     * @param string $subject
     * @param string $body
     */
    public function __construct(string $email,string $subject,string $body)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
