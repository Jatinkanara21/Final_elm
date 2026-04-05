<?php
$controllers = [
    'app/Http/Controllers/Admin/DashboardController.php' => '<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where("status", "delivered")->sum("total");
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $recentOrders = Order::with("user")->latest()->take(5)->get();

        return view("admin.dashboard", compact("totalOrders", "totalRevenue", "totalUsers", "totalProducts", "recentOrders"));
    }
}
',
    'app/Http/Controllers/Admin/CategoryController.php' => '<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view("admin.categories.index", compact("categories"));
    }

    public function create()
    {
        return view("admin.categories.create");
    }

    public function store(Request $request)
    {
        $request->validate(["name" => "required|string|max:255"]);
        Category::create([
            "name" => $request->name,
            "slug" => Str::slug($request->name),
            "description" => $request->description
        ]);
        return redirect()->route("admin.categories.index")->with("success", "Category created.");
    }

    public function edit(Category $category)
    {
        return view("admin.categories.edit", compact("category"));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(["name" => "required|string|max:255"]);
        $category->update([
            "name" => $request->name,
            "slug" => Str::slug($request->name),
            "description" => $request->description
        ]);
        return redirect()->route("admin.categories.index")->with("success", "Category updated.");
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route("admin.categories.index")->with("success", "Category deleted.");
    }
}
',
    'app/Http/Controllers/Admin/SettingController.php' => '<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = AdminSetting::all()->pluck("value", "key");
        return view("admin.settings.index", compact("settings"));
    }

    public function toggleOrders(Request $request)
    {
        $setting = AdminSetting::firstOrCreate(["key" => "orders_enabled"]);
        $setting->value = $setting->value === "true" ? "false" : "true";
        $setting->save();
        return redirect()->back()->with("success", "Order status updated.");
    }
}
',
];

foreach ($controllers as $path => $content) {
    file_put_contents(__DIR__ . "/" . $path, $content);
}

echo "Admin Controllers created successfully.";
