<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ManyPolicy
{
    use HandlesAuthorization;

    // Phân quyền báo giá
    public function listQuotes(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.access.list-quote'));
    }
    public function checkboxQuotes(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.access.checkbox-quote'));
    }

    // Phân quyền setting website
    public function settingEdit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.access.setting-edit'));
    }
}