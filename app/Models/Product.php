<?php

namespace App\Models;

use App\Http\Traits\UseUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Product extends Model
{
    use HasFactory, UseUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'active', 'quantity', 'price'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean', 'quantity' => 'integer', 'price' => 'float'
    ];

    /**
     * @var array
     */
    protected $appends = ['thumbnail'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
    }

    public function getNameAttribute($value)
    {
        return $value;
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = $value;
    }

    public function getDescriptionAttribute($value)
    {
        return $value;
    }

    public function getThumbnailAttribute()
    {
        $thumbnail = $this->images()->thumbnail();
        return asset('storage/thumbnails/' . $thumbnail->getOriginal('image'));
    }

    /**
     * @return MorphTo
     */
    public function ownerable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'ownerable_id')
            ->where('products.ownerable_type', 'App\Models\User');
    }

    /**
     * @return BelongsTo
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo('App\Models\Store', 'ownerable_id')
            ->where('products.ownerable_type', 'App\Models\Store');
    }

    /**
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany('App\ProductImage');
    }
}
