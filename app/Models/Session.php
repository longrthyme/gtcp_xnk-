<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Session extends Model
{
    use HasFactory;

    protected $appends = ['expires_at'];

    public $lifetime_minute = 5;

    public function isExpired()
    {
        return $this->last_activity < Carbon::now()->subMinutes($this->lifetime_minute)->getTimestamp();
    }

    public function getExpiresAtAttribute()
    {
        return Carbon::createFromTimestamp($this->last_activity)->addMinutes($this->lifetime_minute)->toDateTimeString();
    }
}
