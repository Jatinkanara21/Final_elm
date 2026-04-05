<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\AdminSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@elmgrove.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'is_admin' => 1,
            ]
        );

        // 2. Create Regular User
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'is_admin' => 0,
            ]
        );

        // 3. Create Admin Settings
        AdminSetting::updateOrCreate(
            ['key' => 'orders_enabled'],
            ['value' => 'true', 'type' => 'boolean']
        );

        // 4. Create Categories & Products
        $categoriesData = [
            'Whiskey' => [
                [
                    'name' => 'Glenfiddich 12 Year Old Single Malt',
                    'description' => 'Matured in the finest American oak and European oak sherry casks for at least 12 years, ensuring a sweet, subtle oak flavor.',
                    'brand' => 'Glenfiddich',
                ],
                [
                    'name' => 'Jack Daniel\'s Tennessee Whiskey',
                    'description' => 'Mellowed drop by drop through 10 feet of sugar maple charcoal, then matured in handcrafted barrels of handcrafted oak.',
                    
                    'brand' => 'Jack Daniel\'s',
                ],
                [
                    'name' => 'Maccallan 18 Years Double Cask',
                    'description' => 'A distinct single malt with a warmer, sweeter character arriving from the combination of sherry seasoned European and American oak.',
                    
                    'brand' => 'Maccallan',
                ],
            ],
            'Wine' => [
                [
                    'name' => 'Chateau Margaux 2015',
                    'description' => 'An opulent, structured Bordeaux wine with rich notes of blackberry, cassis, and subltle vanilla hints.',
                    
                    'brand' => 'Chateau Margaux',
                ],
                [
                    'name' => 'Cloudy Bay Sauvignon Blanc',
                    'description' => 'Vibrant, refreshing white wine from New Zealand with notes of passionfruit, ripe peach, and lime.',
                    
                    'brand' => 'Cloudy Bay',
                ],
                [
                    'name' => 'Moët & Chandon Brut Impérial',
                    'description' => 'The iconic champagne of the house. Created in 1869, it embodies steady balance and fruity body.',
                    
                    'brand' => 'Moët & Chandon',
                ],
            ],
            'Beer' => [
                [
                    'name' => 'Heineken Lager Beer (6-Pack)',
                    'description' => 'Premium layered lager with 100% barley malt and water. Pure malt lager of 5% alcohol.',
                    
                    'brand' => 'Heineken',
                ],
                [
                    'name' => 'Guinness Draught Stout (4-Pack Can)',
                    'description' => 'Rich and creamy. Distinctive, ruby red colour with velvet smooth finish.',
                    
                    'brand' => 'Guinness',
                ],
            ],
            'Vodka' => [
                [
                    'name' => 'Grey Goose Premium Vodka',
                    'description' => 'Distilled using French wheat from the La Beauce region and water filtered through limestone.',
                    
                    'brand' => 'Grey Goose',
                ],
                [
                    'name' => 'Absolut Original Vodka',
                    'description' => 'Rich, full-bodied and complex, yet smooth and mellow with a distinct character of grain.',
                    
                    'brand' => 'Absolut',
                ],
            ],
        ];

        foreach ($categoriesData as $categoryName => $products) {
            $category = Category::updateOrCreate(
                ['name' => $categoryName],
                [
                    'slug' => Str::slug($categoryName),
                    'description' => 'Premium ' . $categoryName . ' selections.',
                ]
            );

            foreach ($products as $productData) {
                Product::updateOrCreate(
                    ['name' => $productData['name']],
                    array_merge($productData, [
                        'category_id' => $category->id,
                        'slug' => Str::slug($productData['name']),
                        // Leave 'image' as null for now, or you can add absolute Unsplash URL logic if preferred, 
                        // but null triggers the Blade fallback placeholders correctly.
                    ])
                );
            }
        }
    }
}
