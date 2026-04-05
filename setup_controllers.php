<?php
$controllers = [
    'app/Http/Controllers/HomeController.php' => '<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with("category")->latest()->take(8)->get();
        return view("home", compact("featuredProducts"));
    }
}
',
    'app/Http/Controllers/ProductController.php' => '<?php
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
        $products = $query->paginate(12);
        $categories = Category::all();
        return view("products.index", compact("products", "categories"));
    }

    public function show(Product $product)
    {
        $product->load(["category", "reviews.user"]);
        $relatedProducts = Product::where("category_id", $product->category_id)->where("id", "!=", $product->id)->take(4)->get();
        return view("products.show", compact("product", "relatedProducts"));
    }
}
',
    'app/Http/Controllers/CartController.php' => '<?php
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
',
    'app/Http/Controllers/CheckoutController.php' => '<?php
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
',
];

foreach ($controllers as $path => $content) {
    file_put_contents(__DIR__ . "/" . $path, $content);
}

echo "Controllers created successfully.";
