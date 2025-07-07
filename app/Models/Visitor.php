<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'ip_address',
        'user_agent',
        'page_url',
        'referrer_url',
        'country',
        'city',
        'region',
        'browser',
        'device_type',
        'os',
        'time_spent',
        'is_bounce',
        'is_returning',
        'visited_at',
    ];

    protected $casts = [
        'is_bounce' => 'boolean',
        'is_returning' => 'boolean',
        'visited_at' => 'datetime',
        'time_spent' => 'integer',
    ];

    public function scopeToday($query)
    {
        return $query->whereDate('visited_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('visited_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('visited_at', now()->month);
    }

    public function scopeByCountry($query, $country)
    {
        return $query->where('country', $country);
    }

    public function scopeByDevice($query, $deviceType)
    {
        return $query->where('device_type', $deviceType);
    }

    public function scopeUniqueVisitors($query)
    {
        return $query->distinct('session_id');
    }

    public function scopeReturningVisitors($query)
    {
        return $query->where('is_returning', true);
    }

    public function scopeNewVisitors($query)
    {
        return $query->where('is_returning', false);
    }

    public function scopeBounceVisitors($query)
    {
        return $query->where('is_bounce', true);
    }

    public function getFormattedTimeSpentAttribute()
    {
        if (!$this->time_spent) {
            return 'N/A';
        }

        $minutes = floor($this->time_spent / 60);
        $seconds = $this->time_spent % 60;

        if ($minutes > 0) {
            return "{$minutes}m {$seconds}s";
        }

        return "{$seconds}s";
    }

    public function getDeviceIconAttribute()
    {
        switch ($this->device_type) {
            case 'mobile':
                return 'fas fa-mobile-alt';
            case 'tablet':
                return 'fas fa-tablet-alt';
            case 'desktop':
                return 'fas fa-desktop';
            default:
                return 'fas fa-question';
        }
    }

    public function getBrowserIconAttribute()
    {
        $browser = strtolower($this->browser ?? '');
        
        if (str_contains($browser, 'chrome')) {
            return 'fab fa-chrome';
        } elseif (str_contains($browser, 'firefox')) {
            return 'fab fa-firefox';
        } elseif (str_contains($browser, 'safari')) {
            return 'fab fa-safari';
        } elseif (str_contains($browser, 'edge')) {
            return 'fab fa-edge';
        } else {
            return 'fas fa-globe';
        }
    }
} 