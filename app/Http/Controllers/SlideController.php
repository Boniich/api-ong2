<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    private Slide $slide;

    public function __construct(Slide $slide)
    {
        $this->slide = $slide;
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/slides",
     *      tags={"Slides"},
     *      summary="Display a list of slides",
     *      @OA\Response(
     *          response=200,
     *          description="Slides retrived successfully",
     *           @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {{
     *                          "id": 1,
     *                          "name": "Slide",
     *                          "description": "Description of slide",
     *                          "image": "slides/12345593.png",
     *                          "user_id": 1,
     *				            "users":{
     *                               "id": 1,
     *                               "name": "Boniich",
     *                               "email": "boniich@gmail.com",
     *                               "address": "901 Collier Forks",
     *                               "profile_image": null,
     *                           },
     *                      }
     *                  }),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="Slides retrived successfully"),
     *      ),
     *  ),
     * 
     * )
     * 
     */

    public function index()
    {
        return $this->slide->getAllSlides();
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/slides/{id}",
     *      tags={"Slides"},
     *      summary="Display a slide by id",
     *      security={{"sanctum":{}}},
     *  
     *      @OA\Parameter(
     *          description="id of slide",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Slide retrived successfully",
     *      @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Slide",
     *                          "description": "Description of slide",
     *                          "image": "slides/12345593.png",
     *                          "user_id": 1,
     *				            "users":{
     *                               "id": 1,
     *                               "name": "Boniich",
     *                               "email": "boniich@gmail.com",
     *                               "address": "901 Collier Forks",
     *                               "profile_image": null,
     *                           },
     *                      }
     *                  ),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="Slide retrived successfully"),
     *      ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Slide not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Slide not found"),
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
        return $this->slide->getOneSlideById($id);
    }

    /**
     *  @OA\Post(
     *      path="/api/v1/slides",
     *      tags={"Slides"},
     *      summary="Create a new slide",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema( 
     *  	    @OA\Property(
     *                     description="name of slide",
     *                     property="name",
     *                     type="string",
     *                     format="string",
     *                 ),
     *               @OA\Property(
     *                     description="description of slide",
     *                     property="description",
     *                     type="string",
     *                     format="string",
     *                 ),
     *              @OA\Property(
     *                     description="image of slide",
     *                     property="image",
     *                     type="file",
     *                     format="file",
     *                 ),
     *             ),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=201,
     *          description="Slide created successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Slide",
     *                          "description": "Description of slide",
     *                          "image": "slides/12345593.png",
     *                          "user_id": 1,
     *                      }
     *                  ),
     *              @OA\Property(property="message", type="string", format="string", example="Slide created successfully"),
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
     *      )
     *   )
     * 
     */

    public function store(Request $request)
    {
        return $this->slide->storeOneSlide($request);
    }

    /**
     *  @OA\Put(
     *      path="/api/v1/slides/{id}",
     *      tags={"Slides"},
     *      summary="Update a slide by id",
     *      security={{"sanctum":{}}},
     * 
     *      @OA\Parameter(
     *          description="id of slide",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", format="string"),
     *              @OA\Property(property="description", type="string", format="string"),
     *      ),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Slide updated successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Slide",
     *                          "description": "Description of slide",
     *                          "image": "slides/12345593.png",
     *                          "user_id": 1,
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="Slide updated successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Slide not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Slide not found"),
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
        return $this->slide->updateOneSlide($request, $id);
    }

    /**
     *  @OA\Delete(
     *      path="/api/v1/slides/{id}",
     *      tags={"Slides"},
     *      summary="Delete a slide",
     *      security={{"sanctum":{}}},
     * 
     *      @OA\Parameter(
     *          description="id of slide",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Slide deleted successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Slide",
     *                          "description": "Description of slide",
     *                          "image": "slides/12345593.png",
     *                          "user_id": 1,
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="Slide deleted successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Slide not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Slide not found"),
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
        return $this->slide->destroyOneSlide($id);
    }
}
