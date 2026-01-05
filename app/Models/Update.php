<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    protected $table = 'updates'; // sesuai blade kamu untuk halaman updates

    protected $fillable = ['campaign_id', 'content', 'image'];
}
