<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private Category $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/categories",
     *      tags={"Categories"},
     *      summary="Display a list of categories",
     *      @OA\Response(
     *          response=200,
     *          description="Categories retrived successfully",
     *           @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {{
     *                          "id": 1,
     *                          "name": "Category",
     *                          "description": "Description of category",
     *                          "image": "categories/12345593.png",
     *                      }
     *                  }),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="Categories retrived successfully"),
     *      ),
     *  ),
     * 
     * )
     * 
     */

    public function index()
    {
        return $this->category->getAllCategories();
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/categories/{id}",
     *      tags={"Categories"},
     *      summary="Display a category by id",
     *      security={{"sanctum":{}}},
     *  
     *      @OA\Parameter(
     *          description="id of category",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Category retrived successfully",
     *      @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Category",
     *                          "description": "Description of category",
     *                          "image": "categories/12345593.png",
     *                      }
     *                  ),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="Category retrived successfully"),
     *      ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Category not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Category not found"),
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
        return $this->category->getOneCategory($id);
    }

    /**
     *  @OA\Post(
     *      path="/api/v1/categories",
     *      tags={"Categories"},
     *      summary="Create a new category",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema( 
     *  	    @OA\Property(
     *                     description="name of category",
     *                     property="name",
     *                     type="string",
     *                     format="string",
     *                 ),
     *               @OA\Property(
     *                     description="description of category",
     *                     property="description",
     *                     type="string",
     *                     format="string",
     *                 ),
     *              @OA\Property(
     *                     description="image of category",
     *                     property="image",
     *                     type="file",
     *                     format="file",
     *                 ),
     *             ),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=201,
     *          description="Category created successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Category",
     *                          "description": "Description of category",
     *                          "image": "categories/12345593.png",
     *                      }
     *                  ),
     *              @OA\Property(property="message", type="string", format="string", example="Category created successfully"),
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
        return $this->category->storeOneCategory($request);
    }

    /**
     *  @OA\Put(
     *      path="/api/v1/categories/{id}",
     *      tags={"Categories"},
     *      summary="Update a category by id",
     *      security={{"sanctum":{}}},
     * 
     *      @OA\Parameter(
     *          description="id of category",
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
     *          description="Category updated successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Category",
     *                          "description": "Description of category",
     *                          "image": "categories/12345593.png",
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="Category updated successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Category not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Category not found"),
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
        return $this->category->updateOneCategory($request, $id);
    }


    /**
     *  @OA\Delete(
     *      path="/api/v1/categories/{id}",
     *      tags={"Categories"},
     *      summary="Delete a category",
     *      security={{"sanctum":{}}},
     * 
     *      @OA\Parameter(
     *          description="id of category",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Category deleted successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "Category",
     *                          "description": "Description of category",
     *                          "image": "categories/12345593.png",
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="Category deleted successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Category not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Category not found"),
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
        return $this->category->destroyOneCategory($id);
    }
}
