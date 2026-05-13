<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AgencyAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log access attempt for debugging
        Log::info('AgencyAuth middleware: Checking agency authentication', [
            'url' => $request->url(),
            'method' => $request->method(),
            'session_id' => session()->getId(),
            'agency_id' => session('agency_id'),
            'agency_name' => session('agency_name'),
            'has_session' => session()->isStarted()
        ]);

        // Check if agency is authenticated via session
        if (!session('agency_id')) {
            Log::warning('AgencyAuth middleware: No agency session found', [
                'url' => $request->url(),
                'all_session_data' => session()->all()
            ]);

            // Check if this is an AJAX request
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'error' => 'Agency authentication required',
                    'redirect' => route('login')
                ], 401);
            }
            
            // For regular requests, redirect to login
            return redirect()->route('login')
                ->with('error', 'Please log in as an agency to access this page.');
        }

        // Verify agency exists and session is valid
        $agencyId = session('agency_id');
        if (!$agencyId || !is_numeric($agencyId)) {
            Log::warning('AgencyAuth middleware: Invalid agency session', [
                'agency_id' => $agencyId,
                'type' => gettype($agencyId)
            ]);
            
            session()->flush(); // Clear invalid session
            return redirect()->route('login')
                ->with('error', 'Invalid agency session. Please log in again.');
        }

        Log::info('AgencyAuth middleware: Agency authentication successful', [
            'agency_id' => $agencyId,
            'agency_name' => session('agency_name')
        ]);

        return $next($request);
    }
}
