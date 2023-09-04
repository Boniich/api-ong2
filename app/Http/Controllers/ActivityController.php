<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    private Activity $activity;

    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/activities",
     *      tags={"Activities"},
     *      summary="Display a list of activities",
     *      @OA\Response(
     *          response=200,
     *          description="Activities retrived successfully",
     *           @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {{
     *                          "id": 1,
     *                          "name": "Activity",
     *                          "slug": "Activity slug",
     *                          "description": "This is an activity",
     *                          "image": null,
     *                          "user_id": 1,
     *                          "category_id": null,
     *                      }
     *                  }),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="News retrived successfully"),
     *      ),
     *  ),
     * 
     * )
     * 
     */

    public function index()
    {
        return $this->activity->getAllActivities();
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/activities/{id}",
     *      tags={"Activities"},
     *      summary="Display a activity by id",
     *      security={{"sanctum":{}}},
     *  
     *      @OA\Parameter(
     *          description="id of activity",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Activity retrived successfully",
     *      @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Activity",
     *                          "slug": "Activity slug",
     *                          "description": "This is an activity",
     *                          "image": null,
     *                          "user_id": 1,
     *                          "category_id": null,
     *				            "user":{
     *                               "id": 1,
     *                               "name": "Boniich",
     *                               "email": "boniich@gmail.com",
     *                               "address": "901 Collier Forks",
     *                               "profile_image": null,
     *                           },
     *                          "category": null,
     *                      }
     *                  ),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="Activity retrived successfully"),
     *      ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Activity not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Activity not found"),
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
     *      )
     *      )
     *  )
     * 
     */

    public function show($id)
    {
        return $this->activity->getOneActivity($id);
    }

    /**
     *  @OA\Post(
     *      path="/api/v1/activities",
     *      tags={"Activities"},
     *      summary="Create a new activity",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema( 
     *  	    @OA\Property(
     *                     description="name of activity",
     *                     property="name",
     *                     type="string",
     *                     format="string",
     *                 ),
     *                @OA\Property(
     *                     description="slug of activity",
     *                     property="slug",
     *                     type="string",
     *                     format="string",
     *                 ),
     *               @OA\Property(
     *                     description="description of activity",
     *                     property="description",
     *                     type="string",
     *                     format="string",
     *                 ),
     *              @OA\Property(
     *                     description="image of activity",
     *                     property="image",
     *                     type="file",
     *                     format="file",
     *                 ),
     *            @OA\Property(
     *                     description="ID of category",
     *                     property="category_id",
     *                     type="integer",
     *                     format="integer",
     *                 ),
     *             ),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=201,
     *          description="Activity created successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Activity",
     *                          "slug": "Activity slug",
     *                          "description": "This is an activity",
     *                          "image": null,
     *                          "user_id": 1,
     *                          "category_id": null,
     *                      }
     *                  ),
     *              @OA\Property(property="message", type="string", format="string", example="Activity created successfully"),
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
     *          description="User is not authenticated",
     *          @OA\JsonContent(
     *	            @OA\Property(property="status_code", type="integer", format="integer", example="401"),
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Unauthenticated"),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=404,
     *          description="Category ID not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Category ID not found"),
     *          ),
     *      )
     *   )
     * 
     */

    public function store(Request $request)
    {
        return $this->activity->storeOneActivity($request);
    }

    /**
     *  @OA\Put(
     *      path="/api/v1/activities/{id}",
     *      tags={"Activities"},
     *      summary="Update an activity by id",
     *      security={{"sanctum":{}}},
     * 
     *      @OA\Parameter(
     *          description="id of activity",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", format="string"),
     *              @OA\Property(property="slug", type="string", format="string"),
     *              @OA\Property(property="description", type="string", format="string"),
     *              @OA\Property(property="category_id", type="integer", format="integer"),
     *      ),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Activity updated successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Activity",
     *                          "slug": "Activity slug",
     *                          "description": "This is an activity",
     *                          "image": null,
     *                          "user_id": 1,
     *                          "category_id": null,
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="Activity updated successfully"),
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
     *          description="Activity not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Activity not found"),
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
     *      )
     *  )
     */

    public function update(Request $request, $id)
    {
        return $this->activity->updateOneActivity($request, $id);
    }

    /**
     *  @OA\Delete(
     *      path="/api/v1/activities/{id}",
     *      tags={"Activities"},
     *      summary="Delete an activity",
     *      security={{"sanctum":{}}},
     * 
     *      @OA\Parameter(
     *          description="id of activity",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Activity deleted successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Activity",
     *                          "slug": "Activity slug",
     *                          "description": "This is an activity",
     *                          "image": null,
     *                          "user_id": 1,
     *                          "category_id": null,
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="Activity deleted successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Activity not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Activity not found"),
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
     *      )
     *  )
     */

    public function destroy($id)
    {
        return $this->activity->destroyOneActivity($id);
    }
}
