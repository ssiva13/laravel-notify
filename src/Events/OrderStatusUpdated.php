<?php
/**
 * Date 10/04/2023
 *
 * @author   Simon Siva <simonsiva13@gmail.com>
 */

namespace Ssiva\LaravelNotify\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * @SWG\Definition(
 *     definition="OrderStatusUpdated",
 *     type="object",
 *     required={"order_uuid", "status", "updatedAt"},
 *     @SWG\Property(
 *         property="order_uuid",
 *         type="string",
 *         description="The UUID of the updated order"
 *     ),
 *     @SWG\Property(
 *         property="status",
 *         type="string",
 *         description="The new status of the order"
 *     ),
 *     @SWG\Property(
 *         property="updatedAt",
 *         type="string",
 *         format="date-time",
 *         description="The timestamp when the order was updated"
 *     )
 * )
 */
class OrderStatusUpdated
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    
    
    public $order_uuid;
    public $status;
    public $updatedAt;
    
    /**
     * Create a new event instance.
     */
    public function __construct($order_uuid, $orderStatus, $updatedAt)
    {
        $this->order_uuid = $order_uuid;
        $this->status = $orderStatus;
        $this->updatedAt = $updatedAt;
    }
    
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
