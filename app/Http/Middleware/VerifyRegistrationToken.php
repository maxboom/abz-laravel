<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyRegistrationToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $jwt = $request->header('Token');

        if (!$jwt) {
            return response()->json(['success' => false, 'message' => 'Missing token'], 401);
        }

        try {
            $decoded = JWT::decode($jwt, new Key(env('JWT_SECRET', 'secret'), 'HS256'));
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired token'], 401);
        }

        $jti = $decoded->jti ?? null;

        $token = Token::where('token', $jti)
            ->where('expires_at', '>', now())
            ->first();

        if (!$token) {
            return response()->json(['success' => false, 'message' => 'The token is expired or already used.'], 401);
        }

        $request->merge(['_verified_token_jti' => $jti]);

        $response = $next($request);

        $token->delete();

        return $response;
    }
}
