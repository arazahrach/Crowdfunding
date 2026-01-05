<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'short_title',
        'purpose',
        'description',
        'image',
        'village',
        'district',
        'city',
        'province',
        'target_amount',
        'collected_amount',
        'end_date',
        'status',
    ];

    protected $casts = [
        'end_date' => 'date',
        'target_amount' => 'integer',
        'collected_amount' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(\App\Models\Donation::class);
    }

    public function updates(): HasMany
    {
        return $this->hasMany(Update::class);
    }


}
