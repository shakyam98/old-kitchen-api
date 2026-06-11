<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaffLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffAuthController extends Controller
{
    public function login(StaffLoginRequest $request)
    {
        $user = User::query()
            ->where('mobile', $request->mobile)
            ->first();

        if (
            ! $user ||
            ! $user->is_active ||
            ! Hash::check(
                $request->password,
                $user->password
            )
        ) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user
            ->createToken(
                'staff-token',
                ['staff']
            )
            ->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
        ]);
    }
}
