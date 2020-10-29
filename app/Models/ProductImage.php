<?php

namespace App\Models;

use App\Http\Traits\UseUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory, UseUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image', 'product_id'
    ];

    public function setImageAttribute($value)
    {
        $image_name = time() . uniqid() . '.' . $value->getClientOriginalExtension();
        if (!Storage::disk('products')->put($image_name, File::get($value))) {
            throw new \Exception('error in uploading store image');
        }
        $this->attributes['image'] = $image_name;
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
}
