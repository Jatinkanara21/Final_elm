<?php
$controllers = [
    'app/Http/Controllers/Admin/ProductController.php' => '<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with("category")->get();
        return view("admin.products.index", compact("products"));
    }

    public function create()
    {
        $categories = Category::all();
        return view("admin.products.create", compact("categories"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "category_id" => "required|exists:categories,id",
            "price" => "required|numeric",
            "stock" => "required|integer",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
            "brand" => "nullable|string"
        ]);

        $data = $request->except("image");
        $data["slug"] = Str::slug($request->name);

        if ($request->hasFile("image")) {
            $data["image"] = $request->file("image")->store("products", "public");
        }

        Product::create($data);
        return redirect()->route("admin.products.index")->with("success", "Product created.");
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view("admin.products.edit", compact("product", "categories"));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "category_id" => "required|exists:categories,id",
            "price" => "required|numeric",
            "stock" => "required|integer",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048"
        ]);

        $data = $request->except("image");
        $data["slug"] = Str::slug($request->name);

        if ($request->hasFile("image")) {
            $data["image"] = $request->file("image")->store("products", "public");
        }

        $product->update($data);
        return redirect()->route("admin.products.index")->with("success", "Product updated.");
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route("admin.products.index")->with("success", "Product deleted.");
    }
}
',
    'app/Http/Controllers/Admin/OrderController.php' => '<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with("user")->latest()->get();
        return view("admin.orders.index", compact("orders"));
    }

    public function show(Order $order)
    {
        $order->load("items.product", "user");
        return view("admin.orders.show", compact("order"));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate(["status" => "required|string"]);
        $order->update(["status" => $request->status]);
        return redirect()->route("admin.orders.show", $order)->with("success", "Order status updated.");
    }
}
',
    'app/Http/Controllers/Admin/UserController.php' => '<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view("admin.users.index", compact("users"));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route("admin.users.index")->with("success", "User deleted.");
    }
}
',
    'app/Http/Controllers/Admin/ReviewController.php' => '<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with("user", "product")->latest()->get();
        return view("admin.reviews.index", compact("reviews"));
    }

    public function update(Request $request, Review $review)
    {
        $review->update(["is_approved" => !$review->is_approved]);
        return redirect()->route("admin.reviews.index")->with("success", "Review status updated.");
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route("admin.reviews.index")->with("success", "Review deleted.");
    }
}
',
];

foreach ($controllers as $path => $content) {
    file_put_contents(__DIR__ . "/" . $path, $content);
}

echo "Remaining Admin Controllers created successfully.";
