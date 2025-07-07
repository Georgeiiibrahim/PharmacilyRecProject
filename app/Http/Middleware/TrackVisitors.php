<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Jenssegers\Agent\Agent;

class TrackVisitors
{
    public function handle(Request $request, Closure $next)
    {
        // Skip tracking for admin routes
        if ($request->is('admin/*')) {
            return $next($request);
        }

        // Create agent instance to detect device/browser
        $agent = new Agent();
        
        // Get visitor data
        $sessionId = $request->session()->getId();
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $pageUrl = $request->fullUrl();
        $referrerUrl = $request->header('referer');
        
        // Detect device type
        $deviceType = 'desktop';
        if ($agent->isMobile()) {
            $deviceType = 'mobile';
        } elseif ($agent->isTablet()) {
            $deviceType = 'tablet';
        }
        
        // Detect browser and OS
        $browser = $agent->browser();
        $os = $agent->platform();
        
        // Check if returning visitor
        $isReturning = Visitor::where('session_id', $sessionId)
            ->where('visited_at', '<', now()->subDay())
            ->exists();
        
        // Create visitor record
        Visitor::create([
            'session_id' => $sessionId,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'page_url' => $pageUrl,
            'referrer_url' => $referrerUrl,
            'browser' => $browser,
            'device_type' => $deviceType,
            'os' => $os,
            'is_returning' => $isReturning,
            'visited_at' => now(),
        ]);

        return $next($request);
    }
} 