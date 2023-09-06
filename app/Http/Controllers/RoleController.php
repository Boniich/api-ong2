<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class RoleController extends Controller
{
    private string $modelNotFound = "Role not found";

    public function __construct()
    {
        $this->middleware('can:roles');
    }

    public function index()
    {
        $roles = Role::all();

        return okResponse200($roles, "Roles retrived successfully");
    }

    public function show($id)
    {
        try {
            $role = Role::findOrFail($id);

            return okResponse200($role, 'Role retrived successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $role = Role::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string'
            ]);

            if ($validator->fails()) {
                throw new BadRequestException;
            }

            $role->name = $request->name;
            $role->update();

            return okResponse200($role, 'Role updated successfully');
        } catch (BadRequestException $th) {
            return badRequestResponse400();
        } catch (ModelNotFoundException) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }
}
