<?php
/**
 * Date 10/04/2023
 *
 * @author   Simon Siva <simonsiva13@gmail.com>
 */

namespace Ssiva\LaravelNotify\Listeners;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Ssiva\LaravelNotify\Events\OrderStatusUpdated;

class SendOrderStatusNotification implements ShouldQueue
{
    public int $tries = 3;
    protected string $webHookUrl;
    
    /**
     * Create the event listener.
     */
    public function __construct($url = null)
    {
        $this->webHookUrl = $url ? $url : config('notify.webhook_url');
    }
    
    /**
     * Handle the event.
     *
     * @param OrderStatusUpdated $event
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function handle(OrderStatusUpdated $event): void
    {
        $order = $event->order_uuid;
        $status = $event->status;
        $updatedAt = $event->updatedAt;
        
        $message = [
            "@type" => "MessageCard",
            "summary" => "Order Status update",
            "sections" => [
                [
                    "activityTitle" => "Order Status update",
                    "activitySubtitle" => "Order #".$order,
                    "facts" => [
                        [
                            "name" => "New status",
                            "value" => $status,
                        ],
                        [
                            "name" => "Timestamp",
                            "value" => $updatedAt,
                        ],
                    ],
                ],
            ],
        ];
        
        // Build MS Teams notification card
        // Submit webhook request to a given endpoint
        $client = new Client();
        $response = $client->post($this->webHookUrl, [
            'json' => $message,
        ]);
        // Check the response status code
        if ($response->getStatusCode() === 200) {
            // Response status code is 200 (OK), process the response body
            $responseBody = json_decode($response->getBody(), true);
            Log::info('Webhook request successful with response: ' . $response->getBody());
            
        } else {
            Log::error('Webhook request failed with status code: ' . $response->getStatusCode());
            throw new Exception("Webhook request failed with status code {$response->getStatusCode()}");
        }
    }
    
    /**
     * @throws \Exception
     */
    public function failed(OrderStatusUpdated $event, Exception $exception): void
    {
        Log::error('Failed to send order status notification: ' . $exception->getMessage());
        throw new Exception("Event Handling failed with status code {$exception->getCode()}");
    }
    
}
