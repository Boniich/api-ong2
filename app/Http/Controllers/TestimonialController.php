<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    private $testimonial;

    public function __construct(Testimonial $testimonial)
    {
        $this->testimonial = $testimonial;
    }


    /**
     *  @OA\Get(
     *      path="/api/v1/testimonials",
     *      tags={"Testimonials"},
     *      summary="Display a list of testmonials",
     *      @OA\Response(
     *          response=200,
     *          description="Testimonials retrived successfully",
     *           @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {{
     *                          "id": 1,
     *                          "name": "Juan Carlos",
     *                          "image": "testimonials/12345593.png",
     *                          "description": "Esta ONG Esta muy buena",
     *                      }
     *                  }),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="Testimonials retrived successfully"),
     *      ),
     *  ),
     * )
     * 
     */

    public function index()
    {
        return $this->testimonial->getAllTestimonials();
    }


    /**
     *  @OA\Get(
     *      path="/api/v1/testimonials/{id}",
     *      tags={"Testimonials"},
     *      summary="Display a testimonial by id",
     *  
     *      @OA\Parameter(
     *          description="id of testimonial",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Testimonial retrived successfully",
     *      @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Juan Carlos",
     *                          "image": "testimonials/12345593.png",
     *                          "description": "Esta ONG Esta muy buena",
     *                      }
     *                  ),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="Testimonial retrived successfully"),
     *      ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Testimonial not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Testimonial not found"),
     *              ),
     *          ),
     *      )
     *  )
     * 
     */

    public function show($id)
    {
        return $this->testimonial->getOneTestimonialById($id);
    }


    /**
     *  @OA\Post(
     *      path="/api/v1/testimonials",
     *      tags={"Testimonials"},
     *      summary="Create a new testimonial",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema( 
     *		        @OA\Property(
     *                     description="name of person",
     *                     property="name",
     *                     type="string",
     *                     format="string",
     *                 ),
     *              @OA\Property(
     *                     description="image to upload",
     *                     property="image",
     *                     type="file",
     *                     format="file",
     *                 ),
     *              @OA\Property(
     *                     description="description",
     *                     property="description",
     *                     type="string",
     *                     format="string",
     *                 ),
     *             ),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Testimonial created successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Juan Carlos",
     *                          "image": "testimonials/12345593.png",
     *                          "description": "Esta ONG Esta muy buena",
     *                      }
     *                  ),
     *              @OA\Property(property="message", type="string", format="string", example="Testimonial created successfully"),
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
        return $this->testimonial->storeOneTestimonial($request);
    }

    /**
     *  @OA\Put(
     *      path="/api/v1/testimonials/{id}",
     *      tags={"Testimonials"},
     *      summary="Update a testimoanial by id",
     * 
     *      @OA\Parameter(
     *          description="id of testimonial",
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
     *          description="Testimonial updated successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Juan Carlos",
     *                          "image": "testimonials/12345593.png",
     *                          "description": "Esta ONG Esta muy buena",
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="Testimonial updated successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Testimonial not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Testimonial not found"),
     *          ),
     *      )
     *  )
     */

    public function update(Request $request, $id)
    {
        return $this->testimonial->updateOneTestimonial($request, $id);
    }

    /**
     *  @OA\Delete(
     *      path="/api/v1/testimonials/{id}",
     *      tags={"Testimonials"},
     *      summary="Delete a testimonial",
     * 
     *      @OA\Parameter(
     *          description="id of testimonial",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Testimonial deleted successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Juan Carlos",
     *                          "image": "testimonials/12345593.png",
     *                          "description": "Esta ONG Esta muy buena",
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="Testimonial deleted successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Testimonial not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Testimonial not found"),
     *          ),
     *      )
     *  )
     */

    public function destroy($id)
    {
        return $this->testimonial->destroyTestimonial($id);
    }
}
