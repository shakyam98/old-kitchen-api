<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'price',
        'in_stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'in_stock' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function restaurants(): BelongsToMany
    {
        return $this->belongsToMany(
            Restaurant::class,
            'restaurant_product_variant'
        )
            ->withPivot([
                'in_stock',
                'item_count',
            ])
            ->withTimestamps();
    }

    public function restaurantProductVariants(): HasMany
    {
        return $this->hasMany(RestaurantProductVariant::class);
    }
}
