<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class Controller
{
    protected function authorizeRoles(Request $request, array $roles): void
    {
        if (! in_array(
            $request->user()->userType->name,
            $roles
        )) {
            throw new HttpException(
                403,
                'Forbidden'
            );
        }
    }

    protected function authorizeStaffOrSelf(Request $request, User $user): void
    {
        $isPrivileged = in_array(
            $request->user()->userType->name,
            [
                UserType::ADMIN,
                UserType::MANAGER,
            ]
        );

        $isSelf = $request->user()->id === $user->id;

        if (! $isPrivileged && ! $isSelf) {
            throw new HttpException(403, 'Forbidden');
        }
    }
}
