<?php namespace Graffon\Graffauth\Middleware;

use Closure;
use Graffon\Graffauth\Models\Key;

class VerifyAPIKey
{
    public function handle($request, Closure $next)
    {
        $apiKey = $request->header('graff-auth-key');

        $key = Key::where('api_key', $apiKey)->where('is_active', true)->first();

        if (!$key) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Check if IP protection is enabled
        if ($key->is_ip_active) {
            // Get the list of allowed IPs from the key record
            $allowedIps = explode(',', $key->ip_address); // Assuming 'allowed_ips' column in the database

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

        // Proceed with the request
        return $next($request);
    }
}