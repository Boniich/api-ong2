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

    /**
     *  @OA\Get(
     *      path="/api/v1/users",
     *      tags={"Users"},
     *      summary="Display a list of users",
     *      @OA\Response(
     *          response=200,
     *          description="Users retrived successfully",
     *           @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {{
     *                          "id": 1,
     *                          "name": "Claudia Perez",
     *                          "email": "clau@gmail.com",
     *                          "email_verified_at": "2023-08-15T10:46:57.000000Z",
     *                          "address": "calle false 123",
     *                          "profile_image": "users/123456.png",
     *                          "slides": {},
     *                      }
     *                  }),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="Users retrived successfully"),
     *      ),
     *  ),
     * )
     * 
     */

    public function index()
    {
        return $this->user->getAllUsers();
    }


    /**
     *  @OA\Get(
     *      path="/api/v1/users/{id}",
     *      tags={"Users"},
     *      summary="Display a user by id",
     *  
     *      @OA\Parameter(
     *          description="id of user",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User retrived successfully",
     *      @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Claudia Perez",
     *                          "email": "clau@gmail.com",
     *                          "email_verified_at": "2023-08-15T10:46:57.000000Z",
     *                          "address": "calle false 123",
     *                          "profile_image": "users/123456.png",
     *                          "slides": {},
     *                      }
     *                  ),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="User retrived successfully"),
     *      ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "User not found"),
     *              ),
     *          ),
     *      )
     *  )
     * 
     */

    public function show($id)
    {
        return $this->user->getOneUserById($id);
    }

    /**
     *  @OA\Post(
     *      path="/api/v1/users",
     *      tags={"Users"},
     *      summary="Create a new user",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema( 
     *		   @OA\Property(
     *                     description="name of person",
     *                     property="name",
     *                     type="string",
     *                     format="string",
     *                 ),
     *              @OA\Property(
     *                     description="email",
     *                     property="email",
     *                     type="string",
     *                     format="string",
     *                 ),
     *              @OA\Property(
     *                     description="password",
     *                     property="password",
     *                     type="string",
     *                     format="string",
     *                 ),
     *              @OA\Property(
     *                     description="address",
     *                     property="address",
     *                     type="string",
     *                     format="string",
     *                 ),
     *              @OA\Property(
     *                     description="profile image",
     *                     property="profile_image",
     *                     type="file",
     *                     format="file",
     *                 ),
     *             ),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="User created successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Claudia Perez",
     *                          "email": "clau@gmail.com",
     *                          "email_verified_at": "2023-08-15T10:46:57.000000Z",
     *                          "address": "calle false 123",
     *                          "profile_image": "users/123456.png",
     *                      }
     *                  ),
     *              @OA\Property(property="message", type="string", format="string", example="User created successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="bad request",  
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Bad Request"),
     *          ),
     *      )
     *   )
     * 
     */

    public function store(Request $request)
    {
        return $this->user->storeOneUser($request);
    }

    /**
     *  @OA\Put(
     *      path="/api/v1/users/{id}",
     *      tags={"Users"},
     *      summary="Update a user by id",
     * 
     *      @OA\Parameter(
     *          description="id of user",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", format="string"),
     *              @OA\Property(property="email", type="string", format="string"),
     *              @OA\Property(property="password", type="string", format="string"),
     *              @OA\Property(property="address", type="string", format="string"),
     *      ),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="User updated successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Claudia Perez",
     *                          "email": "clau@gmail.com",
     *                          "email_verified_at": "2023-08-15T10:46:57.000000Z",
     *                          "address": "calle false 123",
     *                          "profile_image": "users/123456.png",
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="User updated successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "User not found"),
     *          ),
     *      )
     *  )
     */

    public function update(Request $request, $id)
    {
        return $this->user->updateOneUser($request, $id);
    }

    /**
     *  @OA\Delete(
     *      path="/api/v1/users/{id}",
     *      tags={"Users"},
     *      summary="Delete a user",
     * 
     *      @OA\Parameter(
     *          description="id of user",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="User deleted successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Claudia Perez",
     *                          "email": "clau@gmail.com",
     *                          "email_verified_at": "2023-08-15T10:46:57.000000Z",
     *                          "address": "calle false 123",
     *                          "profile_image": "users/123456.png",
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="User deleted successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "User not found"),
     *          ),
     *      )
     *  )
     */

    public function destroy($id)
    {
        return $this->user->destroyOneUser($id);
    }
}
