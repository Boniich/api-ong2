<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return $this->user->getAllUsers();
    }

    public function show($id)
    {
        return $this->user->getOneUserById($id);
    }

    public function store(Request $request)
    {
        return $this->user->storeOneUser($request);
    }

    public function update(Request $request, $id)
    {
        return $this->user->updateOneUser($request, $id);
    }

    public function destroy($id)
    {
        return $this->user->destroyOneUser($id);
    }
}
