<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     *  @OA\Get(
     *      path="/api/v1/comments",
     *      tags={"Comments"},
     *      summary="Display a list of comments",
     *      @OA\Response(
     *          response=200,
     *          description="Comments retrived successfully",
     *           @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {{
     *                          "id": 1,
     *                          "text": "text in a comment",
     *                          "image": "comments/12345.png",
     *                          "active": true,
     *                          "user_id": 1,
     *                          "news_id": 1,
     *                      }
     *                  }),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="Comments retrived successfully"),
     *      ),
     *  ),
     * )
     * 
     */

    public function index()
    {
        return $this->comment->getAllComments();
    }


    /**
     *  @OA\Get(
     *      path="/api/v1/comments/{id}",
     *      tags={"Comments"},
     *      summary="Display a comment by id",
     *      security={{"sanctum":{}}},
     *  
     *      @OA\Parameter(
     *          description="id of comment",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Comment retrived successfully",
     *      @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *              @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "text": "text in a comment",
     *                          "image": "comments/12345.png",
     *                          "active": true,
     *                          "user_id": 1,
     *                          "news_id": 1,
     *				            "user":{
     *                               "id": 1,
     *                               "name": "Boniich",
     *                               "email": "boniich@gmail.com",
     *                               "address": "901 Collier Forks",
     *                               "profile_image": null,
     *                           },
     *                          "news_id":{
     *                                    "id":  1,
     *                                    "name": "news name",
     *                                    "slug": "Sapiente impedit dolores.",
     *                                    "content": "Iste necessitatibus quia qui.",
     *                                    "image": "news/12345.png",
     *                                    "user_id": 1,
     *                                    "category_id": 1,
     *                          },
     * },
     *                  ),
     *              
     *              @OA\Property(property="message", type="string", format="string", example="Comment retrived successfully"),
     *      ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Comment not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Comment not found"),
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
        return $this->comment->getOneComment($id);
    }

    /**
     *  @OA\Post(
     *      path="/api/v1/comments",
     *      tags={"Comments"},
     *      summary="Create a comment",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema( 
     *  	    @OA\Property(
     *                     description="text of comment",
     *                     property="text",
     *                     type="string",
     *                     format="string",
     *                 ),
     *              @OA\Property(
     *                     description="image of comments",
     *                     property="image",
     *                     type="file",
     *                     format="file",
     *                 ),
     *            @OA\Property(
     *                     description="ID of news",
     *                     property="news_id",
     *                     type="integer",
     *                     format="integer",
     *                 ),
     *             ),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=201,
     *          description="Comment created successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "text": "text in a comment",
     *                          "image": "comments/12345.png",
     *                          "active": true,
     *                          "user_id": 1,
     *                          "news_id": 1,
     *                      }
     *                  ),
     *              @OA\Property(property="message", type="string", format="string", example="Comment created successfully"),
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
     *          description="News ID not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "News ID not found"),
     *          ),
     *      )
     *   )
     * 
     */

    public function store(Request $request)
    {
        return $this->comment->storeOneComment($request);
    }


    /**
     *  @OA\Put(
     *      path="/api/v1/comments/{id}",
     *      tags={"Comments"},
     *      summary="Update a comment by id",
     *      security={{"sanctum":{}}},
     * 
     *      @OA\Parameter(
     *          description="id of comment",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="text", type="string", format="string"),
     *              @OA\Property(property="active", type="boolean", format="boolean"),
     *              @OA\Property(property="news_id", type="integer", format="integer"),
     *      ),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Comment updated successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "text": "text in a comment",
     *                          "image": "comments/12345.png",
     *                          "active": true,
     *                          "user_id": 1,
     *                          "news_id": 1,
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="Comment updated successfully"),
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
     *          description="Comment not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Comment not found"),
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
        return $this->comment->updateOneComment($request, $id);
    }


    /**
     *  @OA\Delete(
     *      path="/api/v1/comments/{id}",
     *      tags={"Comments"},
     *      summary="Delete a comment",
     *      security={{"sanctum":{}}},
     * 
     *      @OA\Parameter(
     *          description="id of comment",
     *          in="path",
     *          name="id",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Comment deleted successfully",
     *          @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", format="boolean", example="true"),
     *             @OA\Property(property="data", type="string", example= 
     *                     {
     *                          "id": 1,
     *                          "text": "text in a comment",
     *                          "image": "comments/12345.png",
     *                          "active": true,
     *                          "user_id": 1,
     *                          "news_id": 1,
     *                      }
     *                  ),
     *            @OA\Property(property="message", type="string", format="string", example="Comment deleted successfully"),
     *      ),  
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Comment not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", format="boolean", example="false"),
     *              @OA\Property(property="error", type="string", example= "Comment not found"),
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
        return $this->comment->destroyOneComment($id);
    }
}
