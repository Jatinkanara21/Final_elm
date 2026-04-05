<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with("user", "product")->latest()->paginate(15);
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
