<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\AdminSetting;

class CheckoutController extends Controller
{
    public function index()
    {
        $ordersEnabled = AdminSetting::where("key", "orders_enabled")->first()->value ?? "true";
        if ($ordersEnabled !== "true") {
            return redirect()->route("cart.index")->with("error", "We are currently not accepting new orders.");
        }
        $cart = session()->get("cart", []);
        if(empty($cart)) return redirect()->route("home");
        return view("checkout", compact("cart"));
    }

    public function process(Request $request)
    {
        $ordersEnabled = AdminSetting::where("key", "orders_enabled")->first()->value ?? "true";
        if ($ordersEnabled !== "true") {
            return redirect()->route("cart.index")->with("error", "We are currently not accepting new orders.");
        }
        
        $cart = session()->get("cart", []);
        $subtotal = 0;
        foreach($cart as $item) {
            $subtotal += $item["price"] * $item["quantity"];
        }
        
        $order = Order::create([
            "user_id" => auth()->id(),
            "status" => "pending",
            "subtotal" => $subtotal,
            "tax" => 0,
            "total" => $subtotal
        ]);
        
        foreach($cart as $id => $item) {
            OrderItem::create([
                "order_id" => $order->id,
                "product_id" => $id,
                "quantity" => $item["quantity"],
                "price" => $item["price"]
            ]);
        }
        
        session()->forget("cart");
        return redirect()->route("home")->with("success", "Order placed successfully!");
    }
}
