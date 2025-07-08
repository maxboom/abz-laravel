<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Token;

class TokenController
{
    public function generate(Request $request)
    {
        $issuedAt = time();
        $expiresAt = $issuedAt + 60 * 40; // 40 минут
        $jti = (string) Str::uuid();

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expiresAt,
            'jti' => $jti,
            'purpose' => 'registration'
        ];

        $jwt = JWT::encode($payload, env('JWT_SECRET', 'secret'), 'HS256');

        Token::create([
            'token' => $jti,
            'expires_at' => date('Y-m-d H:i:s', $expiresAt)
        ]);

        return response()->json([
            'success' => true,
            'token' => $jwt
        ]);
    }
}
