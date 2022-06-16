<?php

namespace App\Events;

use App\Order\AOrder;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class OrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $data;
    public function __construct($order_id)
    {
        $this->data = [
            "status" => "success",
            "name" => "OrderEvent",
            "order_id" => $order_id,
            "updated_at" => \Carbon\Carbon::now()->addYears(543)->format("d-m-Y H:i:s")
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('OrderEventOn');
    }

    public function broadcastAs()
    {
        return 'OrderEventAs';
    }
}
