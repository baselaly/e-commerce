<?php

namespace App\Models;

use App\Http\Traits\UseUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    use HasFactory, UseUuids;

    protected $fillable = ['body', 'user_id', 'reviewable_id', 'reviewable_type'];

    protected $with = ['user'];

    /**
     * user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
    
    /**
     * reviewable
     *
     * @return MorphTo
     */
    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }
}
