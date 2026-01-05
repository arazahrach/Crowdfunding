<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    protected $fillable = [
        'campaign_id',
        'user_id',
        'name',
        'email',
        'phone',
        'amount',
        'message',
        'is_anonymous',
        'status',
        'payment_ref',
        'order_id',
        'snap_token',
        'payment_type',
        'transaction_status',
        'fraud_status',
        'raw_response',

    ];

    protected $casts = [
        'amount' => 'integer',
        'is_anonymous' => 'boolean',
        'raw_response' => 'array',

    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
    

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

}
