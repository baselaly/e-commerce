<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;

/**
 * Trait Used to generate uuid for models
 */
trait UseUuids
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->{$post->getKeyName()} = (string) Str::uuid();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
