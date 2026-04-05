<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get("cart", []);
        return view("cart", compact("cart"));
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get("cart", []);
        $id = $product->id;
        
        if(isset($cart[$id])) {
            $cart[$id]["quantity"]++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "retail_price" => $product->retail_price,
                "image" => $product->image
            ];
        }
        session()->put("cart", $cart);
        return redirect()->back()->with("success", "Product added to cart successfully!");
    }

    public function update(Request $request, Product $product)
    {
        if($request->id && $request->quantity){
            $cart = session()->get("cart");
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put("cart", $cart);
            session()->flash("success", "Cart updated successfully");
        }
    }

    public function remove(Request $request, Product $product)
    {
        if($request->id) {
            $cart = session()->get("cart");
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put("cart", $cart);
            }
            session()->flash("success", "Product removed successfully");
        }
    }
}
