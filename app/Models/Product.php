<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property-read Product $product
 */
class Product extends Model
{
    protected $fillable = [
        'name',
        'cost',
        'count'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function propertyValues(): BelongsToMany
    {
        return $this->belongsToMany(PropertyValue::class, 'product_property_values');
    }
}
