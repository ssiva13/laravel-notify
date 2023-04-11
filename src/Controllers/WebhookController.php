<?php
/**
 * Date 10/04/2023
 *
 * @author   Simon Siva <simonsiva13@gmail.com>
 */

namespace Ssiva\LaravelNotify\Controllers;


use Illuminate\Routing\Controller;
use OpenApi\Annotations as OA;

class WebhookController extends Controller
{
    /**
     * @OA\Post(
     *     path="/webhook/order-status",
     *     summary="Handle order status notifications",
     *     description="Handle incoming webhook payloads for order status updates.",
     *     tags={"Webhook"},
     *     requestBody={
     *         "required": true,
     *         "content": {
     *             "application/json": {
     *                 "schema": {
     *                     "type": "object",
     *                     "properties": {
     *                         "order_uuid": {
     *                             "type": "string",
     *                             "description": "The UUID of the updated order."
     *                         },
     *                         "status": {
     *                             "type": "string",
     *                             "description": "The new status of the updated order."
     *                         },
     *                         "updated_at": {
     *                             "type": "string",
     *                             "format": "date-time",
     *                             "description": "The timestamp when the order was updated."
     *                         }
     *                     },
     *                     "example": {
     *                         "order_uuid": "123e4567-e89b-12d3-a456-426614174000",
     *                         "status": "completed",
     *                         "updated_at": "2023-04-10T15:30:00.000Z"
     *                     }
     *                 }
     *             }
     *         }
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="A success message."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="An error message."
     *             )
     *         )
     *     )
     * )
     */
    public function handleNotification(Request $request)
    {
        $payload = $request->json()->all();

        // Handle the webhook payload, e.g. send an email notification to admin
    }

}
