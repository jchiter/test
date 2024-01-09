<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPropertyValue extends Model
{
    protected $perPage = 40;
    protected $hidden = [
        'property_value_id',
        'pivot'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function toArray(): array
    {
        return $this->product()->get()->toArray();
    }
}
