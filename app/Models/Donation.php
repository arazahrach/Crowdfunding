<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'campaign_id',
        'name',
        'email',
        'phone',
        'amount',
        'payment_method',
        'transaction_id',
        'status',
        'midtrans_response',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'midtrans_response' => 'array', // Laravel akan otomatis serialize/unserialize JSON
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'midtrans_response', // opsional: sembunyikan detail payment sensitif di API
    ];

    /**
     * Get the campaign that this donation belongs to.
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}