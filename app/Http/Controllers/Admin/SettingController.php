<?php
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


    public function updateImages(Request $request)
    {
        $request->validate([
            'home_hero_bg' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($request->hasFile('home_hero_bg')) {
            $file = $request->file('home_hero_bg');
            $filename = 'hero.' . $file->getClientOriginalExtension();
            $path = public_path('images/homepage');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $file->move($path, $filename);
            
            AdminSetting::updateOrCreate(
                ['key' => 'home_hero_bg'],
                ['value' => 'images/homepage/' . $filename]
            );
        }

        return redirect()->back()->with('success', 'Homepage images updated successfully!');
    }
}
