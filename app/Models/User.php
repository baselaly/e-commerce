<?php

namespace App\Models;

use App\Http\Traits\UseUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, UseUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'active', 'verified', 'image', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean', 'verified' => 'boolean'
    ];

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = $value;
    }

    public function getFirstNameAttribute($value)
    {
        return $value;
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = $value;
    }

    public function getLastNameAttribute($value)
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

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = $value;
    }

    public function getEmailAttribute($value)
    {
        return $value;
    }

    public function setImageAttribute($value)
    {
        $image_name = time() . uniqid() . '.' . $value->getClientOriginalExtension();
        if (!Storage::disk('users')->put($image_name, $value)) {
            throw new \Exception('error in uploading user image');
        }
        $this->attributes['image'] = $image_name;
    }

    public function getImageAttribute($value)
    {
        if (!$value) {
            return asset('storage/users/default.jpg');
        }
        return asset('storage/users/' . $value);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
