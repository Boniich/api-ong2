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

    /**
     *  @OA\Get(
     *      path="/api/v1/roles",
     *      tags={"Roles"},
     *      summary="Display a list of roles",
     *      security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Roles retrived successfully",
     *           @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {{
     *                          "id": 1,
     *                          "name": "Admin",
     *                          "guard_name": "web",
     *                          "created_at": "2023-06-17T18:25:26.000000Z",
     *                          "updated_at": "2023-06-17T18:25:26.000000Z"
     *                      }
     *                  }),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="Roles retrived successfully"),
     *      ),
     *  ),
     *     @OA\Response(
     *          response=401,
     *          description="User is not authenticated",
     *          @OA\JsonContent(
     *	            @OA\Property(property="status_code", type="integer", format="integer", example="401"),
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Unauthenticated"),
     *          ),
     *      ),
     *    @OA\Response(
     *          response=403,
     *          description="Return a error if user does not have the correct authorization",
     *          @OA\JsonContent(
     *	            @OA\Property(property="status_code", type="integer", format="integer", example="403"),
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "You do not have the required authorization"),
     *          ),
     *      ),
     * )
     * 
     */

    public function index()
    {
        $roles = Role::all();

        return okResponse200($roles, "Roles retrived successfully");
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/roles/{id}",
     *      tags={"Roles"},
     *      summary="Display a role by id",
     *      security={{"sanctum":{}}},
     *  
     *      @OA\Parameter(
     *          description="id of role",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Role retrived successfully",
     *      @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Admin",
     *                          "guard_name": "web",
     *                          "created_at": "2023-06-17T18:25:26.000000Z",
     *                          "updated_at": "2023-06-17T18:25:26.000000Z"
     *                      }
     *                  ),
     *              @OA\Property(property="message", type="string", format="string", example="Role retrived successfully"),
     *      ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Role not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Role not found"),
     *              ),
     *          ),
     * 
     *      @OA\Response(
     *          response=401,
     *          description="User is not authenticated",
     *          @OA\JsonContent(
     *	            @OA\Property(property="status_code", type="integer", format="integer", example="401"),
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Unauthenticated"),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=403,
     *          description="Return a error if user does not have the correct authorization",
     *          @OA\JsonContent(
     *	            @OA\Property(property="status_code", type="integer", format="integer", example="403"),
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "You do not have the required authorization"),
     *          ),
     *      ),
     *      )
     *  )
     * 
     */

    public function show($id)
    {
        try {
            $role = Role::findOrFail($id);

            return okResponse200($role, 'Role retrived successfully');
        } catch (ModelNotFoundException $th) {
            return modelNotFoundResponse($this->modelNotFound);
        }
    }


    /**
     *  @OA\Put(
     *      path="/api/v1/roles/{id}",
     *      tags={"Roles"},
     *      summary="Update a role by id",
     *      security={{"sanctum":{}}},
     * 
     *      @OA\Parameter(
     *          description="id of role",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", format="string"),
     *      ),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Role updated successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Admin",
     *                          "guard_name": "web",
     *                          "created_at": "2023-06-17T18:25:26.000000Z",
     *                          "updated_at": "2023-06-17T18:25:26.000000Z"
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="Role updated successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Bad Request"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Role not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Role not found"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="User is not authenticated",
     *          @OA\JsonContent(
     *	            @OA\Property(property="status_code", type="integer", format="integer", example="401"),
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Unauthenticated"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Return a error if user does not have the correct authorization",
     *          @OA\JsonContent(
     *	            @OA\Property(property="status_code", type="integer", format="integer", example="403"),
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "You do not have the required authorization"),
     *          ),
     *      ),
     *  )
     */


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
