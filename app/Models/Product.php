<?php

namespace App\Models;

use App\Http\Traits\UseUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;

class Product extends Model
{
    use HasFactory, UseUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'active', 'quantity', 'price', 'ownerable_type', 'ownerable_id', 'thumbnail', 'featured',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean', 'quantity' => 'integer', 'price' => 'float', 'featured' => 'boolean',
    ];

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

    public function setThumbnailAttribute($value)
    {
        $image_name = time() . uniqid() . '.' . $value->getClientOriginalExtension();

        $thumbnail = Image::make($value)->resize(400, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode($value->getClientOriginalExtension());

        if (!Storage::disk('thumbnails')->put($image_name, $thumbnail)) {
            throw new \Exception('error in uploading thumbnail');
        }
        $this->attributes['thumbnail'] = $image_name;
    }

    public function getThumbnailAttribute($value)
    {
        return asset('storage/thumbnails/' . $value);
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
        return $this->hasMany('App\Models\ProductImage');
    }

    /**
     * likes
     *
     * @return MorphMany
     */
    public function likes(): MorphMany
    {
        return $this->morphMany('App\Models\Like', 'likeable');
    }

    /**
     * reviews
     *
     * @return MorphMany
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany('App\Models\Review', 'reviewable');
    }
}
