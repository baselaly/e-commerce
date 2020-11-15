<?php

namespace App\Models;

use App\Http\Traits\UseUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory, UseUuids;

    /**
     * @var array
     */
    protected $fillable = ['product_id', 'price', 'quantity', 'checkout_id'];

    /**
     * @var array
     */
    protected $casts = ['price' => 'integer', 'quantity' => 'float'];

    /**
     * @return BelongsTo
     */
    public function checkout(): BelongsTo
    {
        return $this->belongsTo('App\Models\Checkout');
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo('App\Models\Product');
    }
}
