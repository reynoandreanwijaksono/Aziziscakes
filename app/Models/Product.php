<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'brand_id', 'name', 'slug', 'description',
        'price', 'price_discount', 'price_promo', 'discount_percent',
        'stock', 'rating', 'review_count', 'sold_count',
        'is_active', 'is_featured', 'is_bestseller', 'is_new',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_new' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($p) => $p->slug = Str::slug($p->name));
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function priceHistories()
    {
        return $this->hasMany(PriceHistory::class)->latest();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function getEffectivePriceAttribute(): int
    {
        return $this->price_promo ?? $this->price_discount ?? $this->price;
    }

    public function getImageUrlAttribute(): string
    {
        $primary = $this->images->firstWhere('is_primary', true);
        $imagePath = $primary?->image ?? $this->images->first()?->image;

        if (!$imagePath) {
            return asset('images/no-image.png');
        }

        // If already a full URL (http/https), return as-is
        if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
            return $imagePath;
        }

        return asset('storage/' . $imagePath);
    }
}