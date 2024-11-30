<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function logout()
    {
        Auth::logout();
        if (env('APP_ENV') === 'local') {
            return redirect(env('APP_URL'));
        }
        $redirectUri = env('APP_URL');
        $clientId = env('KEYCLOAK_CLIENT_ID');
        $logoutUrl = Socialite::driver('keycloak')
        ->getLogoutUrl($redirectUri, $clientId);

        return redirect($logoutUrl);
    }

    public function redirectToProvider()
    {
        if (env('APP_ENV') === 'local') {
            return redirect()->route('local.auth');
        }
        return Socialite::driver('keycloak')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $user = Socialite::driver('keycloak')->user();
        
        $idToken = $user->token;
        
        $this->validateIdToken($idToken);

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser);

        return redirect()->to('/dashboard');
    }

    private function findOrCreateUser($user)
    {
        return User::firstOrCreate([
            'keycloak_id' => $user->id,
            'email' => $user->email
        ], [
            'name' => $user->name,
        ]);
    }

    private function validateIdToken($idToken)
    {
        $publicKey = file_get_contents(storage_path('oidc-public.key'));

        try {
            $decodedToken = JWT::decode($idToken, new Key($publicKey, 'RS256'));

            $this->assertValidToken($decodedToken);
    
            return $decodedToken;
    
        } catch (Exception $e) {
            throw new Exception('Token-Validierung fehlgeschlagen: ' . $e->getMessage());
        }
    }

    private function assertValidToken($decodedToken)
    {
        $now = time();

        if ($decodedToken->exp < $now) {
            throw new Exception('Token abgelaufen');
        }

        $expectedIssuer = env('KEYCLOAK_EXPECTED_ISSUER');
        if ($decodedToken->iss !== $expectedIssuer) {
            throw new Exception('Ungültiger Issuer');
        }

        $expectedAzp = env('KEYCLOAK_CLIENT_ID');
        if (!in_array($expectedAzp, (array) $decodedToken->azp)) {
            throw new Exception('Ungültige Client ID');
        }
    }
}
