<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $table = 'donations';

    protected $casts = [
        'midtrans_response' => 'array',
        'is_anonymous' => 'boolean',
    ];

    protected $fillable = [
        'campaign_id',
        'user_id',
        'name','email','phone',
        'amount',
        'status',
        'payment_method',
        'transaction_id',
        'snap_token',
        'midtrans_response',
        'is_anonymous',
        'message',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
}
