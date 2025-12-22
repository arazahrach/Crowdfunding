<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Update extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'campaign_id',
        'content',
        'image',
    ];

    /**
     * Get the campaign that this update belongs to.
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}