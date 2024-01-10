<?php

namespace App\Http\Controllers\Application\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\Application\User;
use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GenerateDeviceToken extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email:filter', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ]);

        try {
            $user = User::where('email', $data['email'])->firstOrFail();
        } catch (ModelNotFoundException) {
            return $this->failedResponse();
        }

        if (!Hash::check($data['password'], $user->password)) {
            return $this->failedResponse();
        }

        $tokenId = uniqid(more_entropy: true);

        $token = $user->createToken($tokenId)->plainTextToken;

        return response()->json([
            [
                'id'    => $tokenId,
                'token' => $token,
            ],
        ]);
    }

    private function failedResponse(): JsonResponse
    {
        return response()->json([
            'message' => 'Login ou senha incorretos',
        ], 401);
    }
}
