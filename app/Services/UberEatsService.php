<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UberEatsService
{
    protected $clientId;
    protected $clientSecret;
    protected $baseUrl;
    protected $storeId;

    public function __construct()
    {
        $this->clientId = config('services.ubereats.client_id');
        $this->clientSecret = config('services.ubereats.client_secret');
        $this->storeId = config('services.ubereats.store_id');
        
        $env = config('services.ubereats.env', 'sandbox');
        $this->baseUrl = $env === 'production' 
            ? 'https://api.uber.com/v1/eats' 
            : 'https://api.uber.com/v1/eats'; // Note: Uber often uses same base for sandbox but different credentials/store_ids
    }

    /**
     * Get OAuth 2.0 Access Token
     */
    public function getAccessToken()
    {
        return Cache::remember('ubereats_access_token', 3500, function () {
            $response = Http::asForm()->post('https://login.uber.com/oauth/v2/token', [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials',
                'scope' => 'eats.store eats.order',
            ]);

            if ($response->successful()) {
                return $response->json('access_token');
            }

            Log::error('Uber Eats Auth Failed', ['response' => $response->body()]);
            return null;
        });
    }

    /**
     * Sync Local Products to Uber Eats Menu
     */
    public function syncMenu($products)
    {
        $token = $this->getAccessToken();
        if (!$token) return false;

        // Simplified Uber Eats Menu Structure
        $menu = [
            'menus' => [
                [
                    'id' => 'main-menu',
                    'title' => [ 'translations' => [ 'en_us' => 'Main Menu' ] ],
                    'sections' => [
                        [
                            'id' => 'all-products',
                            'title' => [ 'translations' => [ 'en_us' => 'All Products' ] ],
                            'item_ids' => $products->pluck('id')->map(fn($id) => (string)$id)->toArray()
                        ]
                    ]
                ]
            ],
            'items' => $products->map(function($product) {
                return [
                    'id' => (string)$product->id,
                    'title' => [ 'translations' => [ 'en_us' => $product->name ] ],
                    'description' => [ 'translations' => [ 'en_us' => $product->description ] ],
                    'price_info' => [
                        'price' => (int)($product->price * 100), // Uber uses cents
                        'currency_code' => 'USD'
                    ],
                    'image_url' => $product->image ? asset('storage/' . $product->image) : null
                ];
            })->toArray()
        ];

        $response = Http::withToken($token)
            ->put("{$this->baseUrl}/stores/{$this->storeId}/menu", $menu);

        if ($response->successful()) {
            Log::info('Uber Eats Menu Synced Successfully');
            return true;
        }

        Log::error('Uber Eats Menu Sync Failed', ['response' => $response->body()]);
        return false;
    }

    /**
     * Accept a POS Order
     */
    public function acceptOrder($orderId)
    {
        $token = $this->getAccessToken();
        if (!$token) return false;

        $response = Http::withToken($token)
            ->post("{$this->baseUrl}/orders/{$orderId}/accept_pos_order");

        return $response->successful();
    }
}
