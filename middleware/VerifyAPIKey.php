<?php namespace Graffon\Graffauth\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Graffon\Graffauth\Models\Key;

class VerifyAPIKey
{
    public function handle($request, Closure $next)
    {
        // Get the Authorization header
        $authHeader = $request->header('Authorization');
        $authControl = $request->header('X-GRAFF-AUTH-CONTROL');

        // Check if the Authorization header exists and starts with "Bearer "
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Extract the token from the Authorization header
        $token = substr($authHeader, 7); // Remove "Bearer " from the beginning

        // Check if grant_type is required and valid
        if ($authControl !== 'Advance') {
            // Find the key in the database
            $key = Key::where('api_key', $token)->where('is_active', true)->first();
        } else {
            // Decode the Base64 string
            $decodedToken = base64_decode($token, true);
            if (!$decodedToken || !str_contains($decodedToken, ':')) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            // Extract API key and secret
            [$apiToken, $apiKey] = explode(':', $decodedToken, 2);

            Log::info($apiToken);
            Log::info($apiKey);
            
            $key = Key::where('api_key', $apiKey)->where('app_key', $apiToken)->where('is_active', true)->first();
        }

        if (!$key) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Check if IP protection is enabled
        if ($key->is_ip_active) {
            // Get the list of allowed IPs from the key record
            $allowedIps = explode(',', $key->ip_address);

            // Check for the presence of 0.0.0.0 in the allowed IPs list
            if (!in_array('0.0.0.0', $allowedIps)) {
                // Get the client's IP address
                $clientIp = $request->ip();

                // Check if the client's IP is in the allowed list
                if (!in_array($clientIp, $allowedIps)) {
                    return response()->json(['error' => 'Unauthorized'], 403);
                }
            }
        }

        // Check if Origin protection is enabled
        if ($key->is_origins_active) {
            // Get the list of allowed origins from the key record
            $allowedDomains = explode(',', $key->origins);

            // Get the Origin and Referer headers
            $origin = $request->header('Origin') ?? '';
            $referer = $request->header('Referer') ?? '';

            // If both headers are empty, deny access
            if (empty($origin) && empty($referer)) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            // Check if Origin or Referer is in the allowed origins
            $isValidOrigin = !empty($origin) && in_array($origin, $allowedDomains);
            $isValidReferer = !empty($referer) && in_array(parse_url($referer, PHP_URL_HOST), $allowedDomains);

            if (!$isValidOrigin && !$isValidReferer) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        // Check if Origin protection is enabled
        if ($key->is_app_protect_active) {
            // Get the list of allowed apps from the key record
            $allowedApps = explode(',', $key->apps);

            // Get the Origin and Referer headers
            $app = $request->header('App-Package') ?? '';

            // If both headers are empty, deny access
            if (empty($app) && empty($referer)) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            // Check if app or Referer is in the allowed apps
            $isValidApp = !empty($app) && in_array($app, $allowedApps);

            if (!$isValidApp) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        // Proceed with the request
        return $next($request);
    }
}