<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStaffRequest;
use App\Http\Requests\ListStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Http\Requests\UpdateStaffStatusRequest;
use App\Http\Resources\StaffResource;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index(ListStaffRequest $request)
    {
        $this->authorizeRoles(
            $request,
            [
                UserType::ADMIN,
                UserType::MANAGER,
            ]
        );

        $query = User::query()
            ->with('userType');

        if ($request->filled('filter.active')) {

            $query->where(
                'is_active',
                $request->boolean('filter.active')
            );
        }

        if ($request->filled('filter.role')) {

            $query->whereHas(
                'userType',
                fn ($query) => $query->where(
                    'name',
                    $request->input('filter.role')
                )
            );
        }

        return StaffResource::collection(
            $query->paginate(
                $request->integer('per_page', 20)
            )
        );
    }

    public function show(Request $request, User $user)
    {
        $this->authorizeStaffOrSelf(
            $request,
            $user
        );

        return new StaffResource(
            $user->load('userType')
        );
    }

    public function store(CreateStaffRequest $request)
    {
        $this->authorizeRoles(
            $request,
            [
                UserType::ADMIN,
                UserType::MANAGER,
            ]
        );

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
            'user' => new StaffResource(
                $user->load('userType')
            ),
        ], 201);
    }

    public function update(UpdateStaffRequest $request, User $user)
    {
        $this->authorizeStaffOrSelf(
            $request,
            $user
        );

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name ?? null,
            'mobile' => $request->mobile,
            'user_type_id' => $request->user_type_id,
        ]);

        if (! empty($request->password)) {
            $user->update([
                'password' => Hash::make(
                    $request->password
                ),
            ]);
        }

        return response()->json([
            'message' => 'Staff created successfully',
            'user' => new StaffResource(
                $user->load('userType')
            ),
        ], 201);
    }

    public function updateStatus(
        UpdateStaffStatusRequest $request,
        User $user
    ): StaffResource {

        $this->authorizeRoles(
            $request,
            [
                UserType::ADMIN,
            ]
        );

        $user->update([
            'is_active' => $request->boolean('is_active'),
        ]);

        return new StaffResource(
            $user->fresh()->load('userType')
        );
    }
}
