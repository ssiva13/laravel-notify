## Laravel Order Status Notification Package

This package provides a basic notification service for tracking order statuses. 
It allows you to register listeners for order status update events and send notifications to a Microsoft Teams channel via webhook.


### Installation

You can install the package via composer from you project root in two ways:

- Local Dependency
    - Create Composer Local Dependency Source
      ```bash
          mkdir "libraries"
      ```
    - Clone repo
      ```bash
          git clone https://github.com/ssiva13/laravel-notify.git libraries/laravel-notify
      ```
    - Add Composer Local Dependency Source to the repositories key
      ```bash
      "repositories": {
          "local": {
              "type": "path",
              "url": "./libraries/*",
              "options": {
                  "symlink": false
              }
          }
      },
      ```
      ```bash
        composer require ssiva/laravel-notify:dev-main
      ```
- Git Source
    - Add Composer Git or VCS Source to the repositories key
      ```bash
      "repositories": {
          "local": {
              "type": "git",
              "url": "https://github.com/ssiva13/laravel-notify.git",
              "options": {
                  "symlink": false
              }
          }
      },
      ```
      ```bash
        composer require ssiva/laravel-notify:dev-main
      ```

### Configuration

- Open your `config/app.php` and add the following to the `providers` array:

```php
// LaravelNotify ServiceProvider
Ssiva\LaravelNotify\LaravelNotifyServiceProvider::class,
```

- Run the command below to publish the package config file `config/notify.php`

```bash
php artisan vendor:publish --tag="notify_config"
````
This will create a notify.php file in your Laravel config directory where you can configure the package settings.
`
To use the package, you'll need to set the NOTIFY_WEBHOOK_URL environment variable to the URL of your Microsoft Teams webhook.

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

### Testing

You can run the package tests using PHPUnit. The tests are located in the **`tests`** directory.
In you Laravel project open `phpunit.xml` and add the following `testsuite` object in the `testsuites` body

```xml
<testsuite name="Laravel Notify">
    <directory suffix="Test.php">./vendor/ssiva/laravel-notify/Tests</directory>
</testsuite>
```
To test run either of the following
- `vendor/bin/phpunit`

- `php artisan test`


Swagger Documentation
Endpoints

    /orders/{id} (GET): Returns the status of the order with the given id.

Models
Order

    id (integer): The ID of the order.
    status (string): The current status of the order.

### Credits
[Simon Siva](https://ssiva13.github.io/)


### License
This package is open-sourced software licensed under the MIT license.