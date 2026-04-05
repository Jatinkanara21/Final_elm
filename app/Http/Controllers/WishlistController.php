<?php
namespace App\Http\Controllers;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with("product")->where("user_id", auth()->id())->get();
        return view("wishlist.index", compact("wishlists"));
    }

    public function add(Request $request, $product_id)
    {
        Wishlist::firstOrCreate([
            "user_id" => auth()->id(),
            "product_id" => $product_id
        ]);
        return back()->with("success", "Added to wishlist.");
    }

    public function remove(Request $request, $product_id)
    {
        Wishlist::where("user_id", auth()->id())->where("product_id", $product_id)->delete();
        return back()->with("success", "Removed from wishlist.");
    }
}
