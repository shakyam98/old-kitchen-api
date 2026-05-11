<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestaurantProductVariant extends Model
{
    protected $table = 'restaurant_product_variant';

    protected $fillable = [
        'restaurant_id',
        'product_variant_id',
        'in_stock',
        'item_count',
    ];

    protected $casts = [
        'in_stock' => 'boolean',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
