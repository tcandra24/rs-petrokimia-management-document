<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $userId;

    /**
     * Create a new event instance.
     */
    public function __construct($message, $userId)
    {
        $this->message = $message;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('notifications.' . $this->userId),
        ];
    }
    // public function broadcastOn(): array
    // {
    //     return [
    //         new Channel('notifications'),
    //     ];
    // }

    // public function broadcastOn()
    // {
    //     return new Channel('notifications.' . $this->userId);
    // }

    public function broadcastWith(): array
    {
        return ['message' => $this->message];
    }

    public function broadcastAs(): string
    {
        return 'notifications';
    }
}
