<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @mixin \Eloquent
 * @property int $id
 * @property int $category_id
 * @property int|null $brand_id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $price
 * @property int|null $price_discount
 * @property int|null $price_promo
 * @property int $discount_percent
 * @property int $stock
 * @property float|string $rating
 * @property int $review_count
 * @property int $sold_count
 * @property bool $is_active
 * @property bool $is_featured
 * @property bool $is_bestseller
 * @property bool $is_new
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProductImage> $images
 * @property-read ProductImage|null $primaryImage
 * @method \Illuminate\Database\Eloquent\Relations\HasMany images()
 * @method \Illuminate\Database\Eloquent\Relations\HasOne primaryImage()
 */
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

        $generateUniqueSlug = function ($p) {
            if (! $p->slug) {
                $p->slug = Str::slug($p->name);
            } else {
                $p->slug = Str::slug($p->slug);
            }

            $originalSlug = $p->slug;
            $slug = $originalSlug;
            $counter = 1;

            $query = static::where('slug', $slug);
            if ($p->exists) {
                $query->where('id', '!=', $p->id);
            }

            while ($query->exists()) {
                $slug = $originalSlug.'-'.$counter++;
                $query = static::where('slug', $slug);
                if ($p->exists) {
                    $query->where('id', '!=', $p->id);
                }
            }

            $p->slug = $slug;
        };

        static::creating($generateUniqueSlug);
        static::updating(function ($p) use ($generateUniqueSlug) {
            if ($p->isDirty('name') || $p->isDirty('slug')) {
                $generateUniqueSlug($p);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
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

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
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