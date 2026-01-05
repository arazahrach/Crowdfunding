<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'campaigns';

    protected $casts = [
        'is_active' => 'boolean',
        'end_date' => 'date',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class, 'campaign_id');
    }

    public function updates()
    {
        // kalau tabel kamu namanya "updates"
        return $this->hasMany(Update::class, 'campaign_id');
    }
    
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    public function getRouteKeyName(): string

{
    return 'slug';
}

protected $fillable = [
    'user_id','category_id',
    'title','short_title','slug','goal',
    'description','usage_details',
    'village','district','city','province',
    'image','target_amount','collected_amount',
    'end_date','is_active','status'
];

public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}




}
