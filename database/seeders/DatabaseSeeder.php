<?php

namespace Database\Seeders;

use App\Models\{User, Brand, Category, Product, ProductImage, Order, OrderItem, Payment, Shipment};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name'     => 'Admin Aziziscake',
            'email'    => 'admin@aziziscake.id',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '0813-9233-5843',
            'address'  => 'Bucu, Kec. Kembang, Kabupaten Jepara, Jawa Tengah 59454',
        ]);

        // Demo user
        $user = User::create([
            'name'     => 'Sari Rahayu',
            'email'    => 'sari@example.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'phone'    => '081234567890',
            'address'  => 'Jl. Diponegoro No. 45, Jepara',
        ]);

        // Brands
        $brands = [
            ['name' => 'Aziziscake Original', 'description' => 'Brand utama Aziziscake', 'is_active' => true],
            ['name' => 'Pastry House', 'description' => 'Lini produk pastry premium', 'is_active' => true],
            ['name' => 'Sweet Corner', 'description' => 'Kue manis pilihan', 'is_active' => true],
        ];

        foreach ($brands as $b) {
            Brand::create(array_merge($b, ['slug' => \Illuminate\Support\Str::slug($b['name'])]));
        }

        // Categories
        $categories = [
            ['name' => 'Roti Artisan', 'description' => 'Roti panggang berkualitas tinggi'],
            ['name' => 'Pastry & Croissant', 'description' => 'Pastry lezat berbagai pilihan'],
            ['name' => 'Custom Cake', 'description' => 'Kue custom untuk berbagai acara'],
            ['name' => 'Cinnamon & Roll', 'description' => 'Cinnamon roll dan sejenisnya'],
            ['name' => 'Hampers & Gift', 'description' => 'Paket hampers spesial'],
        ];

        foreach ($categories as $c) {
            Category::create(array_merge($c, ['slug' => \Illuminate\Support\Str::slug($c['name']), 'is_active' => true]));
        }

        // Products
        $products = [
            [
                'category_id'   => 1, 'brand_id' => 1,
                'name'          => 'Artisan Sourdough Bread',
                'description'   => 'Roti sourdough klasik dengan kulit renyah dan tekstur dalam yang chewy. Dipanggang sempurna dengan teknik tradisional selama 3 jam.',
                'price'         => 35000, 'stock' => 50,
                'rating'        => 4.9, 'review_count' => 124, 'sold_count' => 1200,
                'is_featured'   => true, 'is_bestseller' => true, 'is_new' => false,
                'image'         => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400',
            ],
            [
                'category_id'   => 2, 'brand_id' => 2,
                'name'          => 'Butter Croissant Premium',
                'description'   => 'Croissant lapis mentega pilihan, renyah di luar dan lembut di dalam. Dibuat dengan teknik laminating yang menghasilkan 48 lapisan.',
                'price'         => 22000, 'stock' => 80,
                'rating'        => 4.8, 'review_count' => 89, 'sold_count' => 890,
                'is_featured'   => true, 'is_bestseller' => false, 'is_new' => true,
                'image'         => 'https://images.unsplash.com/photo-1551024601-bec78aea704b?w=400',
            ],
            [
                'category_id'   => 3, 'brand_id' => 1,
                'name'          => 'Custom Birthday Cake',
                'description'   => 'Kue ulang tahun custom dengan desain sesuai permintaan. Tersedia berbagai pilihan rasa: vanilla, coklat, red velvet, dan lemon.',
                'price'         => 250000, 'price_discount' => 200000, 'discount_percent' => 20,
                'stock'         => 20,
                'rating'        => 5.0, 'review_count' => 201, 'sold_count' => 450,
                'is_featured'   => true, 'is_bestseller' => true, 'is_new' => false,
                'image'         => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400',
            ],
            [
                'category_id'   => 4, 'brand_id' => 3,
                'name'          => 'Classic Cinnamon Roll',
                'description'   => 'Cinnamon roll lembut berlapis cream cheese frosting. Harum kayu manis yang menggoda dengan glaze manis sempurna.',
                'price'         => 28000, 'stock' => 60,
                'rating'        => 4.7, 'review_count' => 67, 'sold_count' => 670,
                'is_featured'   => false, 'is_bestseller' => false, 'is_new' => false,
                'image'         => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=400',
            ],
            [
                'category_id'   => 5, 'brand_id' => 1,
                'name'          => 'Premium Bakery Hampers',
                'description'   => 'Paket hampers premium berisi berbagai pilihan roti dan kue terbaik. Cocok untuk hadiah ulang tahun, pernikahan, atau lebaran.',
                'price'         => 180000, 'stock' => 30,
                'rating'        => 4.8, 'review_count' => 45, 'sold_count' => 120,
                'is_featured'   => true, 'is_bestseller' => false, 'is_new' => true,
                'image'         => 'https://images.unsplash.com/photo-1606788075761-7fbd1f6f04d2?w=400',
            ],
        ];

        foreach ($products as $p) {
            $imageUrl = $p['image'];
            unset($p['image']);
            $p['slug'] = \Illuminate\Support\Str::slug($p['name']) . '-' . uniqid();
            $p['is_active'] = true;
            $product = Product::create($p);

            ProductImage::create([
                'product_id' => $product->id,
                'image'      => $imageUrl, // In production, store actual file
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }

        // Sample order
        $order = Order::create([
            'user_id'              => $user->id,
            'subtotal'             => 57000,
            'shipping_cost'        => 15000,
            'total'                => 72000,
            'status'               => 'completed',
            'shipping_address'     => 'Jl. Diponegoro No. 45',
            'shipping_city'        => 'Jepara',
            'shipping_province'    => 'Jawa Tengah',
            'shipping_postal_code' => '59451',
            'shipping_phone'       => '081234567890',
        ]);

        OrderItem::create([
            'order_id'     => $order->id,
            'product_id'   => 1,
            'product_name' => 'Artisan Sourdough Bread',
            'price'        => 35000,
            'quantity'     => 1,
            'subtotal'     => 35000,
        ]);

        OrderItem::create([
            'order_id'     => $order->id,
            'product_id'   => 2,
            'product_name' => 'Butter Croissant Premium',
            'price'        => 22000,
            'quantity'     => 1,
            'subtotal'     => 22000,
        ]);

        Payment::create([
            'order_id' => $order->id,
            'method'   => 'transfer_bank',
            'amount'   => 72000,
            'status'   => 'paid',
            'paid_at'  => now(),
        ]);

        Shipment::create([
            'order_id'        => $order->id,
            'courier'         => 'JNE',
            'tracking_number' => 'JNE123456789',
            'cost'            => 15000,
            'estimated_days'  => '2-3 hari',
            'status'          => 'delivered',
            'shipped_at'      => now()->subDays(2),
            'delivered_at'    => now()->subDay(),
        ]);
    }
}
