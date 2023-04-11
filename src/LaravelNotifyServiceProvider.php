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
    
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/notify.php' => config_path('notify.php')
        ], 'notify_config');
    }
    
    public function register()
    {
        //
    }
    
}
