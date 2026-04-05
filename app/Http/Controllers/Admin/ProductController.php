<?php
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
        $products = Product::with("category")->paginate(10);
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
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:20480",
            "brand" => "nullable|string"
        ]);

        $data = $request->except("image");
        $data["slug"] = Str::slug($request->name);

        if ($request->hasFile("image")) {
            $data["image"] = $request->file("image")->store("products", "public");
        }

        $product = Product::create($data);

        // Notify Customers
        $users = \App\Models\User::where('is_admin', 0)->get();
        foreach ($users as $user) {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\NewProductMail($product));
        }

        return redirect()->route("admin.products.index")->with("success", "Product created and notifications sent.");
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
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:20480"
        ]);

        $data = $request->except(["image", "remove_image"]);
        $data["slug"] = Str::slug($request->name);

        if ($request->hasFile("image")) {
            if ($product->image) {
                \Illuminate\Support\Facades\Storage::disk("public")->delete($product->image);
            }
            $data["image"] = $request->file("image")->store("products", "public");
        } elseif ($request->input("remove_image") === "1") {
            if ($product->image) {
                \Illuminate\Support\Facades\Storage::disk("public")->delete($product->image);
            }
            $data["image"] = null;
        }

        $product->update($data);

        return redirect()->route("admin.products.index")->with("success", "Product updated.");
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route("admin.products.index")->with("success", "Product deleted.");
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\ProductsImport, $request->file('import_file'));
            return redirect()->route('admin.products.index')->with('success', 'Products imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing products: ' . $e->getMessage());
        }
    }

    public function generateImage(Product $product)
    {
        \App\Jobs\GenerateProductImage::dispatch($product);
        return redirect()->back()->with('success', 'Image generation job started for ' . $product->name . '. It will appear shortly.');
    }

    public function generateAllImages(Request $request)
    {
        set_time_limit(600); // 10 mins for bulk force gen
        $force = $request->has('force');
        
        $query = Product::query();
        if (!$force) {
            $query->whereNull('image')->orWhere('image', '');
        } else {
            // In force mode, we pick everything that isn't already a confirmed 'ai_' image
            $query->where('image', 'NOT LIKE', 'products/ai_%');
        }

        $products = $query->get();
        foreach ($products as $product) {
            \App\Jobs\GenerateProductImage::dispatch($product);
        }
        
        return redirect()->back()->with('success', 'Image generation jobs started for ' . $products->count() . ' products.');
    }

    public function syncToUberEats()
    {
        $products = Product::all();
        $service = new \App\Services\UberEatsService();
        $success = $service->syncMenu($products);

        if ($success) {
            return redirect()->back()->with('success', 'Menu synced to Uber Eats successfully!');
        }

        return redirect()->back()->with('error', 'Failed to sync menu to Uber Eats. Check logs for details.');
    }

    public function deleteAll()
    {
        // Delete all product images from storage
        $products = Product::whereNotNull('image')->get();
        foreach ($products as $product) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }

        // Delete all products from database (cascades to reviews and wishlists)
        Product::query()->delete();

        return redirect()->route('admin.products.index')->with('success', 'All product data and images have been deleted successfully.');
    }
}
