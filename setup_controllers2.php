<?php
$controllers = [
    'app/Http/Controllers/Auth/ProviderController.php' => '<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProviderController extends Controller
{
    public function redirect()
    {
        return Socialite::driver("google")->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver("google")->user();
            $user = User::updateOrCreate([
                "google_id" => $googleUser->id,
            ], [
                "name" => $googleUser->name,
                "email" => $googleUser->email,
                "avatar" => $googleUser->avatar
            ]);

            Auth::login($user);
            return redirect("/dashboard");
        } catch (\Exception $e) {
            return redirect("/login");
        }
    }
}
',
    'app/Http/Controllers/ReviewController.php' => '<?php
namespace App\Http\Controllers;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "product_id" => "required|exists:products,id",
            "rating" => "required|integer|min:1|max:5",
            "comment" => "required|string"
        ]);

        Review::create([
            "user_id" => auth()->id(),
            "product_id" => $request->product_id,
            "rating" => $request->rating,
            "comment" => $request->comment,
            "is_approved" => 1
        ]);

        return back()->with("success", "Review submitted successfully.");
    }
}
',
    'app/Http/Controllers/WishlistController.php' => '<?php
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
',
    'app/Http/Controllers/OrderController.php' => '<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with("items.product")->where("user_id", auth()->id())->latest()->get();
        return view("orders.index", compact("orders"));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load("items.product");
        return view("orders.show", compact("order"));
    }
}
',
];

foreach ($controllers as $path => $content) {
    file_put_contents(__DIR__ . "/" . $path, $content);
}

echo "Controllers 2 created successfully.";
