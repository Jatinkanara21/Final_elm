<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class UberEatsWebhookController extends Controller
{
    /**
     * Handle Incoming Order Notifications
     */
    public function handle(Request $request)
    {
        Log::info('Uber Eats Webhook Handled', ['payload' => $request->all()]);

        if ($request->input('event_type') === 'orders.notification') {
            $orderId = $request->input('resource_id');
            return $this->processOrder($orderId);
        }

        return response()->json(['status' => 'ignored']);
    }

    /**
     * Process Uber Order and Store Locally
     */
    protected function processOrder($externalOrderId)
    {
        // In a real scenario, we would use the UberEatsService to fetch full order details.
        // For this foundation, we'll implement the mapping logic.
        
        $order = Order::create([
            'source' => 'ubereats',
            'external_order_id' => $externalOrderId,
            'status' => 'pending',
            'user_id' => 1, // Default system user or dynamic mapping
            'subtotal' => 0,
            'tax' => 0,
            'total' => 0
        ]);

        return response()->json(['status' => 'success', 'order_id' => $order->id]);
    }
}
