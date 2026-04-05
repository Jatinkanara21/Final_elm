<?php

namespace App\Observers;

use App\Models\Product;
use App\Jobs\GenerateProductImage;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        if (empty($product->image)) {
            GenerateProductImage::dispatch($product);
        }
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        if (empty($product->image) && $product->isDirty('name')) {
            GenerateProductImage::dispatch($product);
        }
    }
}
