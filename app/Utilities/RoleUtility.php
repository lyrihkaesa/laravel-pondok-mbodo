<?php

namespace App\Utilities;

use Spatie\Permission\Models\Role;

class RoleUtility
{
    public static function getNameOptions()
    {
        /**
         * @var \App\Models\User $authUser
         */
        $authUser = auth('web')->user();

        $roles = Role::query();

        if (!$authUser->hasRole('super_admin')) {
            // Jika user bukan admin, tambahkan whereNotIn untuk menghindari super_admin
            $roles->whereNotIn('name', ['super_admin']);
        }

        return $roles->pluck('name', 'id')
            ->map(function ($name) {
                return str($name)->replace('_', ' ')->title();
            });
    }
}
