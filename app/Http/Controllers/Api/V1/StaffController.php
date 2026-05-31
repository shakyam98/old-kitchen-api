<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStaffRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function store(CreateStaffRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name ?? null,
            'mobile' => $request->mobile,
            'password' => Hash::make(
                $request->password
            ),
            'user_type_id' => $request->user_type_id,
        ]);

        return response()->json([
            'message' => 'Staff created successfully',
            'user' => $user,
        ], 201);
    }
}
