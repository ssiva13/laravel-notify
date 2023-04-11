<?php
/**
 * Date 10/04/2023
 *
 * @author   Simon Siva <simonsiva13@gmail.com>
 */

namespace Tests\Feature;



use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Event;
use Ssiva\LaravelNotify\Events\OrderStatusUpdated;
use Ssiva\LaravelNotify\Listeners\SendOrderStatusNotification;
use Orchestra\Testbench\TestCase;
//use Tests\TestCase;

class OrderStatusUpdatedTest extends TestCase
{
    public function testOrderStatusUpdatedEvent()
    {
        Event::fake();
        $order_uuid = '123456';
        $new_status = 'Delivered';
        $timestamp = now()->format('Y-m-d H:i:s');
        event(new OrderStatusUpdated($order_uuid, $new_status, $timestamp));
        Event::assertDispatched(OrderStatusUpdated::class, function ($event) use ($order_uuid, $new_status, $timestamp) {
            return $event->order_uuid === $order_uuid &&
                $event->status === $new_status &&
                $event->updatedAt === $timestamp;
        });
    }
    
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testSendOrderStatusNotificationListener()
    {
        $order_uuid = '123456';
        $new_status = 'Delivered';
        $timestamp = now()->format('Y-m-d H:i:s');
        
        $expectedMessage = [
            "@type" => "MessageCard",
            "summary" => "Order status update",
            "sections" => [
                [
                    "activityTitle" => "Order status update",
                    "activitySubtitle" => "Order #" . $order_uuid,
                    "activityImage" => "https://i.ibb.co/tKyTQ19/full-moon-grass.jpg",
                    "facts" => [
                        [
                            "name" => "New status",
                            "value" => $new_status,
                        ],
                        [
                            "name" => "Timestamp",
                            "value" => $timestamp,
                        ],
                    ],
                ],
            ],
        ];
        
        $clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $clientMock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo("https://webhook.site/a0668c60-b2fd-4f7a-88b3-26b0b318df32'"),
                $this->equalTo([
                    'json' => $expectedMessage,
                ]),
                $this->equalTo([
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                ])
            )
            ->willReturn(new Response());
        
        $listener = new SendOrderStatusNotification('https://webhook.site/a0668c60-b2fd-4f7a-88b3-26b0b318df32');
        $listener->handle(new OrderStatusUpdated($order_uuid, $new_status, $timestamp));
    }
    
    
}