<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$product = \App\Models\Product::first();
if ($product) {
    $product->image = null;
    $product->save();
    echo "Cleared image for product ID: " . $product->id . "\n";
} else {
    echo "No products found.\n";
}
