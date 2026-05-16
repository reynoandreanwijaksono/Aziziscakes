<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Eloquent
 * @property int $id
 * @property int $product_id
 * @property string $image
 * @property bool $is_primary
 * @property int $sort_order
 * @method \Illuminate\Database\Eloquent\Relations\BelongsTo product()
 */
class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image', 'is_primary', 'sort_order'];

    protected $casts = ['is_primary' => 'boolean'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }
}
