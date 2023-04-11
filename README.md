## Laravel Order Status Notification Package

This package provides a basic notification service for tracking order statuses. 
It allows you to register listeners for order status update events and send notifications to a Microsoft Teams channel via webhook.

## Installation

To install this package, add it to your `composer.json` file and run `composer update`:

```bash
composer require myvendor/my-package
```

Then, add the service provider to your config/app.php file:

```php
'providers' => [
    // ...
    MyVendor\MyPackage\MyPackageServiceProvider::class,
],
```
Finally, publish the package config file:
```php

php artisan vendor:publish --provider="MyVendor\MyPackage\MyPackageServiceProvider" --tag="config"
```

### Configuration
After publishing the config file, you should see a my-package.php file in your config directory. Here's an example config file:

```php
return [
    'webhook_url' => env('MY_PACKAGE_WEBHOOK_URL'),
];
```
To use the package, you'll need to set the MY_PACKAGE_WEBHOOK_URL environment variable to the URL of your Microsoft Teams webhook.

### Usage

To use this package, you'll need to register a listener for the MyVendor\MyPackage\Events\OrderStatusUpdated event. Here's an example listener:

```php

<?php

namespace App\Listeners;

use MyVendor\MyPackage\Events\OrderStatusUpdated;
use MyVendor\MyPackage\WebhookController;

class SendOrderStatusNotification
{
    /**
     * Handle the event.
     *
     * @param  OrderStatusUpdated  $event
     * @return void
     */
    public function handle(OrderStatusUpdated $event)
    {
        $webhook = new WebhookController();
        $webhook->handleNotification($event->order_uuid, $event->status, $event->updated_at);
    }
}

```

In this example, the SendOrderStatusNotification listener creates a new WebhookController instance and calls the handleNotification() method with the order_uuid, status, and updated_at properties from the OrderStatusUpdated event.

The handleNotification() method builds a Microsoft Teams notification card with these values and submits a webhook request to the configured endpoint.

### Testing

To run the package's unit tests, run the following command:

Swagger Documentation
Endpoints

    /orders/{id} (GET): Returns the status of the order with the given id.

Models
Order

    id (integer): The ID of the order.
    status (string): The current status of the order.

License

This package is open-sourced software licensed under the MIT license.