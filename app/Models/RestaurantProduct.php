<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestaurantProduct extends Model
{
    protected $table = 'restaurant_product';

    protected $fillable = [
        'restaurant_id',
        'product_id',
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

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
