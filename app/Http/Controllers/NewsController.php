<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private News $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/news",
     *      tags={"News"},
     *      summary="Display a list of news",
     *      @OA\Response(
     *          response=200,
     *          description="News retrived successfully",
     *           @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {{
     *                          "id": 1,
     *                          "name": "News",
     *                          "slug": "News slug",
     *                          "content": "This is a News",
     *                          "image": null,
     *                          "user_id": 1,
     *                          "category_id": null,
     *                      }
     *                  }),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="News retrived successfully"),
     *      ),
     *  ),
     * )
     * 
     */

    public function index()
    {
        return $this->news->getAllNews();
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/news/{id}",
     *      tags={"News"},
     *      summary="Display a news by id",
     *      security={{"sanctum":{}}},
     *  
     *      @OA\Parameter(
     *          description="id of news",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="News retrived successfully",
     *      @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "News",
     *                          "slug": "News slug",
     *                          "content": "This is an News",
     *                          "image": "news/12346.png",
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
     *              @OA\Property(property="message", type="string", format="string", example="News retrived successfully"),
     *      ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="News not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "News not found"),
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
        return $this->news->getOneNews($id);
    }

    /**
     *  @OA\Post(
     *      path="/api/v1/news",
     *      tags={"News"},
     *      summary="Create a new news",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema( 
     *  	    @OA\Property(
     *                     description="name of news",
     *                     property="name",
     *                     type="string",
     *                     format="string",
     *                 ),
     *                @OA\Property(
     *                     description="slug of news",
     *                     property="slug",
     *                     type="string",
     *                     format="string",
     *                 ),
     *               @OA\Property(
     *                     description="content of news",
     *                     property="content",
     *                     type="string",
     *                     format="string",
     *                 ),
     *              @OA\Property(
     *                     description="image of news",
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
     *          description="News created successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "News",
     *                          "slug": "News slug",
     *                          "content": "This is a News",
     *                          "image": null,
     *                          "user_id": 1,
     *                          "category_id": null,
     *                      }
     *                  ),
     *              @OA\Property(property="message", type="string", format="string", example="News created successfully"),
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
        return $this->news->storeOnewNews($request);
    }


    /**
     *  @OA\Put(
     *      path="/api/v1/news/{id}",
     *      tags={"News"},
     *      summary="Update a news by id",
     *      security={{"sanctum":{}}},
     * 
     *      @OA\Parameter(
     *          description="id of news",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", format="string"),
     *              @OA\Property(property="slug", type="string", format="string"),
     *              @OA\Property(property="content", type="string", format="string"),
     *              @OA\Property(property="category_id", type="integer", format="integer"),
     *      ),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="News updated successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "News",
     *                          "slug": "News slug",
     *                          "content": "This is a News",
     *                          "image": null,
     *                          "user_id": 1,
     *                          "category_id": null,
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="News updated successfully"),
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
     *          description="News not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "News not found"),
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
        return $this->news->updateOneNews($request, $id);
    }


    /**
     *  @OA\Delete(
     *      path="/api/v1/news/{id}",
     *      tags={"News"},
     *      summary="Delete a news",
     *      security={{"sanctum":{}}},
     * 
     *      @OA\Parameter(
     *          description="id of news",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="News deleted successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "name": "News",
     *                          "slug": "News slug",
     *                          "content": "This is a News",
     *                          "image": null,
     *                          "user_id": 1,
     *                          "category_id": null,
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="News deleted successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="News not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "News not found"),
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
        return $this->news->destroyOneNews($id);
    }
}
