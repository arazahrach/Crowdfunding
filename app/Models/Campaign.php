<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'target_amount',
        'collected_amount',
        'end_date',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'end_date' => 'datetime',
        'target_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
    ];

    /**
     * Get the donations for the campaign.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the updates for the campaign.
     */
    public function updates()
    {
        return $this->hasMany(Update::class);
    }

    /**
     * Get the progress percentage of collected funds.
     *
     * @return int
     */
    public function getProgressAttribute()
    {
        if ($this->target_amount <= 0) {
            return 0;
        }
        return min(100, round(($this->collected_amount / $this->target_amount) * 100));
    }
}