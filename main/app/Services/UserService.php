<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    /**
     * Retrieves the currently authenticated user.
     *
     * @return User The authenticated user instance.
     */
    public function getUser(): User
    {
        return Auth::user();
    }
}
