<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Merchant;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@Pharmacily.com',
            'password' => Hash::make('password'),
        ]);

        // Create sample merchants
        $merchants = [
            [
                'name' => 'TechStore Pro',
                'email' => 'contact@techstorepro.com',
                'phone' => '+1-555-0123',
                'address' => '123 Tech Street, Silicon Valley, CA',
                'website' => 'https://techstorepro.com',
            ],
            [
                'name' => 'Fashion Hub',
                'email' => 'info@fashionhub.com',
                'phone' => '+1-555-0456',
                'address' => '456 Fashion Ave, New York, NY',
                'website' => 'https://fashionhub.com',
            ],
            [
                'name' => 'Home Essentials',
                'email' => 'sales@homeessentials.com',
                'phone' => '+1-555-0789',
                'address' => '789 Home Lane, Chicago, IL',
                'website' => 'https://homeessentials.com',
            ],
        ];

        foreach ($merchants as $merchantData) {
            Merchant::create($merchantData);
        }

        // Create sample products
        $products = [
            [
                'name' => 'Wireless Bluetooth Headphones',
                'description' => 'High-quality wireless headphones with noise cancellation and 30-hour battery life.',
                'price' => 129.99,
                'category' => 'Electronics',
                'brand' => 'TechAudio',
                'stock_quantity' => 50,
                'tags' => ['wireless', 'bluetooth', 'noise-cancellation'],
                'attributes' => ['color' => 'Black', 'weight' => '250g'],
            ],
            [
                'name' => 'Smart Fitness Watch',
                'description' => 'Advanced fitness tracking with heart rate monitor and GPS capabilities.',
                'price' => 199.99,
                'category' => 'Electronics',
                'brand' => 'FitTech',
                'stock_quantity' => 30,
                'tags' => ['fitness', 'smartwatch', 'health'],
                'attributes' => ['color' => 'Silver', 'water-resistant' => true],
            ],
            [
                'name' => 'Organic Cotton T-Shirt',
                'description' => 'Comfortable and eco-friendly cotton t-shirt made from 100% organic materials.',
                'price' => 24.99,
                'category' => 'Clothing',
                'brand' => 'EcoWear',
                'stock_quantity' => 100,
                'tags' => ['organic', 'cotton', 'eco-friendly'],
                'attributes' => ['color' => 'White', 'size' => 'M'],
            ],
            [
                'name' => 'Stainless Steel Water Bottle',
                'description' => 'Insulated water bottle that keeps drinks cold for 24 hours or hot for 12 hours.',
                'price' => 34.99,
                'category' => 'Home & Garden',
                'brand' => 'HydroLife',
                'stock_quantity' => 75,
                'tags' => ['insulated', 'stainless-steel', 'eco-friendly'],
                'attributes' => ['capacity' => '32oz', 'color' => 'Silver'],
            ],
            [
                'name' => 'Professional Camera Lens',
                'description' => 'High-quality zoom lens perfect for professional photography and videography.',
                'price' => 899.99,
                'category' => 'Electronics',
                'brand' => 'PhotoPro',
                'stock_quantity' => 15,
                'tags' => ['camera', 'lens', 'professional'],
                'attributes' => ['focal-length' => '70-200mm', 'aperture' => 'f/2.8'],
            ],
            [
                'name' => 'Yoga Mat Premium',
                'description' => 'Non-slip yoga mat made from eco-friendly materials with alignment guides.',
                'price' => 49.99,
                'category' => 'Sports & Fitness',
                'brand' => 'YogaLife',
                'stock_quantity' => 60,
                'tags' => ['yoga', 'fitness', 'eco-friendly'],
                'attributes' => ['thickness' => '6mm', 'color' => 'Purple'],
            ],
            [
                'name' => 'Wireless Charging Pad',
                'description' => 'Fast wireless charging pad compatible with all Qi-enabled devices.',
                'price' => 39.99,
                'category' => 'Electronics',
                'brand' => 'ChargeTech',
                'stock_quantity' => 40,
                'tags' => ['wireless', 'charging', 'qi-enabled'],
                'attributes' => ['power' => '15W', 'color' => 'Black'],
            ],
            [
                'name' => 'Aromatherapy Diffuser',
                'description' => 'Ultrasonic essential oil diffuser with LED mood lighting and timer.',
                'price' => 29.99,
                'category' => 'Home & Garden',
                'brand' => 'AromaSense',
                'stock_quantity' => 35,
                'tags' => ['aromatherapy', 'essential-oils', 'relaxation'],
                'attributes' => ['capacity' => '300ml', 'color' => 'White'],
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Attach products to merchants (many-to-many relationship)
        $merchants = Merchant::all();
        $products = Product::all();

        foreach ($products as $product) {
            // Randomly assign 1-3 merchants to each product
            $randomMerchants = $merchants->random(rand(1, 3));
            $product->merchants()->attach($randomMerchants, [
                'merchant_price' => $product->price + rand(-10, 20),
                'merchant_stock' => rand(5, 25),
                'is_available' => true,
            ]);
        }
    }
}
