<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with("category");
        if ($request->has("category")) {
            $query->whereHas("category", function($q) use($request) {
                $q->where("slug", $request->category);
            });
        }
        if ($request->has("search")) {
            $query->where("name", "like", "%".$request->search."%");
        }
        $products = $query->get();
        $categories = Category::all();
        return view("products.index", compact("products", "categories"));
    }

    public function show(Product $product)
    {
        $product->load(["category", "reviews.user"]);
        $avgRating = $product->reviews->where('is_approved', 1)->avg('rating') ?: 0;
        $reviewCount = $product->reviews->where('is_approved', 1)->count();
        $relatedProducts = Product::where("category_id", $product->category_id)->where("id", "!=", $product->id)->take(4)->get();
        return view("products.show", compact("product", "relatedProducts", "avgRating", "reviewCount"));
    }
}
