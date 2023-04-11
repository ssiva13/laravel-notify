<?php
/**
 * Date 10/04/2023
 *
 * @author   Simon Siva <simonsiva13@gmail.com>
 */

namespace Ssiva\LaravelNotify;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Ssiva\LaravelNotify\Events\OrderStatusUpdated;
use Ssiva\LaravelNotify\Listeners\SendOrderStatusNotification;

class LaravelNotifyServiceProvider extends EventServiceProvider
{
    
    protected $listen = [
        OrderStatusUpdated::class => [
            SendOrderStatusNotification::class,
        ],
    ];
    
    
}