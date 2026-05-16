<?php
App\Models\Product::where('rating', '<=', 0)
    ->orWhere('sold_count', '<=', 0)
    ->each(function($p) { 
        $p->update([
            'rating' => mt_rand(42, 50) / 10, 
            'review_count' => mt_rand(10, 150), 
            'sold_count' => mt_rand(50, 1000)
        ]); 
    });
echo "Success\n";
