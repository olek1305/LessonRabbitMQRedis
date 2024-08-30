<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index(): string
    {
        return User::all();
    }
}
