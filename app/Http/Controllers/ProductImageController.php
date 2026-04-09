<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductImageController extends Controller
{
    public function generateImage($productName)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/images/generations', [
            "model" => "dall-e-3",
            "prompt" => "A high-quality product image of {$productName}, studio lighting, white background",
            "size" => "1024x1024"
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to generate image',
                'details' => $response->json()
            ], 500);
        }

        $imageUrl = $response->json('data.0.url');

        return response()->json([
            'product' => $productName,
            'image' => $imageUrl
        ]);
    }
}
