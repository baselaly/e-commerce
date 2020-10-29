<?php

namespace App\Models;

use App\Http\Traits\UseUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory, UseUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image', 'thumbnail', 'product_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'thumbnail' => 'boolean'
    ];

    public function setImageAttribute($value)
    {
        $this->attributes['name'] = $value;
    }

    public function getImageAttribute($value)
    {
        return $value;
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo('App\Models\Product');
    }
}
