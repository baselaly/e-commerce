<?php

namespace App\Models;

use App\Http\Traits\UseUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;

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
        $image_name = time() . uniqid() . '.' . $value->getClientOriginalExtension();
        if (!Storage::disk('products')->put($image_name, File::get($value))) {
            throw new \Exception('error in uploading store image');
        }
        $this->attributes['image'] = $image_name;

        if ($this->thumbnail) {
            // this image is thumbnail , upload it in thumbnails folder
            $thumbnail = Image::make($value);
            $thumbnail->resize(200, 200);
            if (!Storage::disk('thumbnails')->put($image_name, $thumbnail)) {
                throw new \Exception('error in uploading thumbnail');
            }
        }
    }

    public function getImageAttribute($value)
    {
        return asset('storage/products/' . $value);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo('App\Models\Product');
    }

    /**
     * @param mixed $query
     * 
     * @return [type]
     */
    public function scopeThumbnail($query)
    {
        return $query->where('thumbnail', true);
    }
}
