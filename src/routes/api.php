<?php
/**
 * Date 10/04/2023
 *
 * @author   Simon Siva <simonsiva13@gmail.com>
 */

use Illuminate\Support\Facades\Route;
use Ssiva\LaravelNotify\Controllers\WebhookController;

Route::post('v1/webhook/order-status', [WebhookController::class, 'handleNotification']);