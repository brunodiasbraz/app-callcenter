<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Importe o modelo de usuário adequado

class ValidateAccess
{
    public function handle($request, Closure $next)
    {
        $email = $request->header('user');
        $password = $request->header('key');
        $token = $request->bearerToken();

        if ($email && $password) {
            // Autenticação por usuário e senha
            if (!Auth::attempt(['email' => $email, 'password' => $password])) {
                return response()->json(['error' => 'Unauthorized. Invalid email or password.'], 401);
            }
        } elseif ($token) {
            // Autenticação por token
            if (!$this->isValidBearerToken($token)) {
                return response()->json(['error' => 'Unauthorized. Invalid token.'], 401);
            }
        } else {
            return response()->json(['error' => 'Unauthorized. Missing credentials.'], 401);
        }

        return $next($request);
    }

    private function isValidBearerToken($token)
    {
        // Lógica para verificar se o token é válido com Sanctum
        return $token && Auth::guard('sanctum')->check();
    }
}
