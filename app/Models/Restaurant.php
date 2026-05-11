<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    protected $fillable = [
        'name',
        'location',
        'mobile',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'restaurant_product'
        )
            ->withPivot([
                'in_stock',
                'item_count',
            ])
            ->withTimestamps();
    }

    public function productVariants(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductVariant::class,
            'restaurant_product_variant'
        )
            ->withPivot([
                'in_stock',
                'item_count',
            ])
            ->withTimestamps();
    }

    public function restaurantProducts(): HasMany
    {
        return $this->hasMany(RestaurantProduct::class);
    }

    public function restaurantProductVariants(): HasMany
    {
        return $this->hasMany(RestaurantProductVariant::class);
    }
}
