<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Str;

class ProductsImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Define common key mappings for robustness
        $name = $row['name'] ?? $row['product_name'] ?? $row['product'] ?? null;
        $categoryName = $row['category'] ?? $row['category_name'] ?? 'Uncategorized';
        $description = $row['description'] ?? $row['desc'] ?? '';
        $price = $row['price'] ?? $row['retail_price'] ?? $row['msrp'] ?? 0;
        $retailPrice = $row['retail_price'] ?? $row['msrp'] ?? $row['original_price'] ?? null;
        $stock = $row['stock'] ?? $row['quantity'] ?? $row['qty'] ?? 0;
        $brand = $row['brand'] ?? '';

        // If name is missing, skip the row or handle error
        if (!$name) {
            return null;
        }

        // Handle Category
        $category = Category::firstOrCreate(
            ['name' => $categoryName],
            ['slug' => Str::slug($categoryName), 'description' => 'Imported category']
        );

        $slug = Str::slug($name);

        // Use firstOrNew to obtain an instance and let Excel handle the save
        $product = Product::firstOrNew(['slug' => $slug]);
        $product->fill([
            'category_id'  => $category->id,
            'name'         => $name,
            'description'  => $description,
            'brand'        => $brand,
        ]);

        return $product;
    }
}
