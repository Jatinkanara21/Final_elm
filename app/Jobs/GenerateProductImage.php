<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GenerateProductImage implements ShouldQueue
{
    use Queueable;

    public $product;

    /**
     * Create a new job instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        set_time_limit(60); // Allow at least 60 seconds per image generation
        // Double check it doesn't already have an image
        if ($this->product->image && Storage::disk('public')->exists($this->product->image)) {
            return;
        }

        $categoryName = $this->product->category ? $this->product->category->name : 'product';
        $brandName = $this->product->brand ? $this->product->brand . ' ' : '';
        $productName = $this->product->name;

        // Using Pollinations AI with Flux model for "Perfect" results
        // No API key required. Highly reliable and high quality.
        $prompt = "A high-end, professional, studio lighting product photograph of a " . $brandName . $productName . " ($categoryName). " . 
                  "The product is perfectly centered on a pristine, minimalist pure white background. " .
                  "Sharp focus, 8k resolution, photorealistic, elegant design, subtle reflections, luxury e-commerce catalog style. " .
                  "Ultra-high quality commercial photography, perfectly rendered textures.";

        try {
            $encodedPrompt = urlencode($prompt);
            $imageUrl = "https://image.pollinations.ai/prompt/{$encodedPrompt}?width=800&height=800&model=flux&nologo=true&seed=" . rand(1, 10000);
            
            Log::info("Generating perfect image via Pollinations (Flux) for product {$this->product->id}");
            
            $response = Http::timeout(60)->get($imageUrl);

            if ($response->successful()) {
                $this->saveImage($response->body(), 'ai');
                return;
            }
            
            Log::error("Pollinations AI failed for product {$this->product->id}: " . $response->status());
        } catch (\Exception $e) {
            Log::error("Pollinations AI Exception for product {$this->product->id}: " . $e->getMessage());
        }
    }

    /**
     * Save the image data to storage and update the product.
     */
    protected function saveImage(string $imageData, string $type): void
    {
        $filename = 'products/' . $type . '_' . Str::random(10) . '_' . time() . '.png';
        
        // Load the AI generated image
        $img = imagecreatefromstring($imageData);
        if ($img) {
            $logoPath = public_path('img/logo.png');
            if (file_exists($logoPath)) {
                $logo = imagecreatefrompng($logoPath);
                if ($logo) {
                    // Get dimensions
                    $imgWidth = imagesx($img);
                    $imgHeight = imagesy($img);
                    $logoWidth = imagesx($logo);
                    $logoHeight = imagesy($logo);

                    // Resize logo to be ~12% of the image width
                    $newLogoWidth = intval($imgWidth * 0.12);
                    $newLogoHeight = intval($logoHeight * ($newLogoWidth / $logoWidth));
                    
                    $resizedLogo = imagecreatetruecolor($newLogoWidth, $newLogoHeight);
                    imagealphablending($resizedLogo, false);
                    imagesavealpha($resizedLogo, true);
                    imagecopyresampled($resizedLogo, $logo, 0, 0, 0, 0, $newLogoWidth, $newLogoHeight, $logoWidth, $logoHeight);

                    // Position: Bottom Right with padding
                    $padding = 20;
                    $destX = $imgWidth - $newLogoWidth - $padding;
                    $destY = $imgHeight - $newLogoHeight - $padding;

                    // Overlay with alpha support
                    imagealphablending($img, true);
                    imagecopy($img, $resizedLogo, $destX, $destY, 0, 0, $newLogoWidth, $newLogoHeight);
                    
                    imagedestroy($logo);
                    imagedestroy($resizedLogo);
                }
            }

            // Capture output to buffer
            ob_start();
            imagepng($img);
            $finalImageData = ob_get_clean();
            imagedestroy($img);
            
            Storage::disk('public')->put($filename, $finalImageData);
        } else {
            // Fallback to raw save if GD fails
            Storage::disk('public')->put($filename, $imageData);
        }

        $this->product->update(['image' => $filename]);
        Log::info("Successfully saved watermarked {$type} image for product: " . $this->product->name);
    }
}
