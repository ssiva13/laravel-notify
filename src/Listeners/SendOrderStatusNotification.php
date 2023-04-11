<?php
/**
 * Date 10/04/2023
 *
 * @author   Simon Siva <simonsiva13@gmail.com>
 */

namespace Ssiva\LaravelNotify\Listeners;

use GuzzleHttp\Client;
use Ssiva\LaravelNotify\Events\OrderStatusUpdated;

class SendOrderStatusNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Handle the event.
     *
     * @param OrderStatusUpdated $event
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(OrderStatusUpdated $event)
    {
        $order_uuid = $event->order_uuid;
        $new_status = $event->new_status;
        $updated_at = $event->updated_at;
        $message = [
            "@type" => "MessageCard",
            "summary" => "Order status update",
            "sections" => [
                [
                    "activityTitle" => "Order status update",
                    "activitySubtitle" => "Order #".$event->order_uuid,
                    "activityImage" => "https://www.example.com/logo.png",
                    "facts" => [
                        [
                            "name" => "New status",
                            "value" => $event->new_status,
                        ],
                        [
                            "name" => "Timestamp",
                            "value" => $event->timestamp,
                        ],
                    ],
                ],
            ],
        ];
        // Build MS Teams notification card
        // Submit webhook request to a given endpoint
        $client = new Client();
        $response = $client->post('https://webhook.site/your-webhook-url', [
            'json' => $message,
        ]);
    }
    
}