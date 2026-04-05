<?php
namespace App\Http\Controllers;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::whereNull('product_id')->with('user')->where('is_approved', 1)->latest()->paginate(10);
        $avgRating = Review::whereNull('product_id')->where('is_approved', 1)->avg('rating') ?: 0;
        return view("reviews.index", compact("reviews", "avgRating"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "product_id" => "nullable|exists:products,id",
            "rating" => "required|integer|min:1|max:5",
            "comment" => "required|string"
        ]);

        Review::create([
            "user_id" => auth()->id(),
            "product_id" => $request->product_id ?: null,
            "rating" => $request->rating,
            "comment" => $request->comment,
            "is_approved" => 1 // Auto-approve for now, or change based on policy
        ]);

        return back()->with("success", "Review submitted successfully.");
    }
}
