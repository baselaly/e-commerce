<?php

namespace App\Models;

use App\Http\Traits\UseUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Store extends Model
{
    use HasFactory, UseUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'address', 'phone', 'logo',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
    }

    public function getNameAttribute($value)
    {
        return $value;
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = $value;
    }

    public function getAddressAttribute($value)
    {
        return $value;
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = $value;
    }

    public function getPhoneAttribute($value)
    {
        return $value;
    }

    public function setLogoAttribute($value)
    {
        $image_name = time() . uniqid() . '.' . $value->getClientOriginalExtension();
        if (!Storage::disk('stores')->put($image_name, File::get($value))) {
            throw new \Exception('error in uploading store image');
        }
        $this->attributes['logo'] = $image_name;
    }

    public function getLogoAttribute($value)
    {
        if (!$value) {
            return asset('storage/stores/default.jpg');
        }
        return asset('storage/stores/' . $value);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return MorphMany
     */
    public function products(): MorphMany
    {
        return $this->morphMany('App\Models\Product', 'ownerable');
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
}
