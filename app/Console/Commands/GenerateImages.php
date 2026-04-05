<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Product;
use App\Jobs\GenerateProductImage;

#[Signature('products:generate-images')]
#[Description('Dispatches Gemini image generation jobs for products missing images.')]
class GenerateImages extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = Product::whereNull('image')->orWhere('image', '')->get();

        if ($products->isEmpty()) {
            $this->info('No products found missing images!');
            return;
        }

        $this->info('Found ' . $products->count() . ' products missing images.');
        
        $bar = $this->output->createProgressBar(count($products));
        $bar->start();

        foreach ($products as $product) {
            GenerateProductImage::dispatch($product);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Jobs dispatched successfully to the queue.');
    }
}
