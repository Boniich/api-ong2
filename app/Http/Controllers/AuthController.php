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

    /**
     * Register a new user.
     * @OA\Post(
     *      path="/api/v1/register",
     *      summary="Register a new user",
     *      tags={"Auth"},
     * 
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *          required={"name","email","password","password_confirmation"},
     *          @OA\Property(property="name", type="string", format="string"),
     *          @OA\Property(property="email", type="string", format="string"),
     *          @OA\Property(property="password", type="string", format="string" ),
     *          @OA\Property(property="password_confirmation", type="string", format="string" ),
     *                    ),
     *              ),
     *      @OA\Response(
     *          response=200,
     *          description="User register successfully",
     *           @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {{
     *                          "id": 1,
     *                          "name": "Boniich",
     *                          "email": "boniich@gmail.com",
     *                      }
     *                  }),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="User register successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="bad request",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Bad Request"),
     *          ),  
     *      ),
     * )
     */


    public function register(Request $request)
    {
        return $this->user->register($request);
    }

    /**
     * Login User.
     * @OA\Post(
     *      path="/api/v1/login",
     *      summary="Login user",
     *      tags={"Auth"},
     * 
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *          required={"email","password"},
     *          @OA\Property(property="email", type="string", format="string"),
     *          @OA\Property(property="password", type="string", format="string" ),
     *                    ),
     *              ),
     *      @OA\Response(
     *          response=200,
     *          description="User login successfully",
     *	    @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Boniich",
     *                          "email": "boniich@gmail.com",
     *                          "email_verified_at": "null",
     *                          "address": "null",
     *                          "profile_image": "null",
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="User deleted successfully"),
     *      ),    
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="bad request",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Bad Request"),
     *          ),  
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Invalid Credentials",
     *		@OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Invalid Credentials"),
     *          ),  
     *		
     *      )
     * )
     */

    public function login(Request $request)
    {
        return $this->user->login($request);
    }
}
