<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register(Request $request)
    {
        return $this->user->register($request);
    }

    public function login(Request $request)
    {
        return $this->user->login($request);
    }
}
