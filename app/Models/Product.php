<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'in_stock',
        'image_url',
        'product_type_id',
        'is_new',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'in_stock' => 'boolean',
        'is_new' => 'boolean',
    ];

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function addons(): BelongsToMany
    {
        return $this->belongsToMany(
            Addon::class,
            'product_addon'
        )->withTimestamps();
    }

    public function restaurants(): BelongsToMany
    {
        return $this->belongsToMany(
            Restaurant::class,
            'restaurant_product'
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

    public function productAddons(): HasMany
    {
        return $this->hasMany(ProductAddon::class);
    }
}
